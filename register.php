<?php

$DATABASE_HOST = "localhost";
$DATABASE_USER = "root";
$DATABASE_PASS  = "";
$DATABASE_NAME = "from";

$con = mysqli_connect($DATABASE_HOST, $DATABASE_NAME, $DATABASE_PASS, $DATABASE_USER);

if(mysqli_connect_error()){
    exit('Error Connecting To The Database' . mysqli_connect_error());

}
if(!isset($_POST['username'], $_POST["password"], $_POST["email"])){
    exit("Empty field(s)");
}

if (empty($_POST["username"] || empty($_POST["password"]) || empty($_POST["email"])))
{
    exit('Value Empty');
}
if ($stmt = $conn -> prepare('SELECT id, password FROM users WHERE username = ?')){
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_row>0) {
        echo 'Username Already Exists. Try Again';
    }
    else{
        if($stmt = $con->prepare('INSERT INTO users ( username, password, email ) VALUES (?, ?, ?)')){
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt-> bind_param('sss', $_POST['username'], $password, $_POST['email']);
            $stmt->execute();
            echo 'Successfully Registered';
        }
        else{ 
            echo'Error Occured';
        }
    }
    $stmt-> close();
}
else{
    echo 'Error Occured';
}
$con->close();

?>
