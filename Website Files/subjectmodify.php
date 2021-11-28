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
            <!-- Πίνακας για εμφάνιση όλων των μαθημάτων με δυνατότητα τροποποίησης ή διαγραφής τους. -->
            <table width="100%" align="center" style="border-collapse: collapse; border: 1px solid black;">
                <tr style="border: 1px solid black; background-color: black; color: white; font-size: medium; text-align: center;">
                    <td>Τίτλος</td>
                    <td>Τύπος</td>
                    <td>Εξάμηνο</td>
                    <td>Διδακτικές Μονάδες</td>
                    <td>Διδάσκων</td>
                    <td>Περιγραφή</td>
					<td>Save</td>
					<td>Del</td>
                </tr>
                <?php
                //Ζητάμε από τη Β.Δ. να μας επιστρέψει τα καταχωρημένα στοιχεία μαθημάτων.
                $question = "SELECT id_Μαθήματος, id_Χρήστη, Τίτλος, Τύπος, Περιγραφή, Διδακτικές_Μονάδες, Εξάμηνο FROM μαθήματα ORDER BY Εξάμηνο";
                $result = $mysqli->query($question);
                if ($result) { //Αν υπάρχουν μαθήματα στη Β.Δ.
                    if ($result->num_rows > 0) { //Όσο βρίσκονται μαθήματα στη Β.Δ., τα εμφανίζουμε στον διαχειριστή
                        while ($row = $result->fetch_assoc()) {
							$idS = $row["id_Μαθήματος"];
							$title = $row["Τίτλος"];
                            $type = $row["Τύπος"];
                            $descr = $row["Περιγραφή"];
                            $ects = $row["Διδακτικές_Μονάδες"];
                            $semester = $row["Εξάμηνο"];
							$idU = $row["id_Χρήστη"];
							$q1 = "SELECT Όνομα, Επώνυμο, Email, Ρόλος FROM χρήστης WHERE id_Χρήστη = '$idU'";
							$r1 = $mysqli->query($q1);
							while ($row = mysqli_fetch_array($r1)) {
								$rol = $row["Ρόλος"];
								if($rol == "Καθηγητής"){
								$pfName = $row["Όνομα"];
								$plName = $row["Επώνυμο"];
								$pEmail = $row["Email"];
								}
							}	
                            ?>                
                             <tr style="background-color:grey;color:white">
                                <td align="center"><?= $title ?></td>
                                <td align="center"><?= $type ?></td>
                                <td align="center"><?= $semester ?></td>
                                <td align="center"><?= $ects ?></td>
                                <td align="center"><?= $pfName ?>  <?= $plName ?> &nbsp;&nbsp; Email:<?= $pEmail ?></td>
                                <td align="center"><?= $descr ?></td>
								<td></td>
								<td></td>
                            </tr>
							<tr style="border-bottom: 1pt solid black;">
                                <!--Φόρμα τροποποίησης/διαγραφής υπάρχοντων μαθημάτων--> 
                            <form name="UpdateDeleteform" action="hidden/UpdateDeleteSubject.php" method="POST" onsubmit="return validateRegister();">
                                <input hidden="" style="width: 99%; text-align: center;" type="text" name="id_Μαθήματος" required="" placeholder="" value="<?= $idS ?>">                                
                                <td><input style="width: 99%; text-align: center;" type="text" name="Τίτλος" required="" placeholder="" value="<?= $title ?>"></td>
								<td  style="padding:5px "><select name="Τύπος" required style="float: left; width: 103%; text-align: center;">
									<option value="<?= $type ?>" selected><?= $type ?></option>
									<option value="Υποχρεωτικό">Υποχρεωτικό</option>
									<option value="Επιλογής">Επιλογής</option>
									</select>
								</td>
								<td  style="padding:5px "><select name="Εξάμηνο" required style="float: left; width: 103%; text-align: center;">
									<option value="<?= $semester ?>" selected><?= $semester ?></option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									</select>
								</td>
								<td><input style="width: 99%; text-align: center;" type="number" name="Διδακτικές_Μονάδες" placeholder="" value="<?= $ects ?>"></td>
                                <td><input style="width: 30%; text-align: center;" type="text" name="Όνομα" required="" placeholder="" value="<?= $pfName ?>">
									<input style="width: 30%; text-align: center;" type="text" name="Επώνυμο" required="" placeholder="" value="<?= $plName ?>">
									<input style="width: 35%; text-align: center;" type="email" name="Email" required="" placeholder="" value="<?= $pEmail ?>"></td>        
								<td><input style="width: 99%;" type="text" name="Περιγραφή" maxlength="20" placeholder="" value="<?= $descr ?>"></td>
                                <td align="center"><button type="submit" alt="save icon is missing" name="save" onclick="return confirm('Θέλετε όντως να αποθηκευτούν τα νέα δεδομένα μαθήματος;');"><img src="images/save.png" alt="save icon" width="15" height="15"></button></td>
                                <td align="center"><button type="submit" alt="delete icon is missing" name="delete" onclick="return confirm('Προσοχή! Θέλετε όντως να διαγραφεί το μάθημα;');"><img src="images/delete.png" alt="delete icon" width="15" height="15"></button></td>               
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