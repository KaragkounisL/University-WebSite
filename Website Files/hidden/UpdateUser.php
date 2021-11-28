<?php

require 'connectDB.php';

session_start();

$id = $_POST["id_Χρήστη"];
$phone = $_POST["Κινητό"];
$password = $_POST["Password"];
$address = $_POST["Διεύθυνση"];
$birthDate = $_POST["Ημερομηνία_Γέννησης"];

//Ενημερώνουμε τα νέα στοιχεία του χρήστη στη Β.Δ.
$question = "UPDATE χρήστης SET Κινητό = '$phone', Password = AES_ENCRYPT('$password', UNHEX(SHA2('eap', 256))), Διεύθυνση = '$address', Ημερομηνία_Γέννησης= nullif('$birthDate', '') WHERE id_Χρήστη = '$id'";
if ($mysqli->query($question) === true) {
	        echo '  <script language="javascript" type="text/javascript">
                if (!alert ("Η τροποποίηση πραγματοποιήθηκε")) {
                location.href = "../Profile.php";
                }
                </script>';		
        exit();
    } else { //Αν η εγγραφή αποτύχει εξαιτίας ενός σφάλματος.
        echo '  <script language="javascript" type="text/javascript">
                if (!alert ("Σφάλμα! Η τροποποίηση δεν πραγματοποιήθηκε: ' . $mysqli->error . '")) {
                history.go (-1);
                }
                </script>';
    }
$mysqli->close(); //Κλείσιμο σύνδεσης με ΒΔ.




?>