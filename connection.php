<?php 
$servername = "localhost";
$database = "honeyshop";
$username = "siddik";
$password = "absiddik";

$conn = new PDO("mysql:host=$servername;dbname=$database",$username,$password);
try{
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Coonection successfully";

}catch(PDOException $ex){
    echo "Connection Failed ",$ex->getMessage();
}

?>