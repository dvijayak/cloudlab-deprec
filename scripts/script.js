var loginElements = document.getElementsByClassName('loginElements');	
var loadingElements = document.getElementsByClassName('loadingElements');

var response;
var loggedUser; 
var loggedIsInstructor;

var validUsers = [
	{
		"user": "mdelong",
		"pass": "M",
		"role": 1
	},
	{
		"user": "dvijayak",
		"pass": "D",
		"role": 1
	},
	{
		"user": "qmahmoud",
		"pass": "Q",
		"role": 0
	}
];	

var projectTypes = ["C", "C++", "BB"];

function validate(){  
    val = document.getElementById("userText").value;  
    myClass.validateEmail(val, {          
        "onFinish": function(response){              
            if(response) alert("Valid Email Address!");  
            else alert("Invalid Email Address!");  
        }  
    });  
}  

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

function checkValidResource(user) {
	
	var invalidURL = true;
	
	for (var i = 0; i < validUsers.length; i++) {
		if (user == validUsers[i].user) {
			invalidURL = false;
			break;
		}
	}
	
	return invalidURL;
}

function logOut() {
	
	// Routines for saving, clearing memory of current user, etc.
	// ----------	
	// --------- -
	// End
	
	// location.href = "index.html";
	location.href = "index.php";
	
}

//**********************************
// Log-In Page
//**********************************

function logIn() {
	
	var user = document.getElementById('userText').value;
	var pass = document.getElementById('passText').value;
	
	var success = authenticate(user, pass);	
	if (success[0] == true) {
		if (isInstructor(success[1]) == true) {
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
	
	for (var i = 0; i < validUsers.length; i++)
		if (user == validUsers[i].user && pass == validUsers[i].pass)
			return [true, validUsers[i]];		
	
	return [false];

}

function isInstructor(user) {		
	if (user.role == 0)
		return true;
	return false;		
}


//**********************************
// View Labs Page
//**********************************

function viewLabsInit() {	

	var loggedUser = (new String(window.location)).split("?")[1].split("=")[1];
	var loggedIsInstructor = (new String(window.location).split("?")[2] != undefined) ? new String(window.location).split("?")[2].split("=")[1] : undefined; 			
	
	if (checkValidResource(loggedUser) == true) {		
		alert("Security Breach: Trespasser has attempted to access a private user space!");
		// location.href = "index.html";		
		location.href = "index.php";		
		return;
	}
	else {
		if (loggedUser != undefined) 		
			// document.getElementById("titlebar").childNodes[1].innerHTML += user + ": View Labs";					
			document.getElementById("userlabel").innerHTML = loggedUser + ":";					
		
		if (loggedIsInstructor) {
		
			forceElementDisplay(document.getElementById("instructorControlsToolbar"), "ON");
		
		}
		else
			forceElementDisplay(document.getElementById("studentControlsToolbar"), "ON");
		
		//------------------------
		// Code for loading all the user's labs 
		//------------------------				
	
	}		
		
}

function viewFilePaneInit() {	
	
	var TextMode = require("ace/mode/text").Mode;
	window.aceViewFilePane.getSession().setMode(new TextMode());	
	// var text = "Username@cloud-lab$> ";
	// window.aceViewFilePane.insert(text);	
	window.aceViewFilePane.setReadOnly(true);
    window.aceViewFilePane.setShowPrintMargin(false);
	window.aceViewFilePane.renderer.setShowGutter(false);
}

function newLab() {
	
	var newLab = {
		"name"  : prompt("Enter the name of the new lab:", "defaultLab"),
		"type"  : prompt("Enter the type of the lab (C [C], C++ [C++] or BlackBerry Web App [BB]"),
		"users" : prompt("Enter the usernames of the students (separated by spaces only) that you would like to assign this lab to:").split(" ")
	};
	
	var fileViewContainer = document.getElementById("fileViewContainer");
	
	for (var i = 0; i < fileViewContainer.childNodes.length; i++) {
		
		if (fileViewContainer.childNodes[i].nodeName == "UL") {
			
			var ulist = fileViewContainer.childNodes[i];
			
			// Append a new LI element that represents a new file called <FilePath> (modify code as needed for correct file name)
			var listitem = document.createElement("LI");			
			var anchor = document.createElement("a");
			anchor.setAttribute("href", "#");
			anchor.setAttribute("onclick", "openLab(\"" + newLab.name + "\")");
			anchor.setAttribute("value", newLab.name);
			anchor.innerHTML = newLab.name;
			listitem.appendChild(anchor);			
			ulist.appendChild(listitem);						
			
			break;
			
		}
		
	}

}

function deleteLab() {

	var delLab = {
		"name"  : prompt("Enter the name of the lab you would like to delete", "defaultLab")/* ,
		"users" : prompt("Enter the usernames of the students (separated by spaces only) that were assigned this lab:" */
	};
	
	var fileViewContainer = document.getElementById("fileViewContainer");
	
	for (var i = 0; i < fileViewContainer.childNodes.length; i++) {
		
		if (fileViewContainer.childNodes[i].nodeName == "UL") {
			
			var ulist = fileViewContainer.childNodes[i];
			
			for (var j = 0; j < ulist.childNodes.length; j++) {												
				if (ulist.childNodes[j].nodeName == "LI" && ulist.childNodes[j].firstChild.nodeName == "A") {
					for (var k = 0; k < ulist.childNodes[j].firstChild.attributes.length; k++) {
						if (delLab.name == ulist.childNodes[j].firstChild.attributes[k].value) {						
							ulist.removeChild(ulist.childNodes[j]);
							break;						
						}
					}
				}
			}																
		}		
	}	

}

function openLab(fileName) {

	// Read file contents and store in buffer (not implemented yet)
	var buffer = fileName;
		
	alert(buffer);

}

function editLab(fileName) {
	if (fileName != null && fileName != undefined)
		location.href = "editor.html?lab=" + fileName;
	else
		alert("Invalid Lab!");
}


//**********************************
// Code Editor
//**********************************

function editorInit() {

	var user = (new String(window.location)).split("?")[1].split("=")[1];
	
	if (checkValidResource(user) == true) {		
		// alert("Security Breach: Trespasser has attempted to access a private user space!");
		// location.href = "index.html";		
		// return;
	}
	else {
		
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
			
		if (user != undefined) 		
			// document.getElementById("titlebar").childNodes[1].innerHTML += user + ": View Labs";					
			document.getElementById("userlabel").innerHTML = user + ":";	
	
	}	
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
	
	var newFile = prompt("Enter the name of your new file:", "Untitled");		
	
	// -------------------------------- //
	// Check what type of project it is and append the necessary extension if necessary//	
	// -------------------------------- //
	
	var fileListContainer = document.getElementById("fileListContainer");
	
	for (var i = 0; i < fileListContainer.childNodes.length; i++) {
		
		if (fileListContainer.childNodes[i].nodeName == "UL") {
			
			var ulist = fileListContainer.childNodes[i];
			
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
		
	$.get("scripts/test.php", function(response) { 						
				
		alert(response);
		
	}).error(function(){ 
		alert("Error querying server! Check your Internet connection!");
	});
	
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