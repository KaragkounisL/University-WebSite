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
      
	</div>										  
		<div style="height:100%; overflow: hidden;">
            <!-- Πίνακας για εμφάνιση όλων των φοιτητών πρώτου εξαμήνου -->
            <table width="40%" align="center" style="border-collapse: collapse; border: 1px solid black;">
			<tr style="border: 1px solid black; color: white; font-size: medium; text-align: center;">
				<td style="background-color: grey; color:white; font-weight: bolder;">Πίνακας φοιτητών Εξάμηνου 1</td>
			</tr>
				<?php
				//Ζητάμε από τη Β.Δ. να μας επιστρέψει τα id_Χρήστη απο τον πίνακα εξάμηνο.
                $question = "SELECT id_Χρήστη FROM εξάμηνο WHERE Εξάμηνο ='1'";
                $result = $mysqli->query($question);
                if ($result) { //Αν υπάρχουν δεδομένα στη Β.Δ.
                    if ($result->num_rows > 0) { //Όσο βρίσκονται δεδομένα στη Β.Δ.
                        while ($row = $result->fetch_assoc()) {
							$sid = $row["id_Χρήστη"];
							//Ζητάμε από τη Β.Δ. να μας επιστρέψει Όνομα, Επώνυμο χρηστών από τον πίνακα χρήστη με τα αντίστοιχα κριτήρια.
							$question1 = "SELECT Όνομα, Επώνυμο FROM χρήστης WHERE Ρόλος ='Φοιτητής' AND id_Χρήστη ='$sid' ORDER BY Επώνυμο";
							$result1 = $mysqli->query($question1);
							if ($result1) { //Αν υπάρχουν χρήστες στη Β.Δ.
								if ($result1->num_rows > 0) { //Όσο βρίσκονται χρήστες στη Β.Δ., τα εμφανίζουμε στον διαχειριστή
									while ($row1 = $result1->fetch_assoc()) {
										$firstname = $row1["Όνομα"];
										$lastname = $row1["Επώνυμο"];
										}
										?>                
										<tr style="font-size: medium; text-align: center;">
											<td>
											<form name="studentstat" action="Stats.php" method="POST">
											<input hidden="" type="text" name="id_Χρήστη" placeholder="" value="<?= $sid ?>">
											<input hidden="" type="text" name="firstname" placeholder="" value="<?= $firstname ?>">
											<input hidden="" type="text" name="lastname" placeholder="" value="<?= $lastname ?>">
											<button type="submit" style="width:150px; height:30px;background-color:white;border:none; font-size:medium;"><?= $lastname ?> <?=$firstname ?></button>
											</td>
										</form>	
										</tr>
										
										<?php
									}
								}
								$result1->close(); //Κλείσιμο $result1 για καθαρισμό μνήμης.
						}							
							?>
							<?php
					}
                }
                    $result->close(); //Κλείσιμο $result για καθαρισμό μνήμης.
					
                ?>				
            </table>        
        </div>	
		<div style="height:100%; overflow: hidden;">
            <!-- Πίνακας για εμφάνιση όλων των φοιτητών δεύτερου εξαμήνου -->
            <table width="40%" align="center" style="border-collapse: collapse; border: 1px solid black;">
			<tr style="border: 1px solid black; color: white; font-size: medium; text-align: center;">
				<td style="background-color: grey; color:white; font-weight: bolder;">Πίνακας φοιτητών Εξάμηνου 2</td>
			</tr>
				<?php
				//Ζητάμε από τη Β.Δ. να μας επιστρέψει τα id_Χρήστη απο τον πίνακα εξάμηνο.
                $question = "SELECT id_Χρήστη FROM εξάμηνο WHERE Εξάμηνο ='2'";
                $result = $mysqli->query($question);
                if ($result) { //Αν υπάρχουν δεδομένα στη Β.Δ.
                    if ($result->num_rows > 0) { //Όσο βρίσκονται δεδομένα στη Β.Δ.]
                        while ($row = $result->fetch_assoc()) {
							$sid = $row["id_Χρήστη"];
							//Ζητάμε από τη Β.Δ. να μας επιστρέψει Όνομα, Επώνυμο χρηστών από τον πίνακα χρήστη με τα αντίστοιχα κριτήρια.
							$question1 = "SELECT Όνομα, Επώνυμο FROM χρήστης WHERE Ρόλος ='Φοιτητής' AND id_Χρήστη ='$sid' ORDER BY Επώνυμο";
							$result1 = $mysqli->query($question1);
							if ($result1) { //Αν υπάρχουν χρήστες στη Β.Δ.
								if ($result1->num_rows > 0) { //Όσο βρίσκονται χρήστες στη Β.Δ., τα εμφανίζουμε στον διαχειριστή
									while ($row1 = $result1->fetch_assoc()) {
										$firstname = $row1["Όνομα"];
										$lastname = $row1["Επώνυμο"];
										}
										?>                
										<tr style="font-size: medium; text-align: center;">
											<td>
											<form name="studentstat" action="Stats.php" method="POST">
											<input hidden="" type="text" name="id_Χρήστη" placeholder="" value="<?= $sid ?>">
											<input hidden="" type="text" name="firstname" placeholder="" value="<?= $firstname ?>">
											<input hidden="" type="text" name="lastname" placeholder="" value="<?= $lastname ?>">
											<button type="submit" style="width:150px; height:30px;background-color:white;border:none; font-size:medium;"><?= $lastname ?> <?=$firstname ?></button>
											</td>
										</form>	
										</tr>
										
										<?php
									}
								}
								$result1->close(); //Κλείσιμο $result1 για καθαρισμό μνήμης.
						}							
							?>
							<?php
					}
                }
                    $result->close(); //Κλείσιμο $result για καθαρισμό μνήμης.
					
                ?>				
            </table>        
        </div>	
		<div style="height:100%; overflow: hidden;">
            <!-- Πίνακας για εμφάνιση όλων των φοιτητών τρίτου εξαμήνου -->
            <table width="40%" align="center" style="border-collapse: collapse; border: 1px solid black;">
			<tr style="border: 1px solid black; color: white; font-size: medium; text-align: center;">
				<td style="background-color: grey; color:white; font-weight: bolder;">Πίνακας φοιτητών Εξάμηνου 3</td>
			</tr>
				<?php
				//Ζητάμε από τη Β.Δ. να μας επιστρέψει τα id_Χρήστη απο τον πίνακα εξάμηνο.
                $question = "SELECT id_Χρήστη FROM εξάμηνο WHERE Εξάμηνο ='3'";
                $result = $mysqli->query($question);
                if ($result) { //Αν υπάρχουν δεδομένα στη Β.Δ.
                    if ($result->num_rows > 0) { //Όσο βρίσκονται δεδομένα στη Β.Δ.
                        while ($row = $result->fetch_assoc()) {
							$sid = $row["id_Χρήστη"];
							//Ζητάμε από τη Β.Δ. να μας επιστρέψει Όνομα, Επώνυμο χρηστών από τον πίνακα χρήστη με τα αντίστοιχα κριτήρια.
							$question1 = "SELECT Όνομα, Επώνυμο FROM χρήστης WHERE Ρόλος ='Φοιτητής' AND id_Χρήστη ='$sid' ORDER BY Επώνυμο";
							$result1 = $mysqli->query($question1);
							if ($result1) { //Αν υπάρχουν χρήστες στη Β.Δ.
								if ($result1->num_rows > 0) { //Όσο βρίσκονται χρήστες στη Β.Δ., τα εμφανίζουμε στον διαχειριστή
									while ($row1 = $result1->fetch_assoc()) {
										$firstname = $row1["Όνομα"];
										$lastname = $row1["Επώνυμο"];
										}
										?>                
										<tr style="font-size: medium; text-align: center;">
											<td>
											<form name="studentstat" action="Stats.php" method="POST">
											<input hidden="" type="text" name="id_Χρήστη" placeholder="" value="<?= $sid ?>">
											<input hidden="" type="text" name="firstname" placeholder="" value="<?= $firstname ?>">
											<input hidden="" type="text" name="lastname" placeholder="" value="<?= $lastname ?>">
											<button type="submit" style="width:150px; height:30px;background-color:white;border:none; font-size:medium;"><?= $lastname ?> <?=$firstname ?></button>
											</td>
										</form>	
										</tr>
										
										<?php
									}
								}
								$result1->close(); //Κλείσιμο $result1 για καθαρισμό μνήμης.
						}							
							?>
							<?php
					}
                }
                    $result->close(); //Κλείσιμο $result για καθαρισμό μνήμης.
					
                ?>				
            </table>        
        </div>										
		


		
	<?php
        $mysqli->close();
		?> 		
	</body>


</html>