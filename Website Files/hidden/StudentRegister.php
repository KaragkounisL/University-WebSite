<?php
//Περίπτωση εγγραφής
if (isset($_POST["register"])) {

    require 'connectDB.php';

    session_start();

	$id = $_POST["id_Χρήστη"];
	$sid = $_POST["id_Μαθήματος"];
	
	//Έλεγχος αν υπάρχει η αντίστοιχη εγγραφή στν Β.Δ
	$q2 = "SELECT id_Εγγραφής FROM εγγραφές WHERE id_Χρήστη = '$id' AND id_Μαθήματος ='$sid'";
	$r2 = $mysqli->query($q2);
	while ($row2 = mysqli_fetch_array($r2)) {
		$idr = $row2["id_Εγγραφής"];
	}
	
	//Δημιουργία νέας εγγραφής  στη Β.Δ. αν δεν υπάρχει η εγγραφή	
	if ($r2->num_rows == 0){
		$question = "INSERT INTO εγγραφές (id_Χρήστη, id_Μαθήματος, Κατάσταση) VALUES('$id', '$sid', 'Εγγεγραμμένος/η')";
		if ($mysqli->query($question) === true) {
			//Με την επιτυχή δημιουργία των στοιχείων της νέας εγγραφής επιστρέφουμε στην προηγούμενη σελίδα.
			echo '  <script language="javascript" type="text/javascript">
					 history.go (-1);
				</script>';
			exit();
		}else { //Αν η εγγραφή αποτύχει εξαιτίας ενός σφάλματος.
			echo '  <script language="javascript" type="text/javascript">
            if (!alert ("Σφάλμα! Η ... δεν πραγματοποιήθηκε: ' . $mysqli->error . '")) {
            location.href="../StudentRegister.php";
            }
            </script>';
		}
	//Αλλιώς αν η εγγραφή υπάρχει ήδη, απλά ενημερώνουμε και αλλάζουμε την κατάσταση εγγραφής	
	}else{
		$question ="UPDATE εγγραφές SET Κατάσταση ='Εγγεγραμμένος/η'  WHERE id_Εγγραφής = $idr";
		if ($mysqli->query($question) === true) {//Επιστροφή στην προηγούμενη σελίδα
			echo '<script language="javascript" type="text/javascript">
				location.href="../StudentRegister.php";
            </script>';
			exit();
		}else{//Αν η ενημέρωση εγγραφής αποτύχει εξαιτίας ενός σφάλματος.
			echo '  <script language="javascript" type="text/javascript">
            if (!alert ("Σφάλμα! Η ... δεν πραγματοποιήθηκε: ' . $mysqli->error . '")) {
            location.href="../StudentRegister.php";
            }
            </script>';
		}
	}	

    $mysqli->close(); //Κλείσιμο σύνδεσης με ΒΔ.

//Περίπτωση κατάργησης εγγραφής    
} else if (isset($_POST["unregister"])) {

    require 'connectDB.php';

    session_start();

    $regid = $_POST['id_Εγγραφής'];
	$id = $_POST["id_Χρήστη"];
	$sid = $_POST["id_Μαθήματος"];

//Ενημερώνουμε και αλλάζουμε την κατάσταση εγγραφής
    $question ="UPDATE εγγραφές SET Κατάσταση ='Μη εγγεγραμμένος/η'  WHERE id_Εγγραφής = $regid AND id_Μαθήματος ='$sid'";

    if ($mysqli->query($question) === true) {//Επιστροφή στην προηγούμενη σελίδα
        echo '<script language="javascript" type="text/javascript">
				location.href="../StudentRegister.php";
            </script>';
        exit();
    } else {//Αν η ενημέρωση εγγραφής αποτύχει εξαιτίας ενός σφάλματος.
       echo '  <script language="javascript" type="text/javascript">
            if (!alert ("Σφάλμα! Η ... δεν πραγματοποιήθηκε: ' . $mysqli->error . '")) {
            location.href="../StudentRegister.php";
            }
            </script>';
    }

    $mysqli->close(); //Κλείσιμο σύνδεσης με ΒΔ.
}
?>