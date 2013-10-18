<?php
/**
 * CASE Uploader
 * 本ファイルをapache書き込み権限の存在する場所に配置してください。
 * ファイルのカレントディレクトリに[data]ディレクトリが作成され、そこにアップロードファイルが生成されます。
 * SQLite3, php5.3以上
 *
 * @version    0.5
 * @author     sawa@CASE Inc.
 * @license    MIT License
 * @copyright  2013 CASE Inc.
 * @link       http://caseinc.jp
 */

error_reporting(-1);
ini_set('display_errors', 1);

define('DOCROOT', __DIR__.DIRECTORY_SEPARATOR);
define('UPLOADPATH', realpath(__DIR__.DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR);
define('DBPATH', __DIR__.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'sqlitedb');

define('TPL_DOWNLOAD', __DIR__.DIRECTORY_SEPARATOR.'tpl'.DIRECTORY_SEPARATOR.'download.tpl');


//try to set the maximum execution time to 60min
set_time_limit(3600);
@ini_set('max_execution_time', 3600);
@ini_set('max_input_time', 3600);

//try to set the maximum filesize to 10G
@ini_set('upload_max_filesize', 100 * 1024 * 1024);
@ini_set('post_max_size', 100 * 1024 * 1024);
@ini_set('file_uploads', '50');

create_dir(UPLOADPATH);
create_htaccess(UPLOADPATH);

try
{
	$db = new PDO("sqlite:".DBPATH);
	$sql = "CREATE TABLE IF NOT EXISTS files(id INTEGER PRIMARY KEY AUTOINCREMENT, filename VARCHAR(255), hash VARCHAR(255) UNIQUE, expire NUMERIC, created NUMERIC)";
	$db->exec($sql);
}
catch (Exception $e)
{
	print 'DBへの接続でエラーが発生しました。<br>';
	print $e->getTraceAsString();
	return false;
}

//バッチとして常に実行
delete_file($db);

init($db);

$db = null;
exit;

function init($db)
{
	if(isset($_GET['file']))
	{
		display_fileget($db, $_GET['file']);
	}
	else if(isset($_GET['download']))
	{
		tmplate_download($db, $_GET['download']);
	}
	else if($_FILES)
	{
		display_upload($db);
	}
	else
	{
		//upload画面表示
		print template_upload();
	}
}

//ファイルダウンロード実行
function display_fileget($db, $hash)
{
	try
	{
		$now = time();
		$sql = "SELECT * FROM files WHERE hash = \"$hash\" AND expire > $now;";
		$query = $db->query($sql);
		$result = $query->fetch();

		if(!$result)
		{
			page_not_found();
		}
		
		$filename = $result['filename'];
	}
	catch (Exception $e)
	{
		display_error($e->getTraceAsString());
		return false;
	}
	$sjis_filename = mb_convert_encoding($filename, "SJIS-win", "UTF-8");
	$filepath = get_upload_filedir($hash).$hash;
	download($filepath, $filename);
}

function download($input_filename, $output_filename = '') {
    static $pattern = '/Chrome|Firefox|(Opera)|(MSIE|IEMobile)|(Safari)/';
    if (headers_sent() || ($size = @filesize($input_filename)) === false) {
        return false;
    }
    if ((string)$output_filename === '') {
        $output_filename = $input_filename;
    }
    $output_filename = mb_convert_encoding(
        $output_filename,
        'UTF-8',
        'ASCII,JIS,UTF-8,CP51932,SJIS-win'
    );
    switch (true) {
        case !isset($_SERVER['HTTP_USER_AGENT']):
        case !preg_match($pattern, $_SERVER['HTTP_USER_AGENT'], $matches):
        case !isset($matches[1]):
            $enc = '=?utf-8?B?' . base64_encode($output_filename) . '?=';
            header('Content-Disposition: attachment; filename="' . $enc . '"');
            break;
        case !isset($matches[2]):
            $enc = "utf-8'ja'" . urlencode($output_filename);
            header('Content-Disposition: attachment; filename*=' . $enc);
            break;
        case !isset($matches[3]):
            $enc = urlencode($output_filename);
            header('Content-Disposition: attachment; filename="' . $enc . '"');
            break;
        default:
            header('Content-Disposition: attachment; filename="' .$output_filename . '"');
    }
    $finfo = new finfo(FILEINFO_MIME);
    header('Content-Type: ' . $finfo->file($input_filename));
    header('Content-Length: ' . $size);
    return readfile($input_filename);
}

//ファイルアップロード実行
function display_upload($db)
{
	$filename = $_FILES['userfile']['name'];

	$hash = sha1($filename.microtime());
	create_dir(get_upload_filedir($hash));

	$uploadfile = get_upload_filedir($hash).$hash;
	if(move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile))
	{
		$expire = get_expire_dt($_POST['expire']);
		$now = time();
		try
		{
			$sql = "INSERT INTO files (filename, hash, expire, created) VALUES (\"$filename\", \"$hash\", $expire, $now);";
			$query = $db->prepare($sql);
			$query->execute();
		}
		catch (Exception $e)
		{
			display_error($e->getTraceAsString());
			return false;
		}
		//echo "{'error':0, 'url':http://".$_SERVER["SERVER_NAME"].$_SERVER['REQUEST_URI']."?download=".$hash."}";
		echo "アップロードが完了しました。<br />以下のURLをコピーして送ってください。<br /><br />";
		echo "http://".$_SERVER["SERVER_NAME"].$_SERVER['REQUEST_URI']."?download=".$hash;
	}
	else
	{
		$error = error_get_last();
		$error_code = $_FILES['userfile']['error'];
		//echo "{'error':".$error_code.",'message':".codeToMessage($error_code)."}";
		echo codeToMessage($error_code);
	}
}

//期限切れファイル削除
function delete_file($db)
{
	try
	{
		$sql = "SELECT * FROM files WHERE expire <= ".time().";";
		$query = $db->query($sql);
		$results = $query->fetchAll();
		foreach ($results as $row)
		{
			//file delete
			$hash = $row['hash'];
			$file_name = get_upload_filedir($hash).$hash;
			if(file_exists($file_name))
			{
				unlink($file_name);
			}

			$sql_d = "DELETE FROM files WHERE hash = \"$hash\";";
			$db->exec($sql_d);
		}
	}
	catch (Exception $e)
	{
		display_error($e->getTraceAsString());
		return false;
	}
	return true;
}

function get_upload_filedir($hash)
{
	$dist_dir = substr((String)$hash, 0, 3);
	return UPLOADPATH.$dist_dir.DIRECTORY_SEPARATOR;
}

function display_error($msg)
{
	echo $msg;
}

function page_not_found()
{
		header("HTTP/1.1 404 Not Found");
		echo "404 Not Found";
		exit;
}

function codeToMessage($code) 
{ 
	switch ($code)
	{ 
		case UPLOAD_ERR_INI_SIZE: 
			$message = "The uploaded file exceeds the upload_max_filesize(".ini_get("upload_max_filesize")."byte) directive in php.ini"; 
			break; 
		case UPLOAD_ERR_FORM_SIZE: 
			$message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form"; 
			break; 
		case UPLOAD_ERR_PARTIAL: 
			$message = "The uploaded file was only partially uploaded"; 
			break; 
		case UPLOAD_ERR_NO_FILE: 
			$message = "No file was uploaded"; 
			break; 
		case UPLOAD_ERR_NO_TMP_DIR: 
			$message = "Missing a temporary folder"; 
			break; 
		case UPLOAD_ERR_CANT_WRITE: 
			$message = "Failed to write file to disk"; 
			break; 
		case UPLOAD_ERR_EXTENSION: 
			$message = "File upload stopped by extension"; 
			break; 
		default: 
			$message = "Unknown upload error"; 
			break; 
		}
	return $message; 
} 

function create_dir($dir)
{
	if(!is_dir($dir))
	{
		if(!@mkdir($dir, 0777))
		{
			$error = error_get_last();
			display_error( "アップロード失敗：".$error['message'].":[".$dir."]");
			exit;
		}
	}
}

function create_htaccess($dir)
{
	$filename = $dir.'.htaccess';
	if(!file_exists($filename))
	{
		$str = "deny from all";
		file_put_contents($filename, $str);
	}
	return true;
}

function get_expire_dt($expire)
{
	$dt = time();
	$one_hour = 60 * 60 ;
	$one_day = $one_hour * 24;
	$limit_dt = $dt + ($one_day * 7);
	switch ($expire)
	{
		case 1:
			$limit_dt = $dt + ($one_hour); 		//1時間後
			break;
		case 2:
			$limit_dt = $dt + ($one_hour * 3); 	//6時間後
			break;
		case 3:
			$limit_dt = $dt + ($one_hour * 12); //12時間後
			break;
		case 4:
			$limit_dt = $dt + ($one_day); 		//24時間後
			break;
		case 5:
			$limit_dt = $dt + ($one_day * 3); 	//3日後
			break;
		case 6:
			$limit_dt = $dt + ($one_day * 7); 	//7日後
			break;
	}
	return $limit_dt;
}

function tmplate_download($db, $hash)
{
	$urls = parse_url('http://'.$_SERVER["SERVER_NAME"].$_SERVER['REQUEST_URI']);
	$path = isset($urls['path']) ? $urls['path'] : '';
	$url = 'http://'.$urls['host'].$path.'?file='.$hash;

	try
	{
		$sql = "SELECT * FROM files WHERE hash = \"$hash\";";
		$query = $db->query($sql);
		$result = $query->fetch();

		if(!$result)
		{
			page_not_found();
		}
		
		$filename = $result['filename'];
	}
	catch (Exception $e)
	{
		display_error($e->getTraceAsString());
		return false;
	}

	$param['url'] = $url;
	$param['filename'] = htmlspecialchars($filename);

	$html = file_get_contents(TPL_DOWNLOAD);
	$html = preg_replace('/{{(.+?)}}/e', '$param[\'$1\']', $html);
	echo $html;
}

function template_upload()
{
?>
<html>
<body>
	<p>ファイルをアップロードします。</p>
	<form enctype="multipart/form-data" action="" method="POST">
		<input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
		<input name="userfile" type="file" />
		<input type="submit" value="アップロード" /><br /><br />
		<select name="expire">
			<option value="6">保存期間7日間</option>
			<option value="5">保存期間3日間</option>
			<option value="4">保存期間24時間</option>
			<option value="3">保存期間12時間</option>
			<option value="2">保存期間6時間</option>
			<option value="1">保存期間1時間</option>
		</select>
	</form>
</body>
</html>
<?php
}

