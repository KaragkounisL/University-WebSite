function validateLogin() {

    var x = document.forms["loginform"]["password"].value;
    var y = document.forms["loginform"]["email"].value;

    if (x.length < 8) {
        alert("Απαιτούνται τουλάχιστον 8 χαρακτήρες!");
        return false;
    } else if ((/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(String(y).toLowerCase())) === false) {
        alert("Το E-mail δεν έχει σωστή μορφή!");
        return false;
    } else {
        return true;
    }
}

function validateRegister() {

    var x = document.forms["registerform"]["password"].value;
    var y = document.forms["registerform"]["Επιβεβαίωση"].value;
    var z = document.forms["registerform"]["email"].value;

    if ((/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(String(z).toLowerCase())) === false) {
        alert("Το E-mail δεν έχει σωστή μορφή!");
        return false;
    } else if (x.length < 8 || y.length < 8) {
        alert("Ο κωδικός χρήστη πρέπει να αποτελείται από τουλάχιστον 8 χαρακτήρες!");
        return false;
    } else if (x !== y) {
        alert("Ο κωδικός επιβεβαίωσης δεν συμφωνεί με τον κωδικό χρήστη! Προσπαθήστε ξανά.");
        return false;
    } else {
        return true;
    }
}

function validateSRegister() {
	 var z = document.forms["registersubjectform"]["email"].value;

    if ((/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(String(z).toLowerCase())) === false) {
        alert("Το E-mail δεν έχει σωστή μορφή!");
        return false;
	}else {
        return true;
    }
}

function validateControls()
{
  var select_element = document.getElementById( "role" );
  var selected = select_element.options[ select_element.selectedIndex ].value

	if(selected == "Φοιτητής"){
		document.getElementById("eksamino").style.visibility="visible";
		document.getElementById("star").style.visibility="visible";
		document.getElementById("eksamino").required = true;
	}
	else{
		document.getElementById("eksamino").style.visibility="hidden";
		document.getElementById("star").style.visibility="hidden";
		document.getElementById("eksamino").required = false;
	}
}

function setCheckState(){
	if(document.getElementById( "sem" ) === null){
		document.getElementById("eksamino").style.visibility="hidden";
		
	}else{
		document.getElementById("eksamino").style.visibility="false";
	}
	
}
