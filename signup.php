<?php
//error_reporting(0);

 $servername = getenv('IP');
    $username = getenv('C9_USER');
    $password = "prince@1";
    $database = "paycheque";
    $dbport = 3306;

    // Create connection 
    $conn = new mysqli($servername, $username, $password, $database, $dbport);


$name=$_POST["name"];
$acc=$_POST["acc"];
$email=$_POST["email"];
$bal=$_POST["bal"];
$phone=$_POST["phone"];
$password=$_POST["password"];


$stmt3 = $conn->prepare('Select * from login where acc= ?');
$stmt3->bind_param('s', $acc);

$stmt3->execute();
$result = $stmt3->get_result();
if ($result->num_rows == 0) 
{
$stmt = $conn->prepare('INSERT INTO `details`(`acc`, `name`,  `email`, `balance`, `phone`) VALUES (?,?,?,?,?)');
$stmt->bind_param('sssss', $acc,$name,$email,$bal,$phone);

$stmt->execute();

$stmt1 = $conn->prepare('INSERT INTO `login`(`acc`, `password`) VALUES (?,?)');
$stmt1->bind_param('ss', $acc,$password);

$stmt1->execute();
 


echo '1';
}

else {
    echo '0';
}




?>