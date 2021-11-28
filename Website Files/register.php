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
		<td align="center" width="20%"><a href="./Admin.php" style="text-decoration: none;">Αρχική Σελίδα Διαχείρισης</a></td>
		<td align="center" width="20%">	
			<div class="dropdown">
			Διαχείριση Χρηστών
			<div class="dropdown-content">
				<a href="./register.php">Εγγραφή</a>
				<a href="./modify.php">Τροποποίηση / Διαγραφή</a>
			</div>
		</td>
        <td align="center" width="20%">
		<div class="dropdown">
			Διαχείριση Μαθημάτων
			<div class="dropdown-content">
				<a href="./subjectregister.php">Eισαγωγή</a>
				<a href="./subjectmodify.php">Τροποποίηση / Διαγραφή</a>
			</div>
		</td>
		<td align="center" width="20%"><a href="./studentstats.php" style="text-decoration: none;">Στατιστικά Στοιχεία Φοιτητών</a></td>
		<td align="center" width="20%"><a href="./studentsXML.php" style="text-decoration: none;">Εξαγωγή δεδομένων σε XML</a></td>
	</table>
	</h3>
	
	<form name="registerform" action="hidden/RegisterUser.php" method="POST" onsubmit="return validateRegister();">
            <table align="center" cellspacing="20" style="background-color: #f1f1f1" width="50%">
                <tr>
                    <td>*</td>
                    <td>
                        <input type="text" placeholder="Όνομα" name="Όνομα" maxlength="50" required="" size="50">
                    </td>
					 <td>
                        <input type="text" placeholder="Διεύθυνση" maxlength="50" name="Διεύθυνση" size="50">
                    </td>
                </tr>         
                <tr>
                    <td>*</td>
                    <td>
                        <input type="text" placeholder="Επώνυμο" name="Επώνυμο" maxlength="50" required="" size="50">
                    </td>
					<td>
						<input type="number" placeholder="Αριθμός Μητρώου" maxlength="20" name="Αριθμός_Μητρώου" size="50">
                    </td>
                </tr>
				<tr>
				 <!--Λίστα επιλογών Ρόλου-->
				 <td>*</td>
                    <td>
                        <select id="role" name="Ρόλος" style="float: left; width: 160px;" required onchange="validateControls();">
                            <option value="" selected>Επιλέξτε Ρόλο</option> <!-- Αν δεν επιλεγεί Ρόλος -->
                            <option value="Γραμματεία">Γραμματεία</option>
							<option value="Καθηγητής">Καθηγητής</option>
							<option value="Φοιτητής">Φοιτητής</option>
                        </select>
                    </td>
					<td>
                        <input type="text" placeholder="Κινητό" maxlength="20" name="Κινητό" size="50">
                    </td>
				</tr>
                <tr>
                    <td>*</td>
                    <td>
                        <input type="email" placeholder="Email" name="email" maxlength="50" required="" size="50">
                    </td>

                </tr>         
                <tr>
                    <td>*</td>
                    <td>
                        <!--Εισαγωγή Password με τουλάχιστον 8 χαρακτήρες-->
                        <input type="password" placeholder="Password" name="password" minlenght="8" required="" size="50">
                    </td>           
                </tr>
                <tr>
                    <td>*</td>
                    <td>
                        <!--Εισαγωγή επιβεβαίωσης Password με τουλάχιστον 8 χαρακτήρες-->
                        <input type="password" placeholder="Επιβεβαίωση Password" name="Επιβεβαίωση" minlength="8" required="" size="50">
                    </td>
                </tr>
				<tr>
                    <td id="star" style="visibility: hidden">*</td>				
					<td>
                        <input type="number" min="1" max="3" step="1" id="eksamino" placeholder="Εξάμηνο Φοίτησης" maxlength="20" name="Εξάμηνο" size="50" style="visibility: hidden">
                    </td>
				</tr>
                <tr>
                    <td></td>
                    <td style="text-align: left;">Ημερομηνία Γέννησης:</td>
                    <td>
                        <input  style="width: 320px;" type="date" name="Ημερομηνία_Γέννησης" size="100">                       
                    </td>
                </tr>
				<tr>
                    <td></td>
                    <td style="text-align: left;">Ημερομηνία Εγγραφής</td>
                    <td>
                        <input  style="width: 320px;" type="date" name="Ημερομηνία_Πρώτης_Εγγραφής">                       
                    </td>
                </tr>               
                <tr>
                    <td colspan="3" align="center"><font color="red" size="2">Με (*) σημειώνονται τα υποχρεωτικά πεδία.</font></td>
                </tr>                
                <tr>
                    <td colspan="3" align="center">
                        <input type="submit" name="register" value="Εγγραφή" style="align-content: center; background-color: #acb2bd; width: 120px; height: 40px; font-weight: bold;">
                    </td>
                </tr>
            </table>
        </form>
					
	<?php
        $mysqli->close();
		?> 		
	</body>


</html>