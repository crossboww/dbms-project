<?php
//This script will handle login
session_start();

// check if the user is already logged in
if(isset($_SESSION['username']))
{
    header("location: welcome.php");
    exit;
}
require_once "dbms.php";

$username = $password = "";
$err = "";

// if request method is post
if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if(empty(trim($_POST['username'])) || empty(trim($_POST['password'])))
    {
        $err = "Please enter username + password";
    }
    else{
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
    }


if(empty($err))
{
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $param_username);
    $param_username = $username;
    
    
    // Try to execute this statement
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt))
                    {
                        if(password_verify($password, $hashed_password))
                        {
                            // this means the password is corrct. Allow user to login
                            session_start();
                            $_SESSION["username"] = $username;
                            $_SESSION["id"] = $id;
                            $_SESSION["loggedin"] = true;

                            //Redirect user to welcome page
                            header("location: welcome.php");
                            
                        }
                    }

                }

    }
}    


}


?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="login.css">
</head>
<body>
	<script>
		function data(){
		let pw=document.getElementById("password").value;
		let uid=document.getElementById("uid").value;
		
		if((pw.length==0)||(uid.length==0)){
			document.getElementById("message").innerHTML="**password/uid not entered!";
			return false;
		}
		else if((pw=="root")&&(uid=="root")){
			alert("successfuly loged in : ) ");
			return true;
		}
		else{
			document.getElementById("message").innerHTML="**wrong password/uid!";
			return false;
		}
	}
	</script>
	<div class="loginpage" >
		<form class="container" onsubmit="return data()">
			<text class="logintext">LOGIN PAGE</text>
			<input type="text" placeholder="user name" id="uid" value="">
			<input type="password"placeholder="password" id="password" value="">
				<b id="message" > </b>
			<input class="submit" type="submit" value="login" >
			
			<div class="register" >
				<a href="register.php" class="REGISTER">Register</a>
			</div>
		</form>
	</div>
</body>
</html>
