<?php


function show_menu()
{
	$conn=connect();
	$menus='';
	$menus.=generate_menus($conn);
	return $menus;
	
}

function generate_menus($conn,$parent_id=0)
{	

	$menu= '';
	$sql='';

	if($parent_id==0)
	{
		$sql = " SELECT * FROM menus WHERE parent_id=0";
	}
	else
	{
		$sql = " SELECT * FROM menus WHERE parent_id=$parent_id";
	}

	$result=$conn->query($sql);

	while($row = $result->fetch_assoc())
	{
		if($row['page'])
		{
			$menu .= '<li ><a href="'.$row['page'].'">'.$row['name'].'</a>';
		}
		else
		{
			$menu .= '<li ><a href="#">'.$row['name'].'</a>';
		}
		$menu .= '<ul class="dropdown">'.generate_menus($conn,$row['id']).'</ul>';

		$menu.='</li>';

	}
	return $menu;
}


function register()
{
	if(isset($_POST['submit']))
	{
		$username=$_POST['username'];
		$password= password_hash($_POST['password'], PASSWORD_DEFAULT);
		$email=$_POST['email'];
		
		$conn=connect();
		$query="INSERT INTO user (username,password,email) VALUES ('$username','$password','$email')";
		$result=$conn->query($query);

		if($conn->error)
		{
			echo "query error"; 
		}
		else
		{
			echo "query good";
		}

	}


}





function check()
{
	$conn=connect();
	session_start();
	if(isset($_COOKIE['cookie1']))
	{
		header("location:login.php");
	}
	
	else if(isset($_POST['login']))
	{

		$username=$_POST['username'];
		$password=$_POST['password'];

		if(strlen($username)==0 || strlen($password)==0)
		{
			
			echo "username and password can't be empty";

		}
		else
		{
			$query="SELECT * FROM user WHERE username='$username'";
			$result=$conn->query($query);

			

			while($row = $result->fetch_assoc())
			{
				
				$checkpass=$row['password'];

				if(password_verify($password,$row['password']))
				{
					echo "login successfull";
					login();
					
					
				}
				
			}
			echo "username or password incorrect";

		}
	}

}


function login()
{

	$_SESSION["user"]="sumeet";


	$user="cookie1";
	$value=$_SESSION["user"];
	$expire= time() + (60*60);
	setcookie($user,$value,$expire);

	header("location:login.php");

	die();

}



?>