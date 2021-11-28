<?php
session_start();

require 'hidden/connectDB.php';
//Ορίζουμε μεταβλητές και αποθηκεύουμε σε αυτές τα στοιχεία χρήστη που υπάρχουν στο SESSION.
$fName = $_SESSION['Όνομα'];
$lName = $_SESSION['Επώνυμο'];
$userId = $_SESSION['id_Χρήστη'];
$email = $_SESSION['email'];
$role = $_SESSION['Ρόλος'];
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Φοιτητές</title>
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
		
		<!-- Εμφάνιση Τίτλος -->
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
	<!-- Εμφάνιση Menu σελίδων φοιτητών -->
	</table>
	<h3>
	<table border="1" cellpadding="10" width="100%">
		<td align="center" width="33%"><a href="./Student.php" style="text-decoration: none;">Αρχική Σελίδα</a></td>
		<td align="center" width="33%"><a href="./StudentSubjects.php" style="text-decoration: none;">Μαθήματα</a></td>
		<td align="center" width="33%"><a href="./StudentRegister.php" style="text-decoration: none;">Εγγραφές / Στατιστικά</a></td>
	</table>
	</h3>
	<table style="background-color: #f1f1f1" width="100%" style="border:1px solid black">
		
		<tr>
			<td colspan="2" align="center"  style="border:1px solid black">
				<h3>Οδηγίες Χρήσης Σελίδας Φοιτητών</h3>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				H πλοήγηση των σελίδων φοιτητών γίνεται με το παραπάνω μενού και ακολουθεί σύντομη επεξήγηση των λειτουργιών
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center"><br>
			</td>
		</tr>			
		<tr>
			<td align="center" width="50%" style="border:1px solid black">
				<b>Αρχική Σελίδα :</b>
			</td>
			<td align="center" width="50%" style="border:1px solid black">
				Σας επιστρέφει στην Αρχική Σελίδα Φοιτητών
			</td>
		</tr>
				<tr>
			<td colspan="2" align="center"><br>
			</td>
		</tr>	
		<tr>
			<td align="center" width="50%" style="border:1px solid black">
				<b>Μαθήματα :</b>
			</td>
			<td align="center" width="50%" style="border:1px solid black">
				Λίστα με τα μαθήματα και τους βαθμούς του φοιτητή
			</td>
		</tr>
				<tr>
			<td colspan="2" align="center"><br>
			</td>
		</tr>	
		<tr>
			<td align="center" width="50%" style="border:1px solid black">
				<b>Εγγραφές / Στατιστικά :</b>
			</td>
			<td align="center" width="50%" style="border:1px solid black">
				Δυνατότητα φοιτητών να εγγραφούν στα μαθήματα ή να καταργήσουν την εγγραφή τους<br>
				και προβολή στατιστικών στοιχείων
			</td>
		</tr>
				<tr>
			<td colspan="2" align="center"><br>
			</td>
		</tr>	
	</table>
	<br><br><br>
	<p>
		Για περισσότερες πληροφορίες παρακαλώ επικοινωνήστε με τον διαχειρηστή Καραγκούνη Λεωνίδα<br>
		Email: <a href="mailto:std114163@eap.gr">std114163@eap.gr</a></p>
	</p>
					
	<?php
        $mysqli->close();
		?> 		
	</body>


</html>