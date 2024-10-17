<?php
$dbName = "admin_db";
$userName = "root";
$server = "localhost";
$password = "";
try {
    $conn = new PDO("mysql:host=$server;dbname=$dbName", $userName, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $hello ) {
    die("Connection failed: " . $e->getMessage());
}

$type=$_GET["type"]??null ;
$id =$_GET["id"]??null ;

if(!$type||!$id){
    die('Error: Missing entity type or ID.');
}

if($type=='user'){
    //check if user exists in database
    $stmt=$conn->prepare("SELECT * FROM users WHERE id =:id");
    $stmt->bindParam(":id",$id);
    $stmt->execute();
    $user=$stmt->fetch(PDO::FETCH_ASSOC);
    if(!$user){
        die('Error: User not found.');
    }else{
    //delete user from database
    $stmt = $conn->prepare("DELETE FROM `users` WHERE id = :id");
    $stmt->bindParam(":id",$id);
    if($stmt->execute()){
        header("Location: index.php");
    }else{
        echo"unable to delete user!";
    }

    }

}


?>