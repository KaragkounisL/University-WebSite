<?php

if (isset($_POST['save'])) {


    require 'connectDB.php';

    session_start();

	$id = $_POST["id_Μαθήματος"];
	$title = $_POST["Τίτλος"];
    $type = $_POST["Τύπος"];
	$semester = $_POST["Εξάμηνο"];
	$ects = $_POST["Διδακτικές_Μονάδες"];
	$pfName = $_POST["Όνομα"];
    $plName = $_POST["Επώνυμο"];
    $pEmail = $_POST["Email"];
	$descr = $_POST["Περιγραφή"];
	$idp = NULL;
	$role = NULL;
	//Επιλογή id_Χρήστη καθηγητή
	$q2 = "SELECT id_Χρήστη FROM χρήστης WHERE Email = '$pEmail' AND Όνομα ='$pfName' AND Επώνυμο='$plName' AND Ρόλος='Καθηγητής'";
	$r2 = $mysqli->query($q2);
	while ($row = mysqli_fetch_array($r2)) {
		$idp = $row["id_Χρήστη"];
	}
	//Ενημερώνουμε τον πίνακα μαθήματα
	$question = "UPDATE μαθήματα SET id_Χρήστη = '$idp', Τίτλος = '$title', Τύπος = '$type', Περιγραφή = '$descr', Διδακτικές_Μονάδες = '$ects', Εξάμηνο = '$semester' WHERE id_Μαθήματος = $id";
	if ($mysqli->query($question) === true and $r2->num_rows !== 0) {//Ενημερώνουμε για την επιτυχή αποθήκευση των στοιχείων μαθήματος.
			echo '  <script language="javascript" type="text/javascript">
            if (!alert ("Τα νέα δεδομένα χρήστη αποθηκεύτηκαν με επιτυχία.")) {
            location.href="../subjectmodify.php";
            }
            </script>';
			exit();
	//Ενημερώνουμε αν τα δεδομένα για τον διδάσκοντα δεν αντιστοιχούν σε Καθηγητή		
	}else if($r2->num_rows == 0) { 
			echo '  <script language="javascript" type="text/javascript">
            if (!alert ("Τα δεδομένα δεν αντιστοιχούν σε Καθηγητή.")) {
            history.go (-1);
            }
            </script>';
	}else { //Αν η εγγραφή αποτύχει εξαιτίας ενός σφάλματος.
			echo '  <script language="javascript" type="text/javascript">
            if (!alert ("Σφάλμα! Η αποθήκευση των νέων δεδομένων χρήστη δεν πραγματοποιήθηκε: ' . $mysqli->error . '")) {
            location.href="../subjectmodify.php";
            }
            </script>';
		}
	
	
    $mysqli->close(); //Κλείσιμο σύνδεσης με ΒΔ.

    
} else if (isset($_POST['delete'])) {

    require 'connectDB.php';

    session_start();

    $id = $_POST['id_Μαθήματος'];

//Διαγράφουμε το μάθημα από τη Β.Δ.
    $question = "DELETE FROM μαθήματα WHERE id_Μαθήματος = '$id'";

    if ($mysqli->query($question) === true) {//Ενημερώνουμε τον διαχειριστή για την επιτυχή διαγραφή.
        echo '  <script language="javascript" type="text/javascript">
            if (!alert ("Το μάθημα διαγράφηκε.")) {
            history.go (-1);
            }
            </script>';
        exit();
    } else { //Αν η διαγραφή αποτύχει εξαιτίας ενός σφάλματος.
        echo '  <script language="javascript" type="text/javascript">
            if (!alert ("Σφάλμα! Η διαγραφή του μαθήματος δεν πραγματοποιήθηκε: ' . $mysqli->error . '")) {
            history.go (-1);
            }
            </script>';
    }

    $mysqli->close(); //Κλείσιμο σύνδεσης με ΒΔ.
}
?>