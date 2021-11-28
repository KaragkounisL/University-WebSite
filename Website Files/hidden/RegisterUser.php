<?php

require 'connectDB.php';

$fName = $_POST['Όνομα'];
$lName = $_POST['Επώνυμο'];
$phone = $_POST['Κινητό'];
$email = $_POST['email'];
$password = $_POST['password'];
$address = $_POST['Διεύθυνση'];
$regnumber = $_POST['Αριθμός_Μητρώου'];
$pref = $_POST['Ρόλος'];
$birthDate = $_POST['Ημερομηνία_Γέννησης'];
$registerDate = $_POST['Ημερομηνία_Πρώτης_Εγγραφής'];
$semester = $_POST['Εξάμηνο'];
$id = NULL;

//Ελέγχουμε ότι το E-mail δεν υπάρχει ήδη στη Β.Δ. από άλλον λογαριασμό.
$question = "SELECT Email FROM χρήστης WHERE Email = '$email'";
$result = $mysqli->query($question);

if ($result->num_rows == 0) { //Αν το E-mail δεν βρεθεί στη Β.Δ. εισάγουμε νέα εγγραφή.
    $question = "INSERT INTO χρήστης (Όνομα, Επώνυμο, Κινητό, Email, Password, Ρόλος, Διεύθυνση, Ημερομηνία_Γέννησης, Ημερομηνία_Πρώτης_Εγγραφής, Αριθμός_Μητρώου) VALUES('$fName', '$lName', '$phone', '$email', AES_ENCRYPT('$password', UNHEX(SHA2('eap', 256))), '$pref', '$address', nullif('$birthDate', ''), nullif('$registerDate', ''), '$regnumber')";
    if ($mysqli->query($question) === true) {
		if ($pref == "Φοιτητής"){			
			$id = $mysqli -> insert_id;
			$eks = "INSERT INTO εξάμηνο (id_Χρήστη, Εξάμηνο) VALUES('$id','$semester')";
			if ($mysqli->query($eks) === false) {
				echo '  <script language="javascript" type="text/javascript">
                if (!alert ("Σφάλμα! Η εγγραφή δεν πραγματοποιήθηκε: ' . $mysqli->error . '")) {
                history.go (-1);
                }
                </script>';
			}			
		}		
        echo '  <script language="javascript" type="text/javascript">
                if (!alert ("Η εγγραφή πραγματοποιήθηκε")) {
                location.href = "../Admin.php";
                }
                </script>';		
        exit();
    } else { //Αν η εγγραφή αποτύχει εξαιτίας ενός σφάλματος.
        echo '  <script language="javascript" type="text/javascript">
                if (!alert ("Σφάλμα! Η εγγραφή δεν πραγματοποιήθηκε: ' . $mysqli->error . '")) {
                history.go (-1);
                }
                </script>';
    }
} else { //Αν το E-mail υπάρχει ήδη στη Β.Δ. ενημέρώνουμε τον χρήστη για την αποτυχία εγγραφής.
    echo '  <script language="javascript" type="text/javascript">
            if (!alert ("Το E-mail χρησιμοποιείται ήδη από άλλο χρήστη!Προσπαθήστε ξανά με διαφορετικό E-mail.")) {
            history.go (-1);
            }
            </script>';
    exit();
}

$result->close(); //Κλείσιμο $result για καθαρισμό μνήμης.
$mysqli->close(); //Κλείσιμο σύνδεσης με ΒΔ.
?>