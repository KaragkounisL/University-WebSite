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
        <title>Καθηγητές</title>
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
		<td align="center" width="33%"><a href="./Professor.php" style="text-decoration: none;">Αρχική Σελίδα</a></td>
		<td align="center" width="33%"><a href="./ProfessorSubjects.php" style="text-decoration: none;">Μαθήματα</a></td>
		<td align="center" width="33%"><a href="./ProfessorGrades.php" style="text-decoration: none;">Βαθμολογίες</a></td>
	</table>
	</h3>
	
	<div style="height:100%; overflow: hidden;">
            <!-- Πίνακας για εμφάνιση όλων των μαθημάτων και εγγεγραμμένων φοιτητών -->
            <table width="80%" align="center" style="border-collapse: collapse; border: 1px solid black;">
				<?php
				//Ζητάμε από τη Β.Δ. να μας επιστρέψει τα καταχωρημένα στοιχεία μαθημάτων.
                $question = "SELECT id_Μαθήματος, Τίτλος FROM μαθήματα WHERE  id_Χρήστη ='$userId'";
                $result = $mysqli->query($question);
                if ($result) { //Αν υπάρχουν μαθήματα στη Β.Δ.
                    if ($result->num_rows > 0) { //Όσο βρίσκονται μαθήματα στη Β.Δ., τα εμφανίζουμε στον καθηγητή
                        while ($row = $result->fetch_assoc()) {
							echo	'<tr style="border: 1px solid black; background-color: #262626; color: white; font-size: large; text-align: center; font-weight: bolder;">
										<td colspan="4">Μάθημα</td>
									</tr>';
							$title = $row["Τίτλος"];
							$sid = $row["id_Μαθήματος"];
                            ?>                
                            <tr>
                                <td align="center" style="border: 1px solid black; font-size: large; font-weight: bolder;" colspan="4"><?= $title ?></td>
								
                            </tr>
							<tr style="border: 1px solid black; background-color: grey; color: white; font-size: medium; text-align: center;">
							<td style="background-color: grey; color:white; font-weight: bolder;">Εγγεγραμμένοι Φοιτητές</td>
							<td style="background-color: grey; color:white; font-weight: bolder;">Βαθμολογία</td>
							<td style="background-color: grey; color:white; font-weight: bolder;">Αποθήκευση<td>
							</tr>
							<?php
							//Ζητάμε από τη Β.Δ. να μας επιστρέψει το id χρηστών-φοιτητών από τον πίνακα εγγραφών με τα αντίστοιχα κριτήρια.
							$question1 = "SELECT id_Χρήστη, Βαθμός FROM εγγραφές WHERE  id_Μαθήματος ='$sid' AND Κατάσταση = 'Εγγεγραμμένος/η'";
							$result1 = $mysqli->query($question1);
							if ($result1) { //Αν υπάρχουν χρήστες-φοιτητές στη Β.Δ.
								if ($result1->num_rows > 0) { //Όσο βρίσκονται χρήστες-φοιτητές στη Β.Δ., τα εμφανίζουμε στον καθηγητή
									while ($row1 = $result1->fetch_assoc()) {
										$id = $row1["id_Χρήστη"];
										$grade = $row1["Βαθμός"];
										//Ζητάμε από τη Β.Δ. να μας επιστρέψει το όνομα και επώνυμο χρήστη-φοιτητή από τον πίνακα χρηστών με τα αντίστοιχα κριτήρια.
										$question2 = "SELECT Όνομα, Επώνυμο FROM χρήστης WHERE  id_Χρήστη ='$id'";
										$result2 = $mysqli->query($question2);
										if ($result2->num_rows > 0) {
											while ($row2 = $result2->fetch_assoc()) {
												$fname = $row2["Όνομα"];
												$lname = $row2["Επώνυμο"];
											}
											$result2->close(); //Κλείσιμο $result2 για καθαρισμό μνήμης.
										}
										//Φόρμα για απόδοση βαθμολογίας στον συγκεκριμένο φοιτητή
										?>								
										<tr style="border: 1px solid black;">
											<td align="center"><?= $fname ?> <?= $lname ?></td>
											<td style="border: 1px solid black;">
												<form name="Gradeform" action="hidden/Grade.php" method="POST">
													<input hidden="" style="width: 99%;" type="text" name="id_Χρήστη" required="" placeholder="" value="<?= $id ?>">
													<input hidden="" style="width: 99%;" type="text" name="id_Μαθήματος" required="" placeholder="" value="<?= $sid ?>">
													<select id="grade" name="Βαθμός" style="float: left; width: 100%; text-align: center;">
														<option value=""  selected><?= $grade ?></option>
														<option value="0">0</option>
														<option value="1">1</option>
														<option value="2">2</option>
														<option value="3">3</option>
														<option value="4">4</option>
														<option value="5">5</option>
														<option value="6">6</option>
														<option value="7">7</option>
														<option value="8">8</option>
														<option value="9">9</option>
														<option value="10">10</option>
													</select>
													<td><button type="submit" alt="save icon is missing" name="save" onclick="return confirm('Θέλετε όντως να αποθηκευτεί ή νέα βαθμολογία φοιτητή;');">
																<img src="images/save.png" alt="save icon" width="15" height="15"></button><td>
												</form>
											</td>
										</tr>
										
										<?php
									}
								}
								$result1->close(); //Κλείσιμο $result1 για καθαρισμό μνήμης.
							}echo'<tr><td><br></td></tr>';							
							?>
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
				