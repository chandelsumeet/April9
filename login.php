<?php
if(isset($_COOKIE['cookie1']))
{

	if(!isset($_SESSION['user']))
	{
		$_SESSION['user']=$_COOKIE['cookie1'];
	}

echo "logged in successfully";

}
else
{
	header("location:index.php");
}


?>