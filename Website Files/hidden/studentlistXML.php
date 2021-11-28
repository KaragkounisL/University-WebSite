<?php
session_start();
require 'connectDB.php';
$userId = $_SESSION['id_Χρήστη'];
$sem = $_POST['Εξάμηνο'];
$studentsArray = array();
$errors = array(); 
$createdXMLFile=false;
$found_errors = 0;

// Δομή που θα φιλοξενήσει μαθητές
        class Student {
            public $name;
            public $surname;
            public $semester;
            public $passed_subjects;
            public $average;
        }
        	
		
		$question = "SELECT id_Χρήστη FROM εξάμηνο WHERE Εξάμηνο ='$sem'";
                $result = $mysqli->query($question);
                if ($result) { //Αν υπάρχουν δεδομένα στη Β.Δ.
                    if ($result->num_rows > 0) { //Όσο βρίσκονται δεδομένα στη Β.Δ.
						$sum = 0;
						$count =0;
                        while ($row = $result->fetch_assoc()) {
							$sid = $row["id_Χρήστη"];
							//Ζητάμε από τη Β.Δ. να μας επιστρέψει Όνομα, Επώνυμο χρηστών από τον πίνακα χρήστη με τα αντίστοιχα κριτήρια.
							$question1 = "SELECT Όνομα, Επώνυμο FROM χρήστης WHERE Ρόλος ='Φοιτητής' AND id_Χρήστη ='$sid' ORDER BY Επώνυμο";
							$result1 = $mysqli->query($question1);
							if ($result1) { //Αν υπάρχουν χρήστες στη Β.Δ. :
								if ($result1->num_rows > 0) { //Όσο βρίσκονται χρήστες στη Β.Δ....
									while ($row1 = $result1->fetch_assoc()) {
										$firstname = $row1["Όνομα"];
										$lastname = $row1["Επώνυμο"];
										//Ζητάμε από τη Β.Δ. να μας επιστρέψει τα καταχωρημένα στοιχεία μαθημάτων πρώτου εξαμήνου.
										$question2 = "SELECT id_Μαθήματος, Τύπος FROM μαθήματα WHERE  Εξάμηνο ='1'";
										$result2 = $mysqli->query($question2);
										if ($result2) { //Αν υπάρχουν μαθήματα στη Β.Δ. :
											if ($result2->num_rows > 0) { //Όσο βρίσκονται δεδομένα στη Β.Δ....
												while ($row2 = $result2->fetch_assoc()) {
													$subid = $row2["id_Μαθήματος"];
													$stype = $row2["Τύπος"];
													//Ζητάμε από τη Β.Δ. να μας επιστρέψει Βαθμό από τον πίνακα εγγραφών με τα αντίστοιχα κριτήρια.
													$question3 = "SELECT Βαθμός FROM εγγραφές WHERE  id_Χρήστη ='$sid' AND id_Μαθήματος ='$subid'";
													$result3 = $mysqli->query($question3);
													if ($result3->num_rows > 0) {
														while ($row3 = $result3->fetch_assoc()) {
															$grade = $row3["Βαθμός"];
														}
														$result3->close(); //Κλείσιμο $result3 για καθαρισμό μνήμης.
													}else{
													$grade = null;
													}	
													if($grade >= 5){
													//Counter για καταμέτρηση διδακτικών μονάδων
													$sum += $grade;
													$count +=1;
													}	
												}
												$result2->close(); //Κλείσιμο $result2 για καθαρισμό μνήμης.
											}
										}
									}
									$result1->close();//Κλείσιμο $result1 για καθαρισμό μνήμης.	
								}
							}
							$anElement = new Student();
							$anElement->name = $firstname;
							$anElement->surname = $lastname;
							$anElement->semester = $sem;
							$anElement->passed_subjects = $count;
							if($count>0){
								$anElement->average = $sum/$count;
							}else{
								$anElement->average = 0;
							}
							array_push($studentsArray,$anElement);
						}
						$result->close();
					}
				}else{
					array_push($errors,'Δεν βρέθηκαν μαθητές για το εξάμηνο φοίτησης.');
					$found_errors++;
				}
				 

        /* Δημιουργία νέας οντότητας της κλάσης DomImplementation. Δηλώνουμε ότι θα υπάρχει ένα εξωτερικό dtd
            αρχείο με το όνομα 'students.dtd', το οποίο θα χρησιμοποιείται για τον έλεγχο εγκυρότητας του 
            εκάστοτε παραγόμενου xml. Το κάθε xml που δημιουργείται, θα έχει ως αναφορά το dtd που δηλώσαμε κι
            επιπλέον, θα έχει κωδικοποίηση UTF-8 (για να είμαστε σίγουροι για την υποστήριξη των Ελληνικών χαρακτήρων)
            κι ενεργοποιούμε την xml μορφοποίηση, ώστε να απεικονίζεται με τη γνώριμη μορφή.
        */
        if($found_errors==0){
            $imp = new DOMImplementation;
            $dtd = $imp->createDocumentType('students','','students.dtd');
            $xml_filename = "../files/students".$userId.".xml";
            $xml = $imp->createDocument("","",$dtd);
            $xml->encoding = 'UTF-8';
            $xml->formatOutput = true;
            
            // Δημιουργούμε το στοιχείο - ρίζα και το προσθέτουμε στο xml.
            $students = $xml->createElement("students");
            $xml->appendChild($students);
            
            // Προσθέτουμε έναν - έναν τους φοιτητές στο xml.
            foreach ($studentsArray as $element){
                $student = $xml->createElement("student");
                $students->appendChild($student);                
                $student->appendChild($xml->createElement("name",$element->name));
                $student->appendChild($xml->createElement("surname",$element->surname));
                $student->appendChild($xml->createElement("semester",$element->semester));
                $student->appendChild($xml->createElement("passed_subjects",$element->passed_subjects));
                $student->appendChild($xml->createElement("average",$element->average));
            }

            
            // Ολοκλήρωση της δημιουργίας του xml αρχείου κι αποθήκευση στον κατάλογο 'files' με το όνομα 'students<USERID>.xml'
            $xml->saveXML();
            $xml->save($xml_filename);
            // To αρχείο XML δημιουργήθηκε
            $createdXMLFile = true;        
        } else {
            // To αρχείο XML ΔΕΝ δημιουργήθηκε
            $createdXMLFile = false;        
        }
		
		// Ελεγχος αν δημιουργήθηκε το xml αρχείο μετά το post της φορμας
		if($createdXMLFile){
			// Φόρτωση του xml
			$xml = new DOMDocument();
			$xml->load("../files/students".$userId.".xml");

			// Φόρτωση του xsl
			$xsl = new DOMDocument();
        	$xsl->load("../files/students.xsl");

			// H validate γεννάει σε περίπτωση αποτυχίας warnings τα οποία δεν έχει νόημα να βλέπει ο χρήστης σε production
			// περιβάλλον (ακόμη και αν αυτός ειναι ο administrator)
			error_reporting(E_ERROR | E_PARSE);
			//Μήνυμα σε περίπτωση που το αρχείο δεν είναι έγκυρο σύμφωνα με DTD
			if (!$xml->validate()) {				
				echo "<p>Το XML αρχείο δεν είναι έγκυρο σύμφωνα με το DTD. Παρακαλώ επικοινωνήστε με την τεχνική υποστήριξη.</p>";				
			} else {	
				// Επεξεργασία κι εξαγωγή αποτελεσμάτων
				$proc = new XSLTProcessor();
				$proc->importStyleSheet($xsl);
				echo $proc->transformToXML($xml);				
			}
			// Η παρακάτω εντολή κρύβει τα warnings
			error_reporting(0);
		}	

$mysqli->close(); //Κλείσιμο σύνδεσης με ΒΔ.
?>