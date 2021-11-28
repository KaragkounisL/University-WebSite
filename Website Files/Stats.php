<?php
session_start();

require 'hidden/connectDB.php';
//Ορίζουμε μεταβλητές και αποθηκεύουμε σε αυτές τα στοιχεία χρήστη που υπάρχουν στο SESSION.
$fName = $_SESSION['Όνομα'];
$lName = $_SESSION['Επώνυμο'];
$role = $_SESSION['Ρόλος'];

$userId = $_POST["id_Χρήστη"];
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];

$Reqpassed = 0;
$Chopassed = 0;
$stdects = 0;
$registered = 0;

$q1 = "SELECT Εξάμηνο FROM εξάμηνο WHERE  id_Χρήστη ='$userId'";
$r1 = $mysqli->query($q1);
if ($r1) { //Αν υπάρχουν χρήστες στη Β.Δ.
	if ($r1->num_rows > 0) {
		while ($row1 = $r1->fetch_assoc()) {
			$stdsemester = $row1["Εξάμηνο"];
		}
	}
}$r1->close();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Διαχείριση</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style/style.css" /><!--Μορφοποίηση-->
        <script src="scripts/Javascript.js" type="text/javascript"></script><!--Αρχείο Javascript για ελέγχους-->
    </head>
	<body>
	<table cellpadding="10" width="100%">
		<td width="100px"><!-- Λογότυπο-->
			<img width="200" height="80"  src="./images/logo.png" alt="Λογότυπο">
		</td>
		
		<!-- Εμφάνιση Τίτλος, Αποσύνδεση -->
		<td align="center" width="1000px">
			<p><b>ΗΛΕΚΤΡΟΝΙΚΗ ΓΡΑΜΜΑΤΕΙΑ</b></p>
			<p>ΜΕΤΑΠΤΥΧΙΑΚΟΥ ΠΡΟΓΡΑΜΜΑΤΟΣ ΣΠΟΥΔΩΝ</p> 
			<p>ΣΤΗΝ ΤΕΧΝΗΤΗ ΝΟΗΜΟΣΥΝΗ</p>
			<p>ΤΜΗΜΑ ΠΛΗΡΟΦΟΡΙΚΗΣ</p>
			<p>ΑΡΙΣΤΟΤΕΛΕΙΟ ΠΑΝΕΠΙΣΤΗΜΙΟ ΘΕΣΣΑΛΟΝΙΚΗΣ</p>
		</td>
		
		<td align="center" width="200px">		
			  <div class="navbar">
                        <div class="dropdown">
                            <button class="dropbtn"  style="width: 140%">
                                <a><img src="./images/user.png" alt="" style="vertical-align: middle" width="42" height="42"/></a>
                                <a style="color: blue;">&nbsp;<br><?= $fName ?>&nbsp;<?= $lName ?></a>
                            </button>
                            <div class="dropdown-content">
                                <a href="Profile.php">Προφίλ</a>                                      
                                <a href="./hidden/Logout.php">Αποσύνδεση</a>
                            </div>
                        </div>
                    </div>                    
		</td>
	</table>
	<h3>
	<table border="1" cellpadding="10" width="100%">
		<td align="center" width="25%"><a href="./Admin.php" style="text-decoration: none;">Αρχική Σελίδα Διαχείρισης</a></td>
		<td align="center" width="25%">	
			<div class="dropdown">
			Διαχείριση Χρηστών
			<div class="dropdown-content">
				<a href="./register.php">Εγγραφή</a>
				<a href="./modify.php">Τροποποίηση / Διαγραφή</a>
			</div>
		</td>
        <td align="center" width="25%">
		<div class="dropdown">
			Διαχείριση Μαθημάτων
			<div class="dropdown-content">
				<a href="./subjectregister.php">Eισαγωγή</a>
				<a href="./subjectmodify.php">Τροποποίηση / Διαγραφή</a>
			</div>
		</td>
		<td align="center" width="25%"><a href="./studentstats.php" style="text-decoration: none;">Στατιστικά Στοιχεία Φοιτητών</a></td>
	</table>
	</h3>
	
	
	<?php 
	//Ζητάμε από τη Β.Δ. να μας επιστρέψει τα καταχωρημένα στοιχεία μαθημάτων πρώτου εξαμήνου.
	$question = "SELECT id_Μαθήματος, Τύπος FROM μαθήματα WHERE  Εξάμηνο ='1'";
    $result = $mysqli->query($question);
    if ($result) { //Αν υπάρχουν χρήστες στη Β.Δ.
		if ($result->num_rows > 0) { //Όσο βρίσκονται δεδομένα στη Β.Δ.
			while ($row = $result->fetch_assoc()) {
				$sid = $row["id_Μαθήματος"];
				$stype = $row["Τύπος"];
				//Ζητάμε από τη Β.Δ. να μας επιστρέψει id_Εγγραφής, Κατάσταση και Βαθμό από τον πίνακα εγγραφών με τα αντίστοιχα κριτήρια.
				$question1 = "SELECT id_Εγγραφής, Κατάσταση, Βαθμός FROM εγγραφές WHERE  id_Χρήστη ='$userId' AND id_Μαθήματος ='$sid'";
				$result1 = $mysqli->query($question1);
				if ($result1->num_rows > 0) {
					while ($row1 = $result1->fetch_assoc()) {
						$regid = $row1["id_Εγγραφής"];
						$state = $row1["Κατάσταση"];
						$grade = $row1["Βαθμός"];
						//Counter για καταμέτρηση εγγραφών
						if($state == "Εγγεγραμμένος/η"){
							$registered++;
						}
					}
					$result1->close(); //Κλείσιμο $result1 για καθαρισμό μνήμης.
				}else{
					$regid = null;
					$state = null;
					$grade = null;
				}	
				if($grade >= 5){
					//Counter για καταμέτρηση διδακτικών μονάδων
					$stdects += $grade ;
					//Counter για καταμέτρηση υποχρεωτικών μαθημάτων που έχει περάσει ο φοιτητής
					if($stype == "Υποχρεωτικό"){
						$Reqpassed++; 
					}
					//Counter για καταμέτρηση μαθημάτων επιλογής που έχει περάσει ο φοιτητής
					else if ($stype == "Επιλογής"){
						$Chopassed++;
					}
				}
			}
		}
	}
	$result->close(); //Κλείσιμο $result για καθαρισμό μνήμης.						
	?>
	<?php 
	//Ζητάμε από τη Β.Δ. να μας επιστρέψει τα καταχωρημένα στοιχεία μαθημάτων δεύτερου εξαμήνου.
	$question = "SELECT id_Μαθήματος, Τύπος FROM μαθήματα WHERE  Εξάμηνο ='2'";
    $result = $mysqli->query($question);
    if ($result) { //Αν υπάρχουν χρήστες στη Β.Δ.
		if ($result->num_rows > 0) { //Όσο βρίσκονται δεδομένα στη Β.Δ.
			while ($row = $result->fetch_assoc()) {
				$sid = $row["id_Μαθήματος"];
				$stype = $row["Τύπος"];
				//Ζητάμε από τη Β.Δ. να μας επιστρέψει id_Εγγραφής, Κατάσταση και Βαθμό από τον πίνακα εγγραφών με τα αντίστοιχα κριτήρια.
				$question1 = "SELECT id_Εγγραφής, Κατάσταση, Βαθμός FROM εγγραφές WHERE  id_Χρήστη ='$userId' AND id_Μαθήματος ='$sid'";
				$result1 = $mysqli->query($question1);
				if ($result1->num_rows > 0) {
					while ($row1 = $result1->fetch_assoc()) {
						$regid = $row1["id_Εγγραφής"];
						$state = $row1["Κατάσταση"];
						$grade = $row1["Βαθμός"];
						//Counter για καταμέτρηση εγγραφών
						if($state == "Εγγεγραμμένος/η"){
							$registered++;
						}
					}
					$result1->close(); //Κλείσιμο $result1 για καθαρισμό μνήμης.
				}else{
					$regid = null;
					$state = null;
					$grade = null;
				}	
				if($grade >= 5){
					//Counter για καταμέτρηση διδακτικών μονάδων
					$stdects += $grade ;
					//Counter για καταμέτρηση υποχρεωτικών μαθημάτων που έχει περάσει ο φοιτητής
					if($stype == "Υποχρεωτικό"){
						$Reqpassed++; 
					}
					//Counter για καταμέτρηση μαθημάτων επιλογής που έχει περάσει ο φοιτητής
					else if ($stype == "Επιλογής"){
						$Chopassed++;
					}
				}
			}
		}
	}
	$result->close(); //Κλείσιμο $result για καθαρισμό μνήμης.						
	?>
	<?php 
	//Ζητάμε από τη Β.Δ. να μας επιστρέψει τα καταχωρημένα στοιχεία μαθημάτων τρίτου εξαμήνου.
	$question = "SELECT id_Μαθήματος, Τύπος FROM μαθήματα WHERE  Εξάμηνο ='3'";
    $result = $mysqli->query($question);
    if ($result) { //Αν υπάρχουν χρήστες στη Β.Δ.
		if ($result->num_rows > 0) { //Όσο βρίσκονται δεδομένα στη Β.Δ.
			while ($row = $result->fetch_assoc()) {
				$sid = $row["id_Μαθήματος"];
				$stype = $row["Τύπος"];
				//Ζητάμε από τη Β.Δ. να μας επιστρέψει id_Εγγραφής, Κατάσταση και Βαθμό από τον πίνακα εγγραφών με τα αντίστοιχα κριτήρια.
				$question1 = "SELECT id_Εγγραφής, Κατάσταση, Βαθμός FROM εγγραφές WHERE  id_Χρήστη ='$userId' AND id_Μαθήματος ='$sid'";
				$result1 = $mysqli->query($question1);
				if ($result1->num_rows > 0) {
					while ($row1 = $result1->fetch_assoc()) {
						$regid = $row1["id_Εγγραφής"];
						$state = $row1["Κατάσταση"];
						$grade = $row1["Βαθμός"];
						//Counter για καταμέτρηση εγγραφών
						if($state == "Εγγεγραμμένος/η"){
							$registered++;
						}
					}
					$result1->close(); //Κλείσιμο $result1 για καθαρισμό μνήμης.
				}else{
					$regid = null;
					$state = null;
					$grade = null;
				}	
				if($grade >= 5){
					//Counter για καταμέτρηση διδακτικών μονάδων
					$stdects += $grade ;
					//Counter για καταμέτρηση υποχρεωτικών μαθημάτων που έχει περάσει ο φοιτητής
					if($stype == "Υποχρεωτικό"){
						$Reqpassed++; 
					}
					//Counter για καταμέτρηση μαθημάτων επιλογής που έχει περάσει ο φοιτητής
					else if ($stype == "Επιλογής"){
						$Chopassed++;
					}
				}
			}
		}
	}
	$result->close(); //Κλείσιμο $result για καθαρισμό μνήμης.						
	?>
	<table cellpadding="10" width="100%">
	<tr>
		<td colspan="3" align="center"><h3><u>Στατιστικά Στοιχεία Φοιτητή : <?= $lastname ?> <?= $firstname ?></u></h3></td>
	</tr>
	<tr>
		<td width="33%" align="center" style="font-weight:bolder;">Eξάμηνο: <?=$stdsemester ?></td>
		<td width="33%" align="center" style="font-weight:bolder;">Μαθήματα που έχουν δηλωθεί: <?=$registered ?></td>
	</tr>
	<tr>
		<td width="33%" align="center" style="font-weight:bolder;">Υποχρεωτικά Μαθήματα με προβιβάσιμο βαθμό:  <?=$Reqpassed ?></td>
		<td width="33%" align="center" style="font-weight:bolder;">Μαθήματα Επιλογής με προβιβάσιμο βαθμό:   <?=$Chopassed ?></td>
		<td width="33%" align="center" style="font-weight:bolder;">Διδακτικές Μονάδες:  <?=$stdects ?></td>
	</tr>
	<tr>
		<td width="33%" align="center" style="font-weight:bolder;">Υποχρεωτικά Μαθήματα για πτυχίο:  <?= 8-$Reqpassed ?></td>
		<td width="33%" align="center" style="font-weight:bolder;">Μαθήματα Επιλογής για πτυχίο:   <?=1-$Chopassed ?></td>
		<td width="33%" align="center" style="font-weight:bolder;">Διδακτικές Μονάδες για πτυχίο:  <?=45-$stdects ?></td>
	</tr>
	</table>
	</body>
	</html>