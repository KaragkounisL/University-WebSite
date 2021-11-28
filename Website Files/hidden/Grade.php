<?php

require 'connectDB.php';

session_start();

$id = $_POST["id_Χρήστη"];
$grade = $_POST["Βαθμός"];
$sid = $_POST["id_Μαθήματος"];
//Ενημέρωση της εγγραφής του φοιτητή με τη νέα βαθμολογία
//Εδώ επίσης αλλάζουμε την κατάσταση εγγραφής του φοιτητή καθώς έχει καταχωρηθεί βαθμός
//Με αυτό τον τρόπο ο φοιτητής δεν χρειάζεται να κάνει μόνος του κατάργηση εγγραφής για μαθήματα που έχει αποτύχει ή περάσει
$question = "UPDATE εγγραφές SET Βαθμός = '$grade', Κατάσταση = 'Μη εγγεγραμμένος/η' WHERE id_Χρήστη = '$id' AND id_Μαθήματος ='$sid'";
if ($mysqli->query($question) === true) {
	        echo '  <script language="javascript" type="text/javascript">
                if (!alert ("Η τροποποίηση πραγματοποιήθηκε")) {
                location.href = "../ProfessorGrades.php";
                }
                </script>';		
        exit();
    } else { //Αν η βαθμολόγηση αποτύχει εξαιτίας ενός σφάλματος.
        echo '  <script language="javascript" type="text/javascript">
                if (!alert ("Σφάλμα! Η τροποποίηση δεν πραγματοποιήθηκε: ' . $mysqli->error . '")) {
                history.go (-1);
                }
                </script>';
    }
$mysqli->close(); //Κλείσιμο σύνδεσης με ΒΔ.
?>