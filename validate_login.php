<?php
/* $users = array('dyvavanikrishna' => 'minion123', 'chhayasharma' => 'betipushpa', 'bandatejaswari' => 'gisexpert', 'chintanmaniyar' => 'vampire123', 'admin' => 'admin' ); */
session_start();
require_once("db-connection.php");
if(isset($_POST['email']) && isset($_POST['pass']))
{
	$pass = $_POST['pass'];
	$pass=md5($pass);
	$email =$_POST['email'];
	$query="SELECT * FROM register_user WHERE user_email= :email";
    $statement=$conn->prepare($query);
	$statement->execute(array(":email"=>$email));
	$row=$statement->fetch(PDO::FETCH_ASSOC);
	if($row === false)
	{
		$_SESSION['message']="User does not exist.<br/>Register to create a new account.";
		header("Location:login.php");
		return;
	}
	else
	{
		if($pass != $row['user_password'])
		{
			$_SESSION['message']="Email and Password Combination Mismatch!";
			header("Location:login.php");
			return;
		}
		else
		{
			$_SESSION['uname']=$row['full_name'];
			header("Location:index.php");
		}
	}
}
else
{
	header("Location:login.php");
	return;
}


?>