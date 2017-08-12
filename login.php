<?php
error_reporting(0);

 $servername = getenv('IP');
    $username = getenv('C9_USER');
    $password = "prince@1";
    $database = "paycheque";
    $dbport = 3306;

    // Create connection 
    $conn = new mysqli($servername, $username, $password, $database, $dbport);


$username=$_POST["username"];
$pass=$_POST["password"];

//select login.id,login.roll,login.name,login.type,login.image,student.class_id from login inner join student on login.roll = student.roll where login.roll = 'q' and login.password ='q';


$stmt = $conn->prepare('Select * from login where acc= ? and password =?');
$stmt->bind_param('ss', $username, $pass);

$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) 
{
    $stmt2 = $conn->prepare('Select * from details where acc= ?');
$stmt2->bind_param('s', $username);

$stmt2->execute();
$result2 = $stmt2->get_result();
while($r=$result2->fetch_assoc())
 {
  $res[] = $r;
 }


    echo json_encode($res);
}
else {
    echo '0';
}




?>