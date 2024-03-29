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
		
		<div id="header">Welcome To CloudLab</div>
		
		<div id="centerContainer">
		
			<ul>
				<li class="loginElements">
					<label for="userText">Username: </label>
					<input id="userText" type="text" value="mdelong"></input>					
				</li>
				
				<li class="loginElements">
					<label for="passText">Password: </label>
					<input id="passText" type="text" value="M"></input>					
				</li>
				
				<li class="loginElements">
					<input id="loginButton" type="button" value="Log-In" onclick="validate()"></input>
				</li>
				
				<li class="loadingElements" style="display: none">
					<img src="images/loading.png"/>
				</li>
									
				<li class="loadingElements" style="display: none">
					Attempting to Log-In...
				</li>
				
			</ul> 
		
		</div>
		
		<div id="aboutContainer">
			About
		</div>
	</body>
	
</html>

