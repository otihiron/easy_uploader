<?xml version="1.0" encoding="UTF-8"?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Language" content="ja" />
<meta http-equiv="content-style-type" content="text/css" />
<meta http-equiv="content-script-type" content="text/javascript" />
<meta name="robots" content="NOINDEX,NOFOLLOW" />
<title>CASE Inc. Files</title>
<link href='http://fonts.googleapis.com/css?family=Oldenburg' rel='stylesheet' type='text/css'>
<style type="text/css">
<!--
html,body{
	text-align: center;
	position:relative;
	width:100%;
	height:100%;
	margin: 0;
	padding: 0;
}
p{
	color: #333;
	margin: 0;
}
.wrapper{
	position:relative;
	width:100%;
	height:auto !important;
	height: 100%;
	min-height: 100%;
}
.contents{
	position:absolute;
	width: 600px;
	height: 400px;
	top: 50%;
	left: 50%;
	margin-top: -250px;
	margin-left: -300px;
	min-height: 400px;
	padding-bottom:50px;
}
.header p{
	font-size: 32px;
	font-family: 'Oldenburg', cursive;
	margin: 30px auto;
}
.messages p{
	font-size: 14px;
	line-height: 21px;
}
.messages > .en{
	font-size: 12px;
}

.files_wrapper{
	margin: 30px auto;
}
.files{
	height: 100px;
	width: 600px;
	border: solid 8px #444;
	display: table-cell;
	vertical-align: middle;
}
.filename{
	float: left;
	margin-left: 30px;
	line-height: 40px;
	font-size: 14px;
}
/*
.button{
	float: right;
	text-decoration: none;
	margin-right: 30px;
	font-size: 12px;

	background: -moz-linear-gradient(top,#0099CC 0%,#006699);
	background: -webkit-gradient(linear, left top, left bottom, from(#0099CC), to(#006699));
	border-radius: 20px;
	-moz-border-radius: 20px;
	-webkit-border-radius: 20px;
	color: #FFF;
	-moz-box-shadow: inset 1px 1px 1px rgba(000,000,000,0.3);
	-webkit-box-shadow: inset 1px 1px 1px rgba(000,000,000,0.3);
	width: 120px;
	padding: 10px 0;
}
*/
.button
{
	margin-right: 30px;
	float: right;

    text-decoration: none;
    font: bold 1em 'Trebuchet MS',Arial, Helvetica; /*Change the em value to scale the button*/
    display: inline-block;
    text-align: center;
    color: #fff;
    
    border: 1px solid #9c9c9c; /* Fallback style */
    border: 1px solid rgba(0, 0, 0, 0.3);            
    
    text-shadow: 0 1px 0 rgba(0,0,0,0.4);
    
    box-shadow: 0 0 .05em rgba(0,0,0,0.4);
    -moz-box-shadow: 0 0 .05em rgba(0,0,0,0.4);
    -webkit-box-shadow: 0 0 .05em rgba(0,0,0,0.4);
    
}

.button, .button span
{
    -moz-border-radius: .3em;
    border-radius: .3em;
}

.button span
{
    border-top: 1px solid #fff; /* Fallback style */
    border-top: 1px solid rgba(255, 255, 255, 0.5);
    display: block;
    padding: 0.5em 2.5em;
    
    /* The background pattern */
    
    background-image: -webkit-gradient(linear, 0 0, 100% 100%, color-stop(.25, rgba(0, 0, 0, 0.05)), color-stop(.25, transparent), to(transparent)),
                      -webkit-gradient(linear, 0 100%, 100% 0, color-stop(.25, rgba(0, 0, 0, 0.05)), color-stop(.25, transparent), to(transparent)),
                      -webkit-gradient(linear, 0 0, 100% 100%, color-stop(.75, transparent), color-stop(.75, rgba(0, 0, 0, 0.05))),
                      -webkit-gradient(linear, 0 100%, 100% 0, color-stop(.75, transparent), color-stop(.75, rgba(0, 0, 0, 0.05)));
    background-image: -moz-linear-gradient(45deg, rgba(0, 0, 0, 0.05) 25%, transparent 25%, transparent),
                      -moz-linear-gradient(-45deg, rgba(0, 0, 0, 0.05) 25%, transparent 25%, transparent),
                      -moz-linear-gradient(45deg, transparent 75%, rgba(0, 0, 0, 0.05) 75%),
                      -moz-linear-gradient(-45deg, transparent 75%, rgba(0, 0, 0, 0.05) 75%);

    /* Pattern settings */
    
    -moz-background-size: 3px 3px;
    -webkit-background-size: 3px 3px;
    background-size: 3px 3px;            
}

.button:hover
{
    box-shadow: 0 0 .1em rgba(0,0,0,0.4);
    -moz-box-shadow: 0 0 .1em rgba(0,0,0,0.4);
    -webkit-box-shadow: 0 0 .1em rgba(0,0,0,0.4);
}

.button:active
{
    /* When pressed, move it down 1px */
    position: relative;
    top: 1px;
}

.button-red {
            background: #D82741;
            background: -webkit-gradient(linear, left top, left bottom, from(#E84B6E), to(#D82741) );
            background: -moz-linear-gradient(-90deg, #E84B6E, #D82741);
            filter: progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr='#E84B6E', EndColorStr='#D82741');
}
.button-red:hover {
            background: #E84B6E;
            background: -webkit-gradient(linear, left top, left bottom, from(#D82741), to(#E84B6E) );
            background: -moz-linear-gradient(-90deg, #D82741, #E84B6E);
            filter: progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr='#D82741', EndColorStr='#E84B6E');
}
.button-red:active{
            background: #D82741;
}

.button-blue:hover
{
    background: #81a8cb;
    background: -webkit-gradient(linear, left top, left bottom, from(#4477a1), to(#81a8cb) );
    background: -moz-linear-gradient(-90deg, #4477a1, #81a8cb);
    filter:  progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr='#4477a1', endColorstr='#81a8cb');            
}

.button-blue:active
{
    background: #4477a1;
}

.footer{
	margin: 30px 0 auto auto;
	font-size: 12px;
	position: absolute;
	bottom: 0;
	height: 50px;
	width:600px;
	text-align: center;
}
-->
</style>
</head>
<body>
<div class="wrapper">
	<div class="contents">
		<div class="header">
			<p>Please accept file.</p>
		</div>
		<div class="messages">
			<p>いつもありがとうございます。以下のファイルをお受け取り下さい。</p>
			<p class="en">Your file(s) is/are available for download.</p>
		</div>
		<div class="files_wrapper">
			<div class="files">
				<p class="filename">File&nbsp;:&nbsp;{{filename}}</p>
				<a href="{{url}}" class="button button-red"><span>Download</span></a>
			</div>
		<div>
	</div>
	<div class="footer">
		<p>Copyright &copy; 2013 CASE Inc.</p>
	</div>
</div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ja_JP/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  var pluginUrl = 
 '//www.google-analytics.com/plugins/ga/inpage_linkid.js';
_gaq.push(['_require', 'inpage_linkid', pluginUrl]);
  _gaq.push(['_setAccount', 'UA-24699127-2']);
  _gaq.push(['_setDomainName', 'caseinc.jp']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
</body>
</html>