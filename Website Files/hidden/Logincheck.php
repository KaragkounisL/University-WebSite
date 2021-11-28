<?php
echo '<meta charset="UTF-8"/>';

session_start();

$email = $_POST['email'];
$password = $_POST['password'];

$crypt = "AES_ENCRYPT('$password', UNHEX(SHA2('eap',256)))";

require 'connectDB.php';

$_SESSION['email'] = $email;

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit;
}
$mysqli->set_charset("utf8");

$question = "SELECT * FROM χρήστης WHERE Email = '$email' and Password =$crypt";
$result = mysqli_query($mysqli, $question);

	
if ($result -> num_rows == 0) {
    echo    '<script language="javascript" type="text/javascript">
            if (!alert ("Τα στοιχεία πρόσβασης είναι λανθασμένα! Προσπαθήστε ξανά.")) {
                history.go (-1);
            }
            </script>';
}
else {
    while ($row = $result -> fetch_assoc()) {
        $_SESSION['id_Χρήστη'] = $row['id_Χρήστη'];
        $_SESSION['Όνομα'] = $row['Όνομα'];
        $_SESSION['Επώνυμο'] = $row['Επώνυμο'];
        $_SESSION['Ρόλος'] = $row['Ρόλος'];
    }
	if ($_SESSION['Ρόλος'] == 'Γραμματεία'){
       header('Location: ../Admin.php');
    }
	if ($_SESSION['Ρόλος'] == 'Καθηγητής'){
       header('Location: ../Professor.php');
    }
	if ($_SESSION['Ρόλος'] == 'Φοιτητής'){
       header('Location: ../Student.php');
    }
}


$result -> close(); //Κλείσιμο $result για καθαρισμό μνήμης.
$mysqli -> close(); //Κλείσιμο σύνδεσης με ΒΔ.

?>