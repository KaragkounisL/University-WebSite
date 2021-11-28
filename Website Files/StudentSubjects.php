<?php
session_start();

require "hidden/connectDB.php";

$fName = $_SESSION['Όνομα'];
$lName = $_SESSION['Επώνυμο'];
$userId = $_SESSION['id_Χρήστη'];

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
	
	<div style="height:100%; overflow: hidden;">
            <!-- Πίνακας για εμφάνιση όλων των εγγεγραμμένων μαθημάτων φοιτητή -->
            <table width="40%" align="center" style="border-collapse: collapse; border: 1px solid black;">
			<tr style="border: 1px solid black; color: white; font-size: medium; text-align: center;">
				<td style="background-color: grey; color:white; font-weight: bolder;">Εγγεγραμμένα Μαθήματα</td>
			</tr>
				<?php
				//Ζητάμε από τη Β.Δ. να μας επιστρέψει id_Μαθήματος από τον πίνακα εγγραφών.
                $question = "SELECT id_Μαθήματος FROM εγγραφές WHERE  id_Χρήστη ='$userId' AND Κατάσταση = 'Εγγεγραμμένος/η'";
                $result = $mysqli->query($question);
                if ($result) { //Αν υπάρχουν εγγραφές στη Β.Δ.
                    if ($result->num_rows > 0) { //Όσο βρίσκονται εγγραφές στη Β.Δ.
                        while ($row = $result->fetch_assoc()) {
							$sid = $row["id_Μαθήματος"];
							//Ζητάμε από τη Β.Δ. να μας επιστρέψει τον τίτλο μαθήματος με το αντίστοιχο id_Μαθήματος
							$question1 = "SELECT Τίτλος FROM μαθήματα WHERE  id_Μαθήματος ='$sid'";
							$result1 = $mysqli->query($question1);
							if ($result1) { //Αν υπάρχουν μαθήματα στη Β.Δ.
								if ($result1->num_rows > 0) { //Όσο βρίσκονται μαθήματα στη Β.Δ., τα εμφανίζουμε στον φοιτητή
									while ($row1 = $result1->fetch_assoc()) {
										$title = $row1["Τίτλος"];
										}
										?>                
										<tr style="font-size: medium; text-align: center;">
											<td><?= $title ?></td>
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
            <!-- Πίνακας για εμφάνιση όλων των βαθμολογιών εγγεγραμμένων μαθημάτων φοιτητή -->
            <table width="40%" align="center" style="border-collapse: collapse; border: 1px solid black;">
			<tr style="border: 1px solid black; color: white; font-size: medium; text-align: center;">
				<td style="background-color: grey; color:white; font-weight: bolder;">Ολοκληρωμένα Μαθήματα</td>
			</tr>
				<?php
				//Ζητάμε από τη Β.Δ. να μας επιστρέψει id_Μαθήματος και Βαθμό από τον πίνακα εγγραφών με τα αντίστοιχα κριτήρια.
                $question = "SELECT id_Μαθήματος, Βαθμός FROM εγγραφές WHERE  id_Χρήστη ='$userId' AND Βαθμός >= '5'";
                $result = $mysqli->query($question);
                if ($result) { //Αν υπάρχουν εγγραφές στη Β.Δ.
                    if ($result->num_rows > 0) { //Όσο βρίσκονται εγγραφές στη Β.Δ.
                        while ($row = $result->fetch_assoc()) {
							$sid = $row["id_Μαθήματος"];
							$grade = $row["Βαθμός"];
							//Ζητάμε από τη Β.Δ. να μας επιστρέψει τον τίτλο μαθήματος με το αντίστοιχο id_Μαθήματος
							$question1 = "SELECT Τίτλος FROM μαθήματα WHERE  id_Μαθήματος ='$sid'";
							$result1 = $mysqli->query($question1);
							if ($result1) { //Αν υπάρχουν μαθήματα στη Β.Δ.
								if ($result1->num_rows > 0) { //Όσο βρίσκονται μαθήματα στη Β.Δ., τα εμφανίζουμε στον φοιτητή
									while ($row1 = $result1->fetch_assoc()) {
										$title = $row1["Τίτλος"];
										}
										?>                
										<tr style="font-size: medium; text-align: center;">
											<td><?= $title ?>&nbsp;&nbsp;&nbsp; Βαθμός: <?=$grade ?></td>
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
				