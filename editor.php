	<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" id="viewport" content="height=device-height,width=device-width,user-scalable=no" />
		<title>Cloud Lab: Code Editor</title>
		<link href="css/style_editor.css" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="scripts/jquery.js"></script>
		<script type="text/javascript" src="scripts/jquery.tools.min.js"></script>		
		<script type="text/javascript" src="scripts/jquery-1.7.1.js"></script>		
		<script type="text/javascript" src="scripts/jquery.ui.core.js"></script>		
		<script type="text/javascript" src="scripts/jquery.ui.mouse.js"></script>		
		<script type="text/javascript" src="scripts/jquery.ui.widget.js"></script>		
		<script type="text/javascript" src="scripts/jquery.ui.resizable.js"></script>
        <script type="text/javascript" src="scripts/phplivex.js"></script>	
		<script type="text/javascript" src="scripts/script.js"></script>		
		<script src="ace_src/ace.js" type="text/javascript" charset="utf-8"></script>
		<script src="ace_src/theme-textmate.js" type="text/javascript" charset="utf-8"></script>
		<script src="ace_src/theme-eclipse.js" type="text/javascript" charset="utf-8"></script>
		<script src="ace_src/theme-vibrant_ink.js" type="text/javascript" charset="utf-8"></script>
		<script src="ace_src/theme-kr_theme.js" type="text/javascript" charset="utf-8"></script>
		<script src="ace_src/theme-cobalt.js" type="text/javascript" charset="utf-8"></script>
		<script src="ace_src/mode-java.js" type="text/javascript" charset="utf-8"></script>
        <script src="ace_src/mode-c_cpp.js" type="text/javascript" charset="utf-8"></script>
		<script src="ace_src/mode-html.js" type="text/javascript" charset="utf-8"></script>
		<script src="ace_src/mode-css.js" type="text/javascript" charset="utf-8"></script>
		<script src="ace_src/mode-javascript.js" type="text/javascript" charset="utf-8"></script>
        <?php include "scripts/file_manager.php"; ?>        
	</head>
	
	<body>				
		
		<!-- <img src="images/clouds2.jpg" id="back-image"/> -->
		
		<div id="barContainer">
			<div id="titlebar">Editor</div>
		
			<div id="toolbar" class="custom_style">
				<ul>
					<li><a href="#">File</a>
						<ul>
							<li><a href="#" onclick="newFile()">New File</a>
<!-- 								<ul>
									<li><a href="#">Java Class</a></li>
									<li><a href="#">HTML File</a></li>
									<li><a href="#">CSS Stylesheet</a></li>
									<li><a href="#">JS Script</a></li>
								</ul> -->
							</li>
							<li><a href="#" onclick="saveFile()">Save</a></li>
                            <li><a href="#" onclick="alert('DELETE')">Delete File</a></li>
							<li><a href="#" onclick="saveAllFiles()">Save All</a></li>
                            <li><a href="#" onclick="alert('compile and run')">Compile and Run</a></li>
						</ul>
					</li>
					<li><a href="#">Edit</a>
						<ul>
							<li><a href="#">Undo</a></li>
							<li><a href="#">Redo</a></li>
							<li><a href="#">Cut</a></li>
							<li><a href="#">Copy</a></li>
							<li><a href="#">Paste</a></li>
						</ul>
					</li>
					<li><a href="#">Tools</a>
						<ul>
							<li><a href="#" onclick="charCount()">Character Count</a></li>						
							<li><a href="#" onclick="alert('FIND')">Find</a></li>
							<li><a href="#">Replace</a></li>
						</ul>
					</li>
					<li><a href="#">Help</a>
						<ul> 
							<li><a href="#">About</a></li>						
						</ul>
					 </li>
				</ul>
			</div>
		</div>
					
		<div id="editorContainer"> 
			<img src="images/clouds.jpg" id="back-image"/>
			<div id="editor" class="custom_style"></div>		
			<div id="filePane" class="custom_style">
                <ul id = "fileList" class="file_list">
                </ul>
            </div>
			<div id="consoleOutput" class="custom_style"> </div>
	
			
			<script type="text/javascript">
				window.onload = function() {
					window.aceEditor = ace.edit("editor");			
					window.aceConsole = ace.edit("consoleOutput");
					editorInit();
					consoleInit();
                    setupEnvironment("mdelong", "lab1-c");
				};
			</script>
		
			<div id="controlBox" class="custom_style">
				
				<table id="controls">
					<tr>
					  <td >
						<label for="mode">Mode</label>
					  </td><td>
						<select id="mode" size="1">
						  <option value="ace/mode/c_cpp" selected="selected">C/C++</option>
						  <option value="ace/mode/html">HTML</option>
						  <option value="ace/mode/css">CSS</option>
						  <option value="ace/mode/javascript">JavaScript</option>
						</select>
					  </td>
					</tr>					
					<tr>
					  <td >
						<label for="theme">Theme</label>
					  </td><td>
						<select id="theme" size="1">
                          <option value="ace/theme/cobalt">Cobalt</option>
                          <option value="ace/theme/eclipse">Eclipse</option>
                          <option value="ace/theme/kr_theme">krTheme</option>
                          <option value="ace/theme/textmate" selected="selected">TextMate</option>
                          <option value="ace/theme/vibrant_ink">Vibrant Ink</option>
						</select>
					  </td>
					</tr>
					<tr>
					  <td>
						<label for="fontsize">Font Size</label>
					  </td><td>
						<select id="fontsize" size="1">
						  <option value="10px">10px</option>
						  <option value="11px">11px</option>
						  <option value="12px" selected="selected">12px</option>
						  <option value="14px">14px</option>
						  <option value="16px">16px</option>
						  <option value="20px">20px</option>
						  <option value="24px">24px</option>
						</select>
					  </td>
					</tr>
					<tr>
					  <td>
						<label for="highlight_active">Highlight Active Line</label>
					  </td><td>
						<input type="checkbox" name="highlight_active" id="highlight_active" checked>
					  </td>
					</tr>
					<tr>
					  <td >
						<label for="show_gutter">Show Gutter</label>
					  </td><td>
						<input type="checkbox" id="show_gutter" checked>
					  </td>
					</tr>				
					<tr>
						<td>
							<button id="applyButton" class="button_e_style" onclick="applyChanges()"><center>Apply</center></button>
						</td>
					</tr>

				</table>
								
			</div>
					
		</div>
			
				
		
	</body>
	
</html>

