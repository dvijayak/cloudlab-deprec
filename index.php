 <!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" id="viewport" content="height=device-height,width=device-width,user-scalable=no" />
		<title>Cloud Lab: Code Editor</title>
		<link href="css/style_login.css" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="scripts/jquery.js"></script>
		<script type="text/javascript" src="scripts/jquery.tools.min.js"></script>		
		<script type="text/javascript" src="scripts/jquery-1.7.1.js"></script>		
		<script type="text/javascript" src="scripts/script.js"></script>		
		<script type="text/javascript" src="scripts/phplivex.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {						
			});
		</script>
		<?php include "scripts/test.php"; ?> 
	</head>
	
	<body>				
		
		<div id="header" style="text-align: center; font-size: 40px;">Welcome To CloudLab</div>
		
		<div id="centerContainer" class="custom_style">
			<img src="images/clouds.jpg" id="back-image"/>
			<ul>
				<li class="loginElements">
					<label for="userText" style="font-size: 20px;">Username: </label>
					<input id="userText" type="text" value="mdelong"></input>					
				</li>
				
				<li class="loginElements">
					<label for="passText" style="font-size: 20px;">Password: </label>
					<input id="passText" type="text" value="M"></input>					
				</li>
				
				<li class="loginElements">
					<input id="loginButton" type="button" class="button_e_style" value="Log-In" onclick="logIn()"></input>
				</li>
				
				<li class="loadingElements" style="display: none">
					<img src="images/loading.gif"/>
				</li>
									
				<li class="loadingElements" style="display: none">
					Attempting to Log-In...
				</li>
				
			</ul> 
		
		</div>
		
		<div id="aboutContainer" class="custom_style">
			About
		</div>
	</body>
	
</html>

