<?php
error_reporting(0);

 $servername = getenv('IP');
    $username = getenv('C9_USER');
    $password = "prince@1";
    $database = "paycheque";
    $dbport = 3306;

    // Create connection 
    $conn = new mysqli($servername, $username, $password, $database, $dbport);


$acc_from=$_POST["acc_from"];
$acc_to=$_POST["acc_to"];
$amount = $_POST["amount"];
$image=$_POST["image_f"];
$image_b = $_POST["image_b"];
$qr = "dsfadf";
$cheque_id = $_POST["cheque_id"];
$image_name= $cheque_id.'_front.jpg';

$image_name2= $cheque_id.'_back.jpg';

$stmtq = $conn->prepare('Select * from details where acc= ?');
$stmtq->bind_param('s', $acc_from);
$stmtq->execute();
$resultq = $stmtq->get_result();

if($resultq->num_rows > 0)
{
    while($row = $resultq->fetch_assoc()){
    if($row['balance']<$amount){
     echo '-2';
    }
    else{
        $stmt = $conn->prepare('Select * from details where acc= ?');
        $stmt->bind_param('s', $acc_to);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) 
             {

                $stmt1 = $conn->prepare("insert into cheque_issue values(null,?,?,?,?,?,?)");
                $stmt1->bind_param('ssssss',$acc_from,$acc_to,$image_name,$qr,$amount,$cheque_id);
 
                 if($stmt1->execute()){
                    //update account balances
                  $stmtt = $conn->prepare("update details set `balance` = `balance` + ? where acc = ?");
                  $stmtt->bind_param('ss',$amount,$acc_to);
                  $stmtt->execute();
 
                  $stmta = $conn->prepare("update details set `balance` = `balance` - ? where acc = ?");
                  $stmta->bind_param('ss',$amount,$acc_from);
                  $stmta->execute();
                  
                  //now save image
                  if($image!=''&&$image_b!=''){
                  base64_to_jpeg($image,$image_name);
                 base64_to_jpeg($image_b,$image_name2);
                 
                      
                  } echo '1';
                  
            }else{
                 echo '2';
                 }
        } else echo'0';
    }
}
    
}
else {
    echo '-1';
}

function base64_to_jpeg($base64_string, $output_file) {
    $ifp = fopen($output_file, "wb"); 

    $data = explode(',', $base64_string);

    fwrite($ifp, base64_decode($data[0])); 
    fclose($ifp); 

    return $output_file; 
    
}

?>
