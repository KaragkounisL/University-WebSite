<?php
session_start();

require 'hidden/connectDB.php';
//Ορίζουμε μεταβλητές και αποθηκεύουμε σε αυτές τα στοιχεία χρήστη που υπάρχουν στο SESSION.
//Επίσης ορίζουμε 4 μεταβλητές counter για την παρουσίαση στατιστικών δεδομένων
$fName = $_SESSION['Όνομα'];
$lName = $_SESSION['Επώνυμο'];
$userId = $_SESSION['id_Χρήστη'];
$email = $_SESSION['email'];
$role = $_SESSION['Ρόλος'];
//Υποχρεωτικά μαθήματα που ο φοιτητής έχει περάσει
$Reqpassed = 0;
//Μαθήματα επιλογής που ο φοιτητής έχει περάσει
$Chopassed = 0;
//Διδακτικές Μονάδες που έχει ο φοιτητής
$stdects = 0;
//Αριθμός μαθημάτων που έχει δηλώσει ο φοιτητής
$registered = 0;


$q1 = "SELECT Εξάμηνο FROM εξάμηνο WHERE  id_Χρήστη ='$userId'";
$r1 = $mysqli->query($q1);
if ($r1) { //Αν υπάρχουν δεδομένα στη Β.Δ.
	if ($r1->num_rows > 0) {
		while ($row1 = $r1->fetch_assoc()) {
			$stdsemester = $row1["Εξάμηνο"];
		}
	}
}$r1->close();

//Εύρεση πόσα μαθήματα είναι αυτή τη στιγμή δηλωμένα απο τον φοιτητή και αποθηκεύση 
//σε μια μεταβλητή για χρήση παρακάτω σε ελέγχους
$count = 0;
$q2 = "SELECT id_Εγγραφής FROM εγγραφές WHERE  id_Χρήστη ='$userId' AND Κατάσταση ='Εγγεγραμμένος/η'";
$r2 = $mysqli->query($q2);
if ($r2) { //Αν υπάρχουν δεδομένα στη Β.Δ.
	if ($r2->num_rows > 0) {
		while ($row2 = $r2->fetch_assoc()) {
			$count++; 
		}
	}
}$r2->close();
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
	</table>
	<h3>
	<table border="1" cellpadding="10" width="100%">
		<td align="center" width="33%"><a href="./Student.php" style="text-decoration: none;">Αρχική Σελίδα</a></td>
		<td align="center" width="33%"><a href="./StudentSubjects.php" style="text-decoration: none;">Μαθήματα</a></td>
		<td align="center" width="33%"><a href="./StudentRegister.php" style="text-decoration: none;">Εγγραφές / Στατιστικά</a></td>
	</table>
	</h3>


<table cellpadding="0" width="100%" border=1 style="border-collapse:collapse;" >
		<tr>
			<td align="center" style="background-color:gray;"><b>Eξάμηνο</b></td>
			<td align="center" style="background-color:gray;"><b>Μάθημα</b></td>
			<td align="center" style="background-color:gray;"><b>Διδάσκων</b></td>
			<td align="center" style="background-color:gray;"><b>Διδακτικές<br>Mονάδες</b></td>
			<td align="center" style="background-color:gray;"><b>Είδος</b></td>
			<td align="center" style="background-color:gray;"><b>Εγγραφή</b></td>
		</tr>
		<tr>
			<td align="center">1</td>
			<td align="center">
				<table width="100%" style="border-collapse: collapse;" cellpadding="16">
				<?php 
				//Ζητάμε από τη Β.Δ. να μας επιστρέψει Τίτλο μαθημάτων πρωτου εξαμήνου απο τον πίνακα μαθήματα.
                $question = "SELECT Τίτλος FROM μαθήματα WHERE  Εξάμηνο ='1'";
                $result = $mysqli->query($question);
                if ($result) { //Αν υπάρχουν μαθήματα στη Β.Δ.
					if ($result->num_rows > 0) { //Όσο βρίσκονται μαθήματα στη Β.Δ., τα εμφανίζουμε στον φοιτητή
						while ($row = $result->fetch_assoc()) {
							$title = $row["Τίτλος"];
							?>                
							<tr style="border-bottom:1px solid;">
								<td align="center" style="color:blue;"><?= $title ?></td>
							</tr>
							<?php
						}
					}
				}
				$result->close(); //Κλείσιμο $result για καθαρισμό μνήμης.						
				?>
				</table>
			</td>
			<td align="center">
				<table width="100%" style="border-collapse: collapse;" cellpadding="16">
				<?php 
				//Ζητάμε από τη Β.Δ. να μας επιστρέψει το id_Χρήστη απο τον πίνακα μαθημάτων για το εξάμηνο 1.
                $question = "SELECT id_Χρήστη FROM μαθήματα WHERE  Εξάμηνο ='1'";
                $result = $mysqli->query($question);
                if ($result) { //Αν υπάρχουν δεδομένα στη Β.Δ.
					if ($result->num_rows > 0) { //Όσο βρίσκονται δεδομένα στη Β.Δ.
						while ($row = $result->fetch_assoc()) {
							$id = $row["id_Χρήστη"];
							//Ζητάμε από τη Β.Δ. να μας επιστρέψει το όνομα και επώνυμο χρήστη από τον πίνακα χρηστών με τα αντίστοιχα κριτήρια.
							$question1 = "SELECT Όνομα, Επώνυμο FROM χρήστης WHERE  id_Χρήστη ='$id'";
							$result1 = $mysqli->query($question1);
							if ($result1->num_rows > 0) {
								while ($row1 = $result1->fetch_assoc()) {
									$fname = $row1["Όνομα"];
									$lname = $row1["Επώνυμο"];
								}
								$result1->close(); //Κλείσιμο $result1 για καθαρισμό μνήμης.
							}
							?>                
							<tr style="border-bottom:1px solid;">
								<td align="center" style="color:blue;"><?= $fname ?> <?= $lname ?></td>
							</tr>
							<?php
						}
					}
				}
				$result->close(); //Κλείσιμο $result για καθαρισμό μνήμης.						
				?>
				</table>
			</td>
			<td align="center">
				<table width="100%" style="border-collapse: collapse;" cellpadding="16">
				<?php 
				//Ζητάμε από τη Β.Δ. να μας επιστρέψει τις διδακτικές μονάδες απο τον πίνακα μαθημάτων για το εξάμηνο 1.
                $question = "SELECT Διδακτικές_Μονάδες FROM μαθήματα WHERE  Εξάμηνο ='1'";
                $result = $mysqli->query($question);
                if ($result) { //Αν υπάρχουν δεδομένα στη Β.Δ..
					if ($result->num_rows > 0) { //Όσο βρίσκονται δεδομένα στη Β.Δ., τα εμφανίζουμε στον φοιτητή
						while ($row = $result->fetch_assoc()) {
							$ects = $row["Διδακτικές_Μονάδες"];
							?>                
							<tr style="border-bottom:1px solid;">
								<td align="center" style="color:blue;"><?= $ects ?></td>
							</tr>
							<?php
						}
					}
				}
				$result->close(); //Κλείσιμο $result για καθαρισμό μνήμης.						
				?>
				</table>
			</td>
			<td align="center">
				<table width="100%" style="border-collapse: collapse;" cellpadding="16">
				<?php 
				//Ζητάμε από τη Β.Δ. να μας επιστρέψει τον τύπο μαθήματος απο τον πίνακα μαθημάτων για το εξάμηνο 1.
                $question = "SELECT Τύπος FROM μαθήματα WHERE  Εξάμηνο ='1'";
                $result = $mysqli->query($question);
                if ($result) { //Αν υπάρχουν δεδομένα στη Β.Δ..
					if ($result->num_rows > 0) { //Όσο βρίσκονται δεδομένα στη Β.Δ., τα εμφανίζουμε στον φοιτητή
						while ($row = $result->fetch_assoc()) {
							$type = $row["Τύπος"];
							?>                
							<tr style="border-bottom:1px solid;">
								<td align="center" 
									<?php if($type == "Υποχρεωτικό"){
										echo'style="color:blue;"';
									}else if ($type == "Επιλογής"){
										echo'style="color:green;"';
									}										
										?>
										><?= $type ?></td>
							</tr>
							<?php
						}
					}
				}
				$result->close(); //Κλείσιμο $result για καθαρισμό μνήμης.						
				?>
				</table>
			</td>
			<td align="center">
				<table width="100%" style="border-collapse: collapse;" cellpadding="10">
				<?php 
				//Ζητάμε από τη Β.Δ. να μας επιστρέψει τα καταχωρημένα στοιχεία μαθημάτων για το εξάμηνο 1 με τα ανίστοιχα κριτήρια.
                $question = "SELECT id_Μαθήματος, Τύπος FROM μαθήματα WHERE  Εξάμηνο ='1'";
                $result = $mysqli->query($question);
                if ($result) { //Αν υπάρχουν δεδομένα στη Β.Δ.
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
									//Αυξηση κατα 1 του counter για μαθήματα που έχει εγγραφέι ο χρήστης
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
							//Φόρμα με hidden input για την εγγραφή ή κατάργηση εγγραφής μαθημάτων
							//Γίνονται οι απαραίτητοι έλεγχοι και αυξάνονται τα ανάλογα counter για χρήση σε προβολή στατιστικών στοιχείων
							?>
								<tr style="border-bottom:1px solid;">
								<td align="center" <?php if($grade>=5){echo'style="background-color:#b3ffb3"';} ?>>
								<form name="registerform" action="hidden/StudentRegister.php" method="POST">
									<input hidden="" type="text" name="id_Εγγραφής" placeholder="" value="<?= $regid ?>">
									<input hidden="" type="text" name="id_Μαθήματος" placeholder="" value="<?= $sid ?>">
									<input hidden="" type="text" name="id_Χρήστη" placeholder="" value="<?= $userId ?>">
								<?php if($stdsemester >= 1 and $count<4 and ($grade == null or $grade <5)){
											if($state == "Εγγεγραμμένος/η"){
												echo'<button type="submit" name="unregister" style="width:150px; height:30px; background-color:red;">Κατάργηση Εγγραφής</button>';
											}else{
												echo'<button type="submit" name="register" style="width:150px; height:30px; background-color:green;">Εγγραφή</button>';
											}
										}else if($state == "Εγγεγραμμένος/η" and $count>=4){
											echo'<button type="submit" name="unregister" style="width:150px; height:30px; background-color:red;">Κατάργηση Εγγραφής</button>';
										}
										else if($grade >= 5){
											echo'<button style="width:150px; height:30px;background-color:#b3ffb3; color:black; border:none; font-weight: bold;" disabled>Βαθμός: '; 
											echo $grade; echo'</button>';
											$stdects += $grade ;
											if($stype == "Υποχρεωτικό"){
												$Reqpassed++; 
											}
											else if ($stype == "Επιλογής"){
												$Chopassed++;
											}
										}
										else{
											echo'<button style="width:150px; height:30px;background-color:grey;" disabled>Μη διαθέσιμο</button>';
										}	
								  ?>
								</form>
								</td>
								</tr>		
								<?php
						}
					}
				}
				$result->close(); //Κλείσιμο $result για καθαρισμό μνήμης.						
				?>
				</table>
			</td>
		</tr>
		<tr>
			<td align="center">2</td>
			<td align="center">
				<table width="100%" style="border-collapse: collapse;" cellpadding="16">
				<?php 
				//Ζητάμε από τη Β.Δ. να μας επιστρέψει Τίτλο μαθήματος δεύτερου εξαμήνου απο τον πίνακα μαθήματα.
                $question = "SELECT Τίτλος FROM μαθήματα WHERE  Εξάμηνο ='2'";
                $result = $mysqli->query($question);
                if ($result) { //Αν υπάρχουν μαθήματα στη Β.Δ.
					if ($result->num_rows > 0) { //Όσο βρίσκονται μαθήματα στη Β.Δ., τα εμφανίζουμε στον χρήστη
						while ($row = $result->fetch_assoc()) {
							$title = $row["Τίτλος"];						
							?>                
							<tr style="border-bottom:1px solid;">
								<td align="center" style="color:blue;"><?= $title ?></td>
							</tr>
							<?php
						}
					}
				}
				$result->close(); //Κλείσιμο $result για καθαρισμό μνήμης.						
				?>
				</table>
			</td>
			<td align="center">
				<table width="100%" style="border-collapse: collapse;" cellpadding="16">
				<?php 
				//Ζητάμε από τη Β.Δ. να μας επιστρέψει id_Χρήστη απο τον πίνακα μαθήματα με τα αντίστοιχα κριτήρια.
                $question = "SELECT id_Χρήστη FROM μαθήματα WHERE  Εξάμηνο ='2'";
                $result = $mysqli->query($question);
                if ($result) { //Αν υπάρχουν δεδομένα στη Β.Δ.
					if ($result->num_rows > 0) { //Όσο βρίσκονται δεδομένα στη Β.Δ.
						while ($row = $result->fetch_assoc()) {
							$id = $row["id_Χρήστη"];
							//Ζητάμε από τη Β.Δ. να μας επιστρέψει το όνομα και επώνυμο χρήστη από τον πίνακα χρηστών με τα αντίστοιχα κριτήρια.
							$question1 = "SELECT Όνομα, Επώνυμο FROM χρήστης WHERE  id_Χρήστη ='$id'";
							$result1 = $mysqli->query($question1);
							if ($result1->num_rows > 0) {
								while ($row1 = $result1->fetch_assoc()) {
									$fname = $row1["Όνομα"];
									$lname = $row1["Επώνυμο"];
								}
								$result1->close(); //Κλείσιμο $result για καθαρισμό μνήμης.
							}
							?>                
							<tr style="border-bottom:1px solid;">
								<td align="center" style="color:blue;"><?= $fname ?> <?= $lname ?></td>
							</tr>
							<?php
						}
					}
				}
				$result->close(); //Κλείσιμο $result για καθαρισμό μνήμης.						
				?>
				</table>
			</td>
			<td align="center">
				<table width="100%" style="border-collapse: collapse;" cellpadding="16">
				<?php 
				//Ζητάμε από τη Β.Δ. να μας επιστρέψει τις διδακτικές μονάδες μαθημάτων δεύτερου εξαμήνου.
                $question = "SELECT Διδακτικές_Μονάδες FROM μαθήματα WHERE  Εξάμηνο ='2'";
                $result = $mysqli->query($question);
                if ($result) { //Αν υπάρχουν δεδομένα στη Β.Δ.
					if ($result->num_rows > 0) { //Όσο βρίσκονται δεδομένα στη Β.Δ.
						while ($row = $result->fetch_assoc()) {
							$ects = $row["Διδακτικές_Μονάδες"];
							?>                
							<tr style="border-bottom:1px solid;">
								<td align="center" style="color:blue;"><?= $ects ?></td>
							</tr>
							<?php
						}
					}
				}
				$result->close(); //Κλείσιμο $result για καθαρισμό μνήμης.						
				?>
				</table>
			</td>
			<td align="center">
				<table width="100%" style="border-collapse: collapse;" cellpadding="16">
				<?php 
				//Ζητάμε από τη Β.Δ. να μας επιστρέψει τον τύπο μαθημάτων δεύτερου εξαμήνου.
                $question = "SELECT Τύπος FROM μαθήματα WHERE  Εξάμηνο ='2'";
                $result = $mysqli->query($question);
                if ($result) { //Αν υπάρχουν δεδομένα στη Β.Δ.
					if ($result->num_rows > 0) { //Όσο βρίσκονται δεδομένα στη Β.Δ.
						while ($row = $result->fetch_assoc()) {
							$type = $row["Τύπος"];
							?>                
							<tr style="border-bottom:1px solid;">
								<td align="center" 
									<?php if($type == "Υποχρεωτικό"){
										echo'style="color:blue;"';
									}else if ($type == "Επιλογής"){
										echo'style="color:green;"';
									}										
										?>
										><?= $type ?></td>
							</tr>
							<?php
						}
					}
				}
				$result->close(); //Κλείσιμο $result για καθαρισμό μνήμης.						
				?>
				</table>
			</td>
			<td align="center">
				<table width="100%" style="border-collapse: collapse;" cellpadding="10">
				<?php 
				//Ζητάμε από τη Β.Δ. να μας επιστρέψει id_Μαθήματος, Τύπο μαθημάτων δευτέρου εξαμήνου.
                $question = "SELECT id_Μαθήματος, Τύπος FROM μαθήματα WHERE  Εξάμηνο ='2'";
                $result = $mysqli->query($question);
                if ($result) { //Αν υπάρχουν δεδομένα στη Β.Δ.
					if ($result->num_rows > 0) { //Όσο βρίσκονται δεδομένα στη Β.Δ.
						while ($row = $result->fetch_assoc()) {
							$sid = $row["id_Μαθήματος"];
							$stype = $row["Τύπος"];
							//Ζητάμε από τη Β.Δ. να μας επιστρέψει id_Εγγραφής, Κατάσταση, Βαθμό από τον πίνακα εγγραφών με τα αντίστοιχα κριτήρια.
							$question1 = "SELECT id_Εγγραφής, Κατάσταση, Βαθμός FROM εγγραφές WHERE  id_Χρήστη ='$userId' AND id_Μαθήματος ='$sid'";
							$result1 = $mysqli->query($question1);
							if ($result1->num_rows > 0) {
								while ($row1 = $result1->fetch_assoc()) {
									$regid = $row1["id_Εγγραφής"];
									$state = $row1["Κατάσταση"];
									$grade = $row1["Βαθμός"];
									if($state == "Εγγεγραμμένος/η"){
										$registered++;
									}
								}
								$result1->close(); //Κλείσιμο $result για καθαρισμό μνήμης.
							}else{
								$regid = null;
								$state = null;
								$grade = null;
							}
							//Φόρμα με hidden input για την εγγραφή ή κατάργηση εγγραφής μαθημάτων
							//Γίνονται οι απαραίτητοι έλεγχοι και αυξάνονται τα ανάλογα counter για χρήση σε προβολή στατιστικών στοιχείων							
							?>
								<tr style="border-bottom:1px solid;">
								<td align="center">
								<form name="registerform" action="hidden/StudentRegister.php" method="POST">
									<input hidden="" type="text" name="id_Εγγραφής" placeholder="" value="<?= $regid ?>">
									<input hidden="" type="text" name="id_Μαθήματος" placeholder="" value="<?= $sid ?>">
									<input hidden="" type="text" name="id_Χρήστη" placeholder="" value="<?= $userId ?>">
								<?php if($stdsemester >= 2 and $count<4 and ($grade == null or $grade <5)){
											if($state == "Εγγεγραμμένος/η"){
												echo'<button type="submit" name="unregister" style="width:150px; height:30px; background-color:red;">Κατάργηση Εγγραφής</button>';
											}else{
												echo'<button type="submit" name="register" style="width:150px; height:30px; background-color:green;">Εγγραφή</button>';
											}
										}else if($state == "Εγγεγραμμένος/η" and $count>=4){
											echo'<button type="submit" name="unregister" style="width:150px; height:30px; background-color:red;">Κατάργηση Εγγραφής</button>';
										}
										else if($grade >= 5){
											echo'<button style="width:150px; height:30px;background-color:#b3ffb3; color:black; border:none; font-weight: bold;" disabled>Βαθμός: '; 
											echo $grade; echo'</button>';
											$stdects += $grade ;
											if($stype == "Υποχρεωτικό"){
												$Reqpassed++; 
											}
											else if ($stype == "Επιλογής"){
												$Chopassed++;
											}
										}
										else{
											echo'<button style="width:150px; height:30px;background-color:grey;" disabled>Μη διαθέσιμο</button>';
										}	
								  ?>
								</form>
								</td>
								</tr>		
								<?php
						}
					}
				}
				$result->close(); //Κλείσιμο $result για καθαρισμό μνήμης.						
				?>
				</table>
			</td>
		</tr>
		<tr>
			<td align="center">3</td>
			<td align="center">
				<table width="100%" style="border-collapse: collapse;" cellpadding="16">
				<?php 
				//Ζητάμε από τη Β.Δ. να μας επιστρέψει Τίτλο μαθημάτων τρίτου εξαμήνου απο τον πίνακα μαθήματα.
                $question = "SELECT Τίτλος FROM μαθήματα WHERE  Εξάμηνο ='3'";
                $result = $mysqli->query($question);
                if ($result) { //Αν υπάρχουν μαθήματα στη Β.Δ.
					if ($result->num_rows > 0) { //Όσο βρίσκονται μαθήματα στη Β.Δ.
						while ($row = $result->fetch_assoc()) {
							$title = $row["Τίτλος"];
							?>                
							<tr style="border-bottom:1px solid;">
								<td align="center" style="color:blue;"><?= $title ?></td>
							</tr>
							<?php
						}
					}
				}
				$result->close(); //Κλείσιμο $result για καθαρισμό μνήμης.						
				?>
				</table>
			</td>
			<td align="center">
				<table width="100%" style="border-collapse: collapse;" cellpadding="16">
				<?php 
				//Ζητάμε από τη Β.Δ. να μας επιστρέψει id_Χρήστη απο τον πίνακα μαθήματα για το τρίτο εξάμηνο.
                $question = "SELECT id_Χρήστη FROM μαθήματα WHERE  Εξάμηνο ='3'";
                $result = $mysqli->query($question);
                if ($result) { //Αν υπάρχουν δεδομένα στη Β.Δ.
					if ($result->num_rows > 0) { //Όσο βρίσκονται δεδομένα στη Β.Δ.
						while ($row = $result->fetch_assoc()) {
							$id = $row["id_Χρήστη"];
							//Ζητάμε από τη Β.Δ. να μας επιστρέψει το όνομα και επώνυμο χρήστη από τον πίνακα χρηστών με τα αντίστοιχα κριτήρια.
							$question1 = "SELECT Όνομα, Επώνυμο FROM χρήστης WHERE  id_Χρήστη ='$id'";
							$result1 = $mysqli->query($question1);
							if ($result1->num_rows > 0) {
								while ($row1 = $result1->fetch_assoc()) {
									$fname = $row1["Όνομα"];
									$lname = $row1["Επώνυμο"];
								}
								$result1->close(); //Κλείσιμο $result για καθαρισμό μνήμης.
							}
							?>                
							<tr style="border-bottom:1px solid;">
								<td align="center" style="color:blue;"><?= $fname ?> <?= $lname ?></td>
							</tr>
							<?php
						}
					}
				}
				$result->close(); //Κλείσιμο $result για καθαρισμό μνήμης.						
				?>
				</table>
			</td>
			<td align="center">
				<table width="100%" style="border-collapse: collapse;" cellpadding="16">
				<?php 
				//Ζητάμε από τη Β.Δ. να μας διδακτικές μονάδες μαθημάτων τρίτου εξαμήνου.
                $question = "SELECT Διδακτικές_Μονάδες FROM μαθήματα WHERE  Εξάμηνο ='3'";
                $result = $mysqli->query($question);
                if ($result) { //Αν δεδομένα στη Β.Δ.
					if ($result->num_rows > 0) { //Όσο βρίσκονται δεδομένα στη Β.Δ.
						while ($row = $result->fetch_assoc()) {
							$ects = $row["Διδακτικές_Μονάδες"];
							?>                
							<tr style="border-bottom:1px solid;">
								<td align="center" style="color:blue;"><?= $ects ?></td>
							</tr>
							<?php
						}
					}
				}
				$result->close(); //Κλείσιμο $result για καθαρισμό μνήμης.						
				?>
				</table>
			</td>
			<td align="center">
				<table width="100%" style="border-collapse: collapse;" cellpadding="16">
				<?php 
				//Ζητάμε από τη Β.Δ. να μας επιστρέψει τον Τύπο μαθημάτων τρίτου εξαμήνου.
                $question = "SELECT Τύπος FROM μαθήματα WHERE  Εξάμηνο ='3'";
                $result = $mysqli->query($question);
                if ($result) { //Αν υπάρχουν δεδομένα στη Β.Δ.
					if ($result->num_rows > 0) { //Όσο βρίσκονται δεδομένα στη Β.Δ.
						while ($row = $result->fetch_assoc()) {
							$type = $row["Τύπος"];
							?>                
							<tr style="border-bottom:1px solid;">
								<td align="center" 
									<?php if($type == "Υποχρεωτικό"){
										echo'style="color:blue;"';
									}else if ($type == "Επιλογής"){
										echo'style="color:green;"';
									}										
									?>
										><?= $type ?></td>
							</tr>
							<?php
						}
					}
				}
				$result->close(); //Κλείσιμο $result για καθαρισμό μνήμης.						
				?>
				</table>
			</td>
			<td align="center">
				<table width="100%" style="border-collapse: collapse;" cellpadding="10">
				<?php 
				//Ζητάμε από τη Β.Δ. να μας επιστρέψει id_Μαθήματος, Τύπο μαθημάτων τρίτου εξαμήνου.
                $question = "SELECT id_Μαθήματος, Τύπος FROM μαθήματα WHERE  Εξάμηνο ='3'";
                $result = $mysqli->query($question);
                if ($result) { //Αν υπάρχουν δεδομένα στη Β.Δ.
					if ($result->num_rows > 0) { //Όσο βρίσκονται δεδομένα στη Β.Δ.
						while ($row = $result->fetch_assoc()) {
							$sid = $row["id_Μαθήματος"];
							$stype = $row["Τύπος"];
							//Ζητάμε από τη Β.Δ. να μας επιστρέψει το όνομα και επώνυμο χρήστη από τον πίνακα χρηστών με τα αντίστοιχα κριτήρια.
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
								$result1->close(); //Κλείσιμο $result για καθαρισμό μνήμης.
							}else{
								$regid = null;
								$state = null;
								$grade = null;
							}	
							//Φόρμα με hidden input για την εγγραφή ή κατάργηση εγγραφής μαθημάτων
							//Γίνονται οι απαραίτητοι έλεγχοι και αυξάνονται τα ανάλογα counter για χρήση σε προβολή στατιστικών στοιχείων
							?>
								<tr style="border-bottom:1px solid;">
								<td align="center">
								<form name="registerform" action="hidden/StudentRegister.php" method="POST">
									<input hidden="" type="text" name="id_Εγγραφής" placeholder="" value="<?= $regid ?>">
									<input hidden="" type="text" name="id_Μαθήματος" placeholder="" value="<?= $sid ?>">
									<input hidden="" type="text" name="id_Χρήστη" placeholder="" value="<?= $userId ?>">
								<?php if($stdsemester >= 3 and $count<4 and ($grade == null or $grade <5)){
											if($state == "Εγγεγραμμένος/η"){
												echo'<button type="submit" name="unregister" style="width:150px; height:30px; background-color:red;">Κατάργηση Εγγραφής</button>';
											}else{
												echo'<button type="submit" name="register" style="width:150px; height:30px; background-color:green;">Εγγραφή</button>';
											}
										}else if($state == "Εγγεγραμμένος/η" and $count>=4){
											echo'<button type="submit" name="unregister" style="width:150px; height:30px; background-color:red;">Κατάργηση Εγγραφής</button>';
										}
										else if($grade >= 5){
											echo'<button style="width:150px; height:30px;background-color:#b3ffb3; color:black; border:none; font-weight: bold;" disabled>Βαθμός: '; 
											echo $grade; echo'</button>';
											$stdects += $grade ;
											if($stype == "Υποχρεωτικό"){
												$Reqpassed++; 
											}
											else if ($stype == "Επιλογής"){
												$Chopassed++;
											}
										}		
										else{
											echo'<button style="width:150px; height:30px;background-color:grey;" disabled>Μη διαθέσιμο</button>';
										}	
								  ?>
								</form>
								</td>
								</tr>		
								<?php
						}
					}
				}
				$result->close(); //Κλείσιμο $result για καθαρισμό μνήμης.	
				?>
				</table>
			</td>
		</tr>	
	</table>
	<!-- Πίνακας για την προβολή στατιστικών στοιχείων -->
	<table cellpadding="10" width="100%">
	
	<tr>
		<td colspan="3" align="center"><h3><u>Στατιστικά Στοιχεία</u></h3></td>
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