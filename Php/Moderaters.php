<?php
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Headers: *'); 
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
$_POST = json_decode(file_get_contents('php://input'), true);
require_once 'Models/Moderater.php';
require_once 'DatabaseOperations.php';
require_once 'Helpers.php';
require_once 'Users.php';
function ConvertListToModeraters($data)
{
	$moderaters = [];
	
	foreach($data as $row)
	{
		$moderater = new Moderater(
		$row["UserId"], 
		$row["Role"] 
		);
	
		$moderater->SetModeraterId($row["ModeraterId"]);
		$moderater->SetCreationTime($row["CreationTime"]);
	
		$moderaters[count($moderaters)] = $moderater;
	}
	
	return $moderaters;
}

function GetModeraters($database)
{
	$data = $database->ReadData("SELECT * FROM Moderaters");
	$moderaters = ConvertListToModeraters($data);
	$moderaters = CompleteUsers($database, $moderaters);
	return $moderaters;
}

function GetModeratersByModeraterId($database, $moderaterId)
{
	$data = $database->ReadData("SELECT * FROM Moderaters WHERE ModeraterId = $moderaterId");
	$moderaters = ConvertListToModeraters($data);
	if(0== count($moderaters))
	{
		return [GetEmptyModerater()];
	}
	CompleteUsers($database, $moderaters);
	return $moderaters;
}

function CompleteUsers($database, $moderaters)
{
	$users = GetUsers($database);
	foreach($moderaters as $moderater)
	{
		$start = 0;
		$end = count($users) - 1;
		do
		{
	
			$mid = floor(($start + $end) / 2);
			if($moderater->GetUserId() > $users[$mid]->GetUserId())
			{
				$start = $mid + 1;
			}
			else if($moderater->GetUserId() < $users[$mid]->GetUserId())
			{
				$end = $mid - 1;
			}
			else if($moderater->GetUserId() == $users[$mid]->GetUserId())
			{
				$start = $mid + 1;
				$end = $mid - 1;
				$moderater->SetUser($users[$mid]);
			}
	
		}while($start <= $end);
	}
	
	return $moderaters;
}

function AddModerater($database, $moderater)
{
	$query = "INSERT INTO Moderaters(UserId, Role, CreationTime) VALUES(";
	$query = $query . $moderater->GetUserId().", ";
	$query = $query . $moderater->GetRole().", ";
	$query = $query . "NOW()"."";
	
	$query = $query . ");";
	$database->ExecuteSqlWithoutWarning($query);
	$id = $database->GetLastInsertedId();
	$moderater->SetModeraterId($id);
	$moderater->SetCreationTime(date('Y-m-d H:i:s'));
	$moderater->SetUser(GetUsersByUserId($database, $moderater->GetUserId())[0]);
	return $moderater;
	
}

function UpdateModerater($database, $moderater)
{
	$query = "UPDATE Moderaters SET ";
	$query = $query . "UserId=" . $moderater->GetUserId().", ";
	$query = $query . "Role=" . $moderater->GetRole()."";
	$query = $query . " WHERE ModeraterId=" . $moderater->GetModeraterId();
	
	$result = $database->ExecuteSqlWithoutWarning($query);
	if(0 == $result)
	{
		$moderater->SetModeraterId(0);
	}
	return $moderater;
	
}

function TestAddModerater($database)
{
	$moderater = new Moderater(
		0,//UserId
		0//Role
	);
	
	AddModerater($database, $moderater);
}

function GetEmptyModerater()
{
	$moderater = new Moderater(
		0,//UserId
		0//Role
	);
	
	return $moderater;
}

if(CheckGetParameters(["cmd"]))
{
	if("getModeraters" == $_GET["cmd"])
	{
		$database = new DatabaseOperations();
			echo json_encode(GetModeraters($database));
	}

	else if("getModeratersByModeraterId" == $_GET["cmd"])
	{
		if(CheckGetParameters([
			'moderaterId'
			]))
		{
			$database = new DatabaseOperations();
			echo json_encode(GetModeratersByModeraterId($database, 
				$_GET["moderaterId"]
			));
		}
	
	}

	else if("addModerater" == $_GET["cmd"])
	{
		if(CheckGetParameters([
			'userId',
			'role'
		]))
		{
			$database = new DatabaseOperations();
			$moderater = new Moderater(
				$_GET['userId'],
				$_GET['role']
			);
		
			echo json_encode(AddModerater($database, $moderater));
		}
	
	}

}

if(CheckGetParameters(["cmd"]))
{
	if("addModerater" == $_GET["cmd"])
	{
		if(CheckPostParameters([
			'userId',
			'role'
		]))
		{
			$database = new DatabaseOperations();
			$moderater = new Moderater(
				$_POST['userId'],
				$_POST['role']
			);
	
			echo json_encode(AddModerater($database, $moderater));
		}

	}
}

if(CheckGetParameters(["cmd"]))
{
	if("updateModerater" == $_GET["cmd"])
	{
		$database = new DatabaseOperations();
		$moderater = new Moderater(
			$_POST['userId'],
			$_POST['role']
		);
		$moderater->SetModeraterId($_POST['moderaterId']);
		$moderater->SetCreationTime($_POST['creationTime']);
		
		$moderater = UpdateModerater($database, $moderater);
		echo json_encode($moderater);

	}
}

if("DELETE" == $_SERVER['REQUEST_METHOD']
	&& CheckGetParameters(["cmd"]))
{
	if("deleteModerater" == $_GET["cmd"])
	{
		$database = new DatabaseOperations();
		$moderaterId = $_GET['moderaterId'];
		
		$moderater = DeleteModerater($database, $moderaterId);
		echo json_encode($moderater);

	}
}


function DeleteModerater($database, $moderaterId)
{
	$moderater = GetModeratersByModeraterId($database, $moderaterId)[0];
	
	$query = "DELETE FROM Moderaters WHERE ModeraterId=$moderaterId";
	
	$result = $database->ExecuteSqlWithoutWarning($query);
	
	if(0 != $result)
	{
		$moderater->SetModeraterId(0);
	}
	
	return $moderater;
	
}

?>
