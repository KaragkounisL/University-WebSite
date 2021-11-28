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
	<div style="height:100%; overflow: hidden;">
            <!-- Πίνακας για εμφάνιση όλων των χρηστών με δυνατότητα τροποποίησης ή διαγραφής τους. -->
            <table width="100%" align="center" style="border-collapse: collapse; border: 1px solid black;">
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
					<td>Εξάμηνο</td>
					<td>Save</td>
					<td>Del</td>
                </tr>
                <?php
                //Ζητάμε από τη Β.Δ. να μας επιστρέψει τα καταχωρημένα στοιχεία χρηστών.
                $question = "SELECT id_Χρήστη, Όνομα, Επώνυμο, Κινητό, Email, AES_DECRYPT(password, UNHEX(SHA2('eap', 256))) as decrypt, Ρόλος, Διεύθυνση, Ημερομηνία_Γέννησης, 
								Ημερομηνία_Πρώτης_Εγγραφής, Αριθμός_Μητρώου FROM χρήστης ORDER BY Ρόλος";
                $result = $mysqli->query($question);
                if ($result) { //Αν υπάρχουν χρήστες στη Β.Δ.
                    if ($result->num_rows > 0) { //Όσο βρίσκονται χρήστες στη Β.Δ.
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
							$semester = NULL;
							//Έλεγχος για φοιτητή
							if ($role == "Φοιτητής"){
								$q1 = "SELECT Εξάμηνο FROM εξάμηνο WHERE id_Χρήστη ='$id'";
								$r1 = $mysqli->query($q1);
								while ($data = $r1->fetch_assoc()) {
									$semester = $data["Εξάμηνο"];
								}
							}
							
                            ?>                
                             <tr style="background-color: grey; color:white">
                                <td align="center"><?= $fName ?></td>
                                <td align="center"><?= $lName ?></td>
                                <td align="center"><?= $phone ?></td>
                                <td align="center"><?= $email ?></td>
                                <td align="center"><?= $password ?></td>
                                <td align="center"><?= $role ?></td>
                                <td align="center"><?= $address ?></td>
                                <td align="center"><?= $birthDate ?></td>
								<td align="center"><?= $registerDate ?></td>
								<td align="center"><?= $mitroo ?></td>
								<td align="center"><?= $semester ?></td>
								<td></td>
								<td></td>
                            </tr>
							<tr style="border-bottom: 1pt solid black;">
                                <!--Φόρμα τροποποίησης/διαγραφής υπάρχοντων χρηστών--> 
                            <form name="UpdateDeleteform" action="hidden/UpdateDeleteUser.php" method="POST" onchange="setCheckState();" onsubmit="return validateRegister();">
                                <input hidden="" style="width: 99%;" type="text" name="id_Χρήστη" required="" placeholder="" value="<?= $id ?>">                                
                                <td><input style="width: 99%; text-align:center;" type="text" name="Όνομα" required="" placeholder="" value="<?= $fName ?>"></td>
								<td><input style="width: 99%; text-align:center;" type="text" name="Επώνυμο" required="" placeholder="" value="<?= $lName ?>"></td>
								<td><input style="width: 99%; text-align:center;" type="text" name="Κινητό" placeholder="" value="<?= $phone ?>"></td>
                                <td><input style="width: 99%; text-align:center;" type="email" name="Email" required="" placeholder="" value="<?= $email ?>"></td>        
								<td><input style="width: 99%; text-align:center;" type="password" name="Password" required="" placeholder="" value="<?= $password ?>"></td>
								<td  style="padding:5px "><select id="role" name="Ρόλος" required disabled style="float: left; width: 104%; text-align:center;">
									<option value="<?= $role ?>" selected><?= $role ?></option>
									<option value="Γραμματεία">Γραμματεία</option>
									<option value="Καθηγητής">Καθηγητής</option>
									<option value="Φοιτητής">Φοιτητής</option>
									</select>
								</td>
								<td><input style="width: 99%; text-align:center;" type="text" name="Διεύθυνση"  placeholder="" value="<?= $address ?>"></td>
								<td><input style="width: 99%; text-align:center;" type="date" name="Ημερομηνία_Γέννησης" placeholder="" value="<?= $birthDate ?>"></td>
								<td><input style="width: 99%; text-align:center;" type="date" name="Ημερομηνία_Πρώτης_Εγγραφής" placeholder="" value="<?= $registerDate ?>"></td>
								<td><input style="width: 99%; text-align:center;" type="text" name="Αριθμός_Μητρώου"  placeholder="" value="<?= $mitroo ?>"></td>
								<td><input style="width: 99%; text-align:center;" type="number" min="1" max="3" step="1" required name="Εξάμηνο" <?php if($semester===NULL) {
																	echo "disabled='true'"; echo "required='false'"; } ?>  placeholder="" value="<?= $semester ?>"></td>
                                <td align="center"><button type="submit" alt="save icon is missing" name="save" onclick="return confirm('Θέλετε όντως να αποθηκευτούν τα νέα δεδομένα χρήστη;');">
									<img src="images/save.png" alt="save icon" width="15" height="15"></button>
								</td>
                                <td align="center"><button type="submit" alt="delete icon is missing" name="delete" onclick="return confirm('Προσοχή! Θέλετε όντως να διαγραφεί ο χρήστης;');">
									<img src="images/delete.png" alt="delete icon" width="15" height="15"></button>
								</td>               
                            </form> 
                            </tr>
                            <?php
                        }
                    }
                    $result->close(); //Κλείσιμο $result για καθαρισμό μνήμης.
                }
                ?>				
            </table>        
        </div>				
	<?php
        $mysqli->close();
		?> 		
	</body>


</html>