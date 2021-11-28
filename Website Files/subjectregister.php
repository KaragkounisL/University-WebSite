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
		<form name="registersubjectform" action="hidden/RegisterSubject.php" method="POST">
            <table align="center" cellspacing="20" style="background-color: #f1f1f1" width="20%">
                <tr>
                    <td>*</td>
                    <td>
                        <input type="text" placeholder="Τίτλος" name="Τίτλος" maxlength="50" required="" size="50">
                    </td>
                </tr>
				<tr>
				 <!--Λίστα επιλογών Τύπου-->
				 <td>*</td>
                    <td>
                        <select name="Τύπος" style="float: left; width: 160px;" required>
                            <option value="" selected>Επιλέξτε Τύπο</option> <!-- Αν δεν επιλεγεί Τύπος -->
                            <option value="Υποχρεωτικό">Υποχρεωτικό</option>
							<option value="Επιλογής">Επιλογής</option>
                        </select>
                    </td>
				</tr>
				<tr>
				<!--Λίστα επιλογών Εξαμήνου-->
                    <td>*</td>
					<td>
                        <select name="Εξάμηνο" style="float: left; width: 160px;" required>
                            <option value="" selected>Επιλέξτε Εξάμηνο</option> <!-- Αν δεν επιλεγεί Εξάμηνο -->
                            <option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
                        </select>
                    </td>
				</tr>	
                <tr>
                    <td>*</td>
                    <td>
                        <input type="number" placeholder="Διδακτικές Μονάδες" name="Διδακτικές_Μονάδες" maxlength="10" required="" size="50">
                    </td>
                </tr>
				<tr>
					<td></td>
					<td>Διδάσκων</td>
				</tr>				
                <tr>
                    <td>*</td>
                    <td>
                        <input type="text" placeholder="Όνομα" name="Όνομα" maxlength="50" required="" size="50">
                    </td>
				</tr>
				<tr>
                    <td>*</td>	
					<td>
                        <input type="text" placeholder="Επώνυμο" maxlength="50" name="Επώνυμο" required="" size="50">
                    </td>
				</tr>
				<tr>
                    <td>*</td>				
					<td>
						<input type="email" placeholder="Email" maxlength="20" name="email" required="" size="50">
					</td>
                </tr>           
				<tr>
                    <td></td>
                    <td style="text-align: left;">Περιγραφή</td>
                </tr>
				<tr>
                    <td></td>
                    <td style="height:30px;">
						<input type="text" placeholder="" name="Περιγραφή" size="50" maxlength="20" style="height:100%;">
					</td>
                </tr>   				
                <tr>
                    <td colspan="3" align="center"><font color="red" size="2">Με (*) σημειώνονται τα υποχρεωτικά πεδία.</font></td>
                </tr>                
                <tr>
                    <td colspan="3" align="center">
                        <input type="submit" name="register" value="Εισαγωγή" style="align-content: center; background-color: #acb2bd; width: 120px; height: 40px; font-weight: bold;">
                    </td>
                </tr>
            </table>
        </form>
					
	<?php
        $mysqli->close();
		?> 		
	</body>


</html>