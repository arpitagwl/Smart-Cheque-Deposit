<?php
error_reporting(0);

 $servername = getenv('IP');
    $username = getenv('C9_USER');
    $password = "prince@1";
    $database = "paycheque";
    $dbport = 3306;

    // Create connection 
    $conn = new mysqli($servername, $username, $password, $database, $dbport);


$username=$_POST["acc"];

//select login.id,login.roll,login.name,login.type,login.image,student.class_id from login inner join student on login.roll = student.roll where login.roll = 'q' and login.password ='q';

$stmt = $conn->prepare('SELECT balance FROM details where acc=?');
$stmt->bind_param('s', $username);

$stmt->execute();
$result = $stmt->get_result();
while($r1=$result->fetch_assoc())
 {
  $balance = $r1['balance'];
 }
 
$stmt2 = $conn->prepare('SELECT cheque_issue.acc_from,cheque_issue.amount,details.name as name_from FROM `cheque_issue` inner join details on cheque_issue.acc_from = details.acc WHERE cheque_issue.acc_to = ? limit 0,10');
$stmt2->bind_param('s', $username);

$stmt2->execute();
$result2 = $stmt2->get_result();
while($r=$result2->fetch_assoc())
 {
  $res[] = $r;
 }

    echo $balance.'``%f%``';
    echo json_encode($res);




?>