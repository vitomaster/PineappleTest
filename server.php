<?php

// main server script. This script preforiming validation creating and submiting data base
$servername = 'localhost';
$username = "root";
$password = "root";
$inputData = $_POST['msg'];
$checkBox = $_POST['checkbox'];
$currentTime = date('Y-m-d H:i:s');
$split = explode('@',$inputData);

$mailName = $split[0];
$mailDomain = $split[1];


if (empty($inputData)){
    header('Location: index.html');
} if(!$checkBox){
    header('Location: index.html');
} if(filter_var($inputData,FILTER_VALIDATE_EMAIL) === false){
    header('Location: index.html');
  return false;
} if (strpos($inputData,'.co') && strpos($inputData,'.com') === false){
    header('Location: index.html');
  return false;
}
else {
    createDB($servername,$username,$password,$mailName,$mailDomain,$inputData,$currentTime);
}

function CreateDB($servername,$username,$password,$mailName,$mailDomain,$inptuData,$currentTime)
{
    $connection = new mysqli($servername,$username,$password);

    if ($connection->connection_error){
        die("connection failed: ".$connection->connection_error);
    } else {
            "connection established"."<br>";
    }
    
    $newDB = "CREATE DATABASE mails"; //Создаёт новую ДБ
    if ($connection->query($newDB) === TRUE) {
        "Database created successfully";
      } else {
        "Error creating database: ".$connection->error."<br>";
      }
    mysqli_select_db($connection,"mails");

    $newTB = "CREATE TABLE subs(
        mailName VARCHAR(70) NOT NULL PRIMARY KEY,
        mailDomain VARCHAR(30) NOT NULL,
        fullMail VARCHAR(100) NOT NULL,
        currentTime VARCHAR(50) NOT NULL
    )";

      if ($connection->query($newTB) === TRUE) {
        "Database created successfully";
      } else {
        "Error creating database: ".$connection->error."<br>";
      }
    $newMail = "INSERT INTO subs(mailName,mailDomain,fullMail,currentTime)
                VALUES ('$mailName','$mailDomain','$inptuData','$currentTime')";

    if ($connection->query($newMail) === TRUE) {
        header('Location: result.html');
    } else {
        header('Location: index.html');
       "Error: " . $newMail . "<br>" . $connection->error;
    }
    $connection->close();
}
?>