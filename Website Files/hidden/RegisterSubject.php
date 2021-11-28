<?php

require 'connectDB.php';

$fName = $_POST['Όνομα'];
$lName = $_POST['Επώνυμο'];
$email = $_POST['email'];
$title = $_POST['Τίτλος'];
$ects = $_POST['Διδακτικές_Μονάδες'];
$type = $_POST['Τύπος'];
$semester = $_POST['Εξάμηνο'];
$descr = $_POST['Περιγραφή'];
$id = NULL;



//Ελέγχουμε ότι o Τίτλος δεν υπάρχει ήδη στη Β.Δ.
$question = "SELECT Τίτλος FROM μαθήματα WHERE Τίτλος = '$title'";
$result = $mysqli->query($question);


$q2 = "SELECT id_Χρήστη FROM χρήστης WHERE Email = '$email' AND Όνομα ='$fName' AND Επώνυμο='$lName' AND Ρόλος='Καθηγητής'";
	$r2 = $mysqli->query($q2);
	while ($row = mysqli_fetch_array($r2)) {
		$id = $row["id_Χρήστη"];
	}


if ($result->num_rows == 0 and $r2->num_rows !== 0) { //Αν ο τίτλος δεν βρεθεί στη Β.Δ. και το email υπάρχει στη Β.Δ εισάγουμε νέα εγγραφή.
    $question3 = "INSERT INTO μαθήματα (id_Χρήστη, Τίτλος, Τύπος, Περιγραφή, Διδακτικές_Μονάδες, Εξάμηνο) VALUES('$id', '$title', '$type', '$descr', '$ects', '$semester')";
    if ($mysqli->query($question3) === true) {
        echo '  <script language="javascript" type="text/javascript">
                if (!alert ("Η εγγραφή πραγματοποιήθηκε")) {
                location.href = "../Admin.php";
                }
                </script>';
        exit();
    }else if($r2->num_rows == 0){
		echo '  <script language="javascript" type="text/javascript">
            if (!alert ("Τα στοιχεία που εισάγατε δεν αντιστοιχούν σε Καθηγητή. Προσπαθήστε ξανά με σωστά στοιχεία.")) {
            history.go (-1);
            }
            </script>';
		exit();
	}else { //Αν η εγγραφή αποτύχει εξαιτίας ενός σφάλματος.
        echo '  <script language="javascript" type="text/javascript">
                if (!alert ("Σφάλμα! Η εγγραφή δεν πραγματοποιήθηκε: ' . $mysqli->error . '")) {
                history.go (-1);
                }
                </script>';
    }
} else { //Ενημέρώνουμε τον χρήστη για την αποτυχία εγγραφής ανάλογα με την περίπτωση.
	if ($result->num_rows !== 0){
		echo '  <script language="javascript" type="text/javascript">
            if (!alert ("Ο τίτλος χρησιμοποιείται ήδη από άλλο μάθημα.Προσπαθήστε ξανά με διαφορετικό τίτλο.")) {
            history.go (-1);
            }
            </script>';
		exit();
	}
	else if($r2->num_rows == 0){
		echo '  <script language="javascript" type="text/javascript">
            if (!alert ("Τα στοιχεία που εισάγατε δεν αντιστοιχούν σε Καθηγητή. Προσπαθήστε ξανά με σωστά στοιχεία.")) {
            history.go (-1);
            }
            </script>';
		exit();
	}
}

$result->close(); //Κλείσιμο $result για καθαρισμό μνήμης.
$r2->close(); //Κλείσιμο $r2 για καθαρισμό μνήμης.
$mysqli->close(); //Κλείσιμο σύνδεσης με ΒΔ.
?>