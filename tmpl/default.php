<?php

?>
<!doctype html>
<head>
	<meta charset="utf-8">
	<link rel="shortcut icon" href="favicon.ico" />	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, user-scalable=yes" /> 
	<link media="Screen" href="<?php echo $base;?>mobile.css" type="text/css" rel="stylesheet" /> 
	<link media="handheld, only screen and (max-width: 480px), only screen and (max-device-width: 480px)" href="<?php echo $base;?>mobile.css" type="text/css" rel="stylesheet" /> 
	<!--[if IEMobile]>
	<link rel="stylesheet" type="text/css" href="<?php echo $base;?>mobile.css" media="screen" />
	<![endif]-->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

	<script type="text/javascript">
	/* Cookie plugin - Copyright (c)2006 Klaus Hartl (stilbuero.de). Dual licensed under the MIT and GPL licenses:
	http://www.opensource.org/licenses/mit-license.php. http://www.gnu.org/licenses/gpl.html */
	jQuery.cookie=function(name,value,options){if(typeof value!='undefined'){options=options||{};if(value===null){value='';options.expires=-1;}var expires='';if(options.expires&&(typeof options.expires=='number'||options.expires.toUTCString)){var date;if(typeof options.expires=='number'){date=new Date();date.setTime(date.getTime()+(options.expires*24*60*60*1000));}else{date=options.expires;}expires=';expires='+date.toUTCString();}var path=options.path?';path='+(options.path):'';var domain=options.domain?';domain='+(options.domain):'';var secure=options.secure?';secure':'';document.cookie=[name,'=',encodeURIComponent(value),expires,path,domain,secure].join('');}else{var cookieValue=null;if(document.cookie&&document.cookie!=''){var cookies=document.cookie.split(';');for(var i=0;i<cookies.length;i++){var cookie=jQuery.trim(cookies[i]);if(cookie.substring(0,name.length+1)==(name+'=')){cookieValue=decodeURIComponent(cookie.substring( name.length+1));break;}}}return cookieValue;}};
	/* Cookie plugin, ends */
	function setredirect(b){
		if(b==false){
			$.cookie("handheld_redirect", "false");			
			window.location ='<?php echo $home;?>';
		}
		else{
			$.cookie("handheld_redirect", "true");
			window.location = '<?php echo $url;?>';
		}
		return false;
	}
	function checkForHandhelds(){
		if ($.cookie("handheld_redirect") === "false"){//prefers std site
			//do nothing
		}else if ($.cookie("handheld_redirect") === "true"){
			window.location = '<?php echo $url;?>';
		}
	}

	$(document).ready(function(){
		//$.cookie("handheld_redirect", null);//uncomment to clear cookie
		checkForHandhelds();
	});
	</script>
</head>
<body>
	<div id="wrapper">
		<div class="logo"><img src="<?php echo $base;?>logo.png"></div>
		<br />
		<div class="text">Switch to Mobile Site?</div>
		<br />
		<div class="button">
			<a href="#" onclick="setredirect(true);"><img src="<?php echo $base;?>yes.png" /></a><br /><a href="#" onclick="setredirect(false);"><img src="<?php echo $base;?>no.png" /></a>
		</div>
	</div>
</body>
</html>
