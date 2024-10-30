var el = document.getElementById("err");

if (el.innerHTML != "") {
	document.getElementById("input_username").style.borderColor= "red";
}

function checkPsw(element) {
	var stringa = element.value;

	if(stringa.length < 7){
		document.getElementById("lengthWarning").style.display = "block";
		var length = false;
	}
	else {
		document.getElementById("lengthWarning").style.display = "none";
		var length = true;
	}

	if(!isUpper(stringa)){
		document.getElementById("capsWarning").style.display = "block";
		var upper = false;
	}
	else {
		document.getElementById("capsWarning").style.display = "none";
		var upper = true;
	}

	if(stringa == ""){
		document.getElementById("checkEmpty").style.display = "block";
		var empty = false;
	}
	else{
		document.getElementById("checkEmpty").style.display = "none";
		var empty = true;
	}

	if(upper && length && empty){
		document.getElementById("input_pass").style.borderColor= "green";

	} else {
		document.getElementById("input_pass").style.borderColor= "red";
	}
}


function validaModulo(modulo) {
	var pass = modulo.input_pass.value;
	var repass = modulo.input_repass.value;
    var matricola = modulo.input_matricola.value;
	if(pass.length >= 7 && isUpper(pass) && pass != "" && pass == repass  && matricola!="")
		return true;
	else
		return false;
}

function isUpper(str) {
	for(var i = 0; i<str.length; i++) {
		if (str.charAt(i) >= 'A' && str.charAt(i) <= 'Z')
			return true;
	}
	return false;
}
/*
function checkUsn(usn) {
	var el = usn.value;

	if(el.length < 6){
		document.getElementById("input_name").style.borderColor = "red";
		document.getElementById("warningUser").style.display = "block";
	}
	else{
		document.getElementById("input_name").style.borderColor = "green";
		document.getElementById("warningUser").style.display = "none";
	}
}*/

function checkRepsw(psw) {

	var el = document.getElementById("input_pass").value;

	if(el != psw.value){
		document.getElementById("checkRpwd").style.display = "block";
		document.getElementById("input_repass").style.borderColor= "red";
	}
	else if(el == ""){
		document.getElementById("checkRpwd").style.display = "none";
		document.getElementById("input_repass").style.borderColor= "white";
	}
	else{
		document.getElementById("checkRpwd").style.display = "none";
		document.getElementById("input_repass").style.borderColor= "green";
	}

}

