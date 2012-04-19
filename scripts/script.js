var loginElements = document.getElementsByClassName('loginElements');	
var loadingElements = document.getElementsByClassName('loadingElements');

//**********************************
// General Utilities
//**********************************

/*
* Conceals or reveals the specified element depending on the request
*/
function forceElementDisplay(element, state) {

	if (state == "ON")
		element.style.display = "block";
	else if (state == "OFF")
		element.style.display = "none";	
		
}

/*
* Conceals or reveals a list of elements depending on the request
*/
function forceElementSDisplay(elements, state) {
	
	for (var i = 0; i < elements.length; i++) {		
		forceElementDisplay(elements[i], state);
	}
	
}

//**********************************
// Log-In Page
//**********************************

function logIn() {
	
	var user = document.getElementById('userText').value;
	var pass = document.getElementById('passText').value;
	
	var success = authenticate(user, pass);	
	if (success == true) {
		if (isInstructor(user) == true) {
			location.href = "viewlabs.html?user=" + user + "?instructor=true";
		}
		else
			location.href = "viewlabs.html?user=" + user;
		
	}
	else {
	
		alert("Log-In attempt was unsuccessful! Check username and/or password!");
	
	}
	
	forceElementSDisplay(loginElements, "ON");
	forceElementSDisplay(loadingElements, "OFF");	
	

}

function authenticate(user, pass) {	
		
	forceElementSDisplay(loginElements, "OFF");
	forceElementSDisplay(loadingElements, "ON");
	
	return true;

}

function isInstructor(user) {	
	
	return true;
}

//**********************************
// View Labs Page
//**********************************

function viewLabsInit() {

	var user = (new String(window.location)).split("?")[1].split("=")[1];
	
	if (user != undefined) {
		document.getElementById("titlebar").innerHTML = user + ": View Labs";
		
	}
	
	
}


//**********************************
// Code Editor
//**********************************

function editorInit() {
	
	window.aceEditor.setTheme("ace/theme/eclipse");
	var DefaultMode = require("ace/mode/c_cpp").Mode;
	window.aceEditor.getSession().setMode(new DefaultMode());	
	var text = 'public class NewClass {\n' + 
	'\tpublic static void main (String args[]) {\n' + 
	'\t\tSystem.out.println("Hello World!");\n' + 
	'\t}\n' + 
	'}';
	window.aceEditor.insert(text);	
	window.aceEditor.setShowPrintMargin(false);	
	
	var url = (new String(window.location)).split("?user=")[1];
	
	if (url != undefined)
		document.getElementById("titlebar").innerHTML = url + ": Editor";
		
}

function consoleInit() {	
	window.aceConsole.setTheme("ace/theme/vibrant_ink");
	var TextMode = require("ace/mode/text").Mode;
	window.aceConsole.getSession().setMode(new TextMode());	
	var text = "Username@cloud-lab$> ";
	window.aceConsole.insert(text);	
	window.aceConsole.setReadOnly(true);
    window.aceConsole.setShowPrintMargin(false);
}

function overlay(element) {
	e = document.getElementById(element);
	e.style.display = (e.style.display == "block") ? "none" : "block";			
}

function newFile() {
	
	var newFile = prompt("Enter the name and path of your new file:", "defaultFolder/Untitled");		
	
	var fileViewContainer = document.getElementById("fileViewContainer");
	
	for (var i = 0; i < fileViewContainer.childNodes.length; i++) {
		
		if (fileViewContainer.childNodes[i].nodeName == "UL") {
			
			var ulist = fileViewContainer.childNodes[i];
			
			// Append a new LI element that represents a new file called <FilePath> (modify code as needed for correct file name)
			var listitem = document.createElement("LI");			
			var anchor = document.createElement("a");
			anchor.setAttribute("href", "#");
			anchor.setAttribute("onclick", "openFile(\"" + newFile + "\")");
			anchor.innerHTML = newFile;
			listitem.appendChild(anchor);			
			ulist.appendChild(listitem);						
			
			break;
			
		}
		
	}

}

function openFile(fileName) {

	// Read file contents and store in buffer (not implemented yet)
	var buffer = fileName;
	
	window.aceEditor.getSession().setValue(buffer);

}

function charCount() {
	
	var text = window.aceEditor.getSession().getValue();
	alert("The total number of characters in your code is " + text.length + " chars.");

}

function applyChanges() {

 	var mode = (require(document.getElementById("mode").value)).Mode;	
	window.aceEditor.getSession().setMode(new mode()); 
	
	var theme = document.getElementById("theme").value;
	window.aceEditor.setTheme(theme);
	
	var fontSize = document.getElementById("fontsize").value;	
	document.getElementById("editor").style.fontSize = fontSize;

	var toggle = document.getElementById("highlight_active").checked;		
	window.aceEditor.setHighlightActiveLine(toggle);	
	
	toggle = document.getElementById("show_gutter").checked;
	window.aceEditor.renderer.setShowGutter(toggle);
	
	
}