<?php
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Headers: *'); 
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
$_POST = json_decode(file_get_contents('php://input'), true);
require_once 'Models/User.php';
require_once 'DatabaseOperations.php';
require_once 'Helpers.php';
function ConvertListToUsers($data)
{
	$users = [];
	
	foreach($data as $row)
	{
		$user = new User(
		$row["Nickname"], 
		$row["Password"], 
		$row["Age"], 
		$row["Email"] 
		);
	
		$user->SetUserId($row["UserId"]);
		$user->SetCreationTime($row["CreationTime"]);
	
		$users[count($users)] = $user;
	}
	
	return $users;
}

function GetUsers($database)
{
	$data = $database->ReadData("SELECT * FROM Users");
	$users = ConvertListToUsers($data);
	return $users;
}

function GetUsersByUserId($database, $userId)
{
	$data = $database->ReadData("SELECT * FROM Users WHERE UserId = $userId");
	$users = ConvertListToUsers($data);
	if(0== count($users))
	{
		return [GetEmptyUser()];
	}
	return $users;
}


function AddUser($database, $user)
{
	$query = "INSERT INTO Users(Nickname, Password, Age, Email, CreationTime) VALUES(";
	$query = $query . "'" . $user->GetNickname() . "', ";
	$query = $query . "'" . $user->GetPassword() . "', ";
	$query = $query . $user->GetAge().", ";
	$query = $query . "'" . $user->GetEmail() . "', ";
	$query = $query . "NOW()"."";
	
	$query = $query . ");";
	$database->ExecuteSqlWithoutWarning($query);
	$id = $database->GetLastInsertedId();
	$user->SetUserId($id);
	$user->SetCreationTime(date('Y-m-d H:i:s'));
	return $user;
	
}

function UpdateUser($database, $user)
{
	$query = "UPDATE Users SET ";
	$query = $query . "Nickname='" . $user->GetNickname() . "', ";
	$query = $query . "Password='" . $user->GetPassword() . "', ";
	$query = $query . "Age=" . $user->GetAge().", ";
	$query = $query . "Email='" . $user->GetEmail() . "'";
	$query = $query . " WHERE UserId=" . $user->GetUserId();
	
	$result = $database->ExecuteSqlWithoutWarning($query);
	if(0 == $result)
	{
		$user->SetUserId(0);
	}
	return $user;
	
}

function TestAddUser($database)
{
	$user = new User(
		'Test',//Nickname
		'Test',//Password
		0,//Age
		'Test'//Email
	);
	
	AddUser($database, $user);
}

function GetEmptyUser()
{
	$user = new User(
		'',//Nickname
		'',//Password
		0,//Age
		''//Email
	);
	
	return $user;
}

if(CheckGetParameters(["cmd"]))
{
	if("getUsers" == $_GET["cmd"])
	{
		$database = new DatabaseOperations();
			echo json_encode(GetUsers($database));
	}

	else if("getUsersByUserId" == $_GET["cmd"])
	{
		if(CheckGetParameters([
			'userId'
			]))
		{
			$database = new DatabaseOperations();
			echo json_encode(GetUsersByUserId($database, 
				$_GET["userId"]
			));
		}
	
	}

	else if("addUser" == $_GET["cmd"])
	{
		if(CheckGetParameters([
			'nickname',
			'password',
			'age',
			'email'
		]))
		{
			$database = new DatabaseOperations();
			$user = new User(
				$_GET['nickname'],
				$_GET['password'],
				$_GET['age'],
				$_GET['email']
			);
		
			echo json_encode(AddUser($database, $user));
		}
	
	}

}

if(CheckGetParameters(["cmd"]))
{
	if("addUser" == $_GET["cmd"])
	{
		if(CheckPostParameters([
			'nickname',
			'password',
			'age',
			'email'
		]))
		{
			$database = new DatabaseOperations();
			$user = new User(
				$_POST['nickname'],
				$_POST['password'],
				$_POST['age'],
				$_POST['email']
			);
	
			echo json_encode(AddUser($database, $user));
		}

	}
}

if(CheckGetParameters(["cmd"]))
{
	if("updateUser" == $_GET["cmd"])
	{
		$database = new DatabaseOperations();
		$user = new User(
			$_POST['nickname'],
			$_POST['password'],
			$_POST['age'],
			$_POST['email']
		);
		$user->SetUserId($_POST['userId']);
		$user->SetCreationTime($_POST['creationTime']);
		
		$user = UpdateUser($database, $user);
		echo json_encode($user);

	}
}

if("DELETE" == $_SERVER['REQUEST_METHOD']
	&& CheckGetParameters(["cmd"]))
{
	if("deleteUser" == $_GET["cmd"])
	{
		$database = new DatabaseOperations();
		$userId = $_GET['userId'];
		
		$user = DeleteUser($database, $userId);
		echo json_encode($user);

	}
}


function DeleteUser($database, $userId)
{
	$user = GetUsersByUserId($database, $userId)[0];
	
	$query = "DELETE FROM Users WHERE UserId=$userId";
	
	$result = $database->ExecuteSqlWithoutWarning($query);
	
	if(0 != $result)
	{
		$user->SetUserId(0);
	}
	
	return $user;
	
}

?>
