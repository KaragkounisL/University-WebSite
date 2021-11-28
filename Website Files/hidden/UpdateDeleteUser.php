<?php

if (isset($_POST['save'])) {


    require 'connectDB.php';

    session_start();

	$id = $_POST["id_Χρήστη"];
	$fName = $_POST["Όνομα"];
    $lName = $_POST["Επώνυμο"];
    $email = $_POST["Email"];
    $phone = $_POST["Κινητό"];
    $password = $_POST["Password"];
    $role = $_POST["Ρόλος"];
    $address = $_POST["Διεύθυνση"];
    $birthDate = $_POST["Ημερομηνία_Γέννησης"];
	$registerDate = $_POST["Ημερομηνία_Πρώτης_Εγγραφής"];
	$mitroo = $_POST["Αριθμός_Μητρώου"];
	if ($role =="Φοιτητής"){
	$semester = $_POST["Εξάμηνο"];
	}
//Ενημερώνουμε τα νέα στοιχεία του χρήστη στη Β.Δ.
    $question = "UPDATE χρήστης SET Όνομα = '$fName', Επώνυμο = '$lName', Email = '$email', Κινητό = '$phone', Password = AES_ENCRYPT('$password', UNHEX(SHA2('eap', 256))), Ρόλος = '$role', Διεύθυνση = '$address', Ημερομηνία_Γέννησης = nullif('$birthDate', ''), Ημερομηνία_Πρώτης_Εγγραφής = nullif('$registerDate', ''), Αριθμός_Μητρώου ='$mitroo'  WHERE id_Χρήστη = $id";
    if ($mysqli->query($question) === true) {
		//Αν ο χρήστης είναι φοιτητής ενημερώνουμε και τοον πίνακα εξάμηνο
		if ($role =="Φοιτητής"){
			$question1 ="UPDATE εξάμηνο SET Εξάμηνο = '$semester' WHERE id_Χρήστη = '$id'";
			if ($mysqli->query($question1) === false) {
				echo '  <script language="javascript" type="text/javascript">
            if (!alert ("Σφάλμα! Η αποθήκευση των νέων δεδομένων χρήστη δεν πραγματοποιήθηκε: ' . $mysqli->error . '")) {
            location.href="../modify.php";
            }
            </script>';
			}
		}
		//Ενημερώνουμε τον χρήστη για την επιτυχή αποθήκευση των στοιχείων του προϊόντος.
        echo '  <script language="javascript" type="text/javascript">
            if (!alert ("Τα νέα δεδομένα χρήστη αποθηκεύτηκαν με επιτυχία.")) {
            location.href="../modify.php";
            }
            </script>';
        exit();
    } else { //Αν η εγγραφή αποτύχει εξαιτίας ενός σφάλματος.
        echo '  <script language="javascript" type="text/javascript">
            if (!alert ("Σφάλμα! Η αποθήκευση των νέων δεδομένων χρήστη δεν πραγματοποιήθηκε: ' . $mysqli->error . '")) {
            location.href="../modify.php";
            }
            </script>';
    }

    $mysqli->close(); //Κλείσιμο σύνδεσης με ΒΔ.

    
} else if (isset($_POST['delete'])) {

    require 'connectDB.php';

    session_start();

    $id = $_POST['id_Χρήστη'];

//Διαγράφουμε τον χρήστη από τη Β.Δ.
    $question = "DELETE FROM χρήστης WHERE id_Χρήστη = '$id'";

    if ($mysqli->query($question) === true) {//Ενημερώνουμε τον διαχειριστή για την επιτυχή διαγραφή.
        echo '  <script language="javascript" type="text/javascript">
            if (!alert ("O χρήστης διαγράφηκε.")) {
            history.go (-1);
            }
            </script>';
        exit();
    } else { //Αν η διαγραφή αποτύχει εξαιτίας ενός σφάλματος.
        echo '  <script language="javascript" type="text/javascript">
            if (!alert ("Σφάλμα! Η διαγραφή του χρήστη δεν πραγματοποιήθηκε: ' . $mysqli->error . '")) {
            history.go (-1);
            }
            </script>';
    }

    $mysqli->close(); //Κλείσιμο σύνδεσης με ΒΔ.
}
?>