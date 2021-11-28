<?php
session_start();

$email = $_SESSION["email"];


include "hidden/connectDB.php";

//Ζητάμε από τη Β.Δ. να μας επιστρέψει τα καταχωρημένα στοιχεία του χρήστη.
$question = "SELECT id_Χρήστη, Όνομα, Επώνυμο, Κινητό, Email, AES_DECRYPT(password, UNHEX(SHA2('eap', 256))) as decrypt, Ρόλος, Διεύθυνση, Ημερομηνία_Γέννησης, Ημερομηνία_Πρώτης_Εγγραφής, Αριθμός_Μητρώου FROM χρήστης WHERE email = '$email'";
$result = $mysqli->query($question);
if ($result) {
    if ($result->num_rows > 0) { //Αν το E-mail βρεθεί στη Β.Δ. εμφανίζουμε τα δεδομένα χρήστη.
        while ($row = $result->fetch_assoc()) {
            $id = $row["id_Χρήστη"];
			$fName = $row["Όνομα"];
            $lName = $row["Επώνυμο"];
			$email = $row["Email"];
			$phone = $row["Κινητό"];
			$password = $row["decrypt"];
			$role = $row["Ρόλος"];
			$address = $row["Διεύθυνση"];
			$birthDate = $row["Ημερομηνία_Γέννησης"];
			$registerDate = $row["Ημερομηνία_Πρώτης_Εγγραφής"];
			$mitroo = $row["Αριθμός_Μητρώου"];
            break;
        }
    }
    $result->close(); //Κλείσιμο $result για καθαρισμό μνήμης.
}
$mysqli->close(); //Κλείσιμο σύνδεσης με ΒΔ.
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Προφίλ</title>
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
	</table>
	<h3>
	<table border="1" cellpadding="10" width="100%">
            <tr>
                <?php
                //Αν ο χρήστης είναι μέλος γραμματείας εμφανίζουμε τα αντίστοιχα menu των σελίδων διαχείρησης
                if ($role == 'Γραμματεία') {
                    echo '<td align="center" width="25%"><a href="./Admin.php" style="text-decoration: none;">Αρχική Σελίδα Διαχείρισης</a></td>
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
							<td align="center" width="25%"><a href="./studentstats.php" style="text-decoration: none;">Στατιστικά Στοιχεία Φοιτητών</a></td>';
				//Αν ο χρήστης είναι Καθηγητής εμφανίζουμε τα αντίστοιχα menu των σελίδων καθηγητών			
                }else if ($role == 'Καθηγητής'){
					echo'<td align="center" width="33%"><a href="./Professor.php" style="text-decoration: none;">Αρχική Σελίδα</a></td>
						<td align="center" width="33%"><a href="./ProfessorSubjects.php" style="text-decoration: none;">Μαθήματα</a></td>
						<td align="center" width="33%"><a href="./ProfessorGrades.php" style="text-decoration: none;">Βαθμολογίες</a></td>';
				//Αν ο χρήστης είναι φοιτητής εμφανίζουμε τα αντίστοιχα menu των σελίδων φοιτητών		
				}else if ($role == 'Φοιτητής'){
						echo '<td align="center" width="25%"><a href="./Student.php" style="text-decoration: none;">Αρχική Σελίδα</a></td>
						<td align="center" width="25%"><a href="./StudentSubjects.php" style="text-decoration: none;">Μαθήματα</a></td>
						<td align="center" width="25%"><a href="./StudentRegister.php" style="text-decoration: none;">Εγγραφές</a></td>
						<td align="center" width="25%"><a href="./StudentStat.php" style="text-decoration: none;">Στατιστικά Στοιχεία</a></td>';

				}	
                ?>
				</tr>
	</table>
	</h3>
	<div style="overflow: hidden;">
            <!-- Πίνακας για εμφάνιση στοιχείων χρήστη με δυνατότητα τροποποίησής τους. -->
            <table width="100%" align="center" style="border-collapse: collapse;">
				<tr style="font-size: large; font-weight: bolder;"> 
					<td colspan="10">Στοιχεία Προφίλ</td> 
				</tr>
                <tr style="border: 1px solid black; background-color: black; color: white; font-size: medium; text-align: center;">
                    <td>Όνομα</td>
                    <td>Επώνυμο</td>
                    <td>Κινητό</td>
                    <td>Email</td>
                    <td>Password</td>
                    <td>Ρόλος</td>
                    <td>Διεύθυνση</td>
                    <td>Ημερομηνία Γέννησης</td>
					<td>Ημερομηνία Πρώτης Εγγραφής</td>	
					<td>Αριθμός Μητρώου</td>
                </tr>
				
	<form name="Updateform" action="hidden/UpdateUser.php" method="POST" onchange="setCheckState();" onsubmit="return validateRegister();">
                                <!--Πίνακας στοιχείων χρήστη με απενεργοποιημένα πεδία για τις μεταβλητές που δεν επιτρέπονται αλλαγές-->
                                <input hidden="" style="width: 99%;" type="text" name="id_Χρήστη" required="" placeholder="" value="<?= $id ?>">                                
                                <td><input style="width: 98%; text-align:center;" type="text" name="Όνομα" disabled required="" placeholder="" value="<?= $fName ?>"></td>
								<td><input style="width: 98%; text-align:center;" type="text" name="Επώνυμο" disabled required="" placeholder="" value="<?= $lName ?>"></td>
								<td><input style="width: 98%; text-align:center;" type="text" name="Κινητό" placeholder="" value="<?= $phone ?>"></td>
                                <td><input style="width: 98%; text-align:center;" type="email" name="Email" disabled required="" placeholder="" value="<?= $email ?>"></td>        
								<td><input style="width: 98%; text-align:center;" type="password" name="Password" required="" placeholder="" value="<?= $password ?>"></td>
								<td><input style="width: 98%; text-align:center;" type="text" name="Ρόλος" disabled placeholder="" value="<?= $role ?>"></td>
								<td><input style="width: 98%; text-align:center;" type="text" name="Διεύθυνση"  placeholder="" value="<?= $address ?>"></td>
								<td><input style="width: 98%; text-align:center;" type="date" name="Ημερομηνία_Γέννησης" placeholder="" value="<?= $birthDate ?>"></td>
								<td><input style="width: 98%; text-align:center;" type="date" name="Ημερομηνία_Πρώτης_Εγγραφής" disabled placeholder="" value="<?= $registerDate ?>"></td>
								<td><input style="width: 98%; text-align:center;" type="text" name="Αριθμός_Μητρώου"  placeholder="" disabled value="<?= $mitroo ?>"></td>
				<tr>	
							<td align="center" colspan="10"><button type="submit" name="save" style="align-content: center; background-color: #acb2bd; width: 120px; height: 40px; font-weight: bold;" onclick="return confirm('Θέλετε όντως να αποθηκευτούν τα νέα δεδομένα χρήστη;');">Τροποποίηση</button></td>
				</tr>	
				</table>        
    </div>
</body>
</html>	