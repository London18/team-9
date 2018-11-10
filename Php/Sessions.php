<?php
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Headers: *'); 
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
$_POST = json_decode(file_get_contents('php://input'), true);
require_once 'Models/Session.php';
require_once 'DatabaseOperations.php';
require_once 'Helpers.php';
require_once 'Users.php';
function ConvertListToSessions($data)
{
	$sessions = [];
	
	foreach($data as $row)
	{
		$session = new Session(
		$row["UserId"] 
		);
	
		$session->SetSessionId($row["SessionId"]);
		$session->SetCreationTime($row["CreationTime"]);
	
		$sessions[count($sessions)] = $session;
	}
	
	return $sessions;
}

function GetSessions($database)
{
	$data = $database->ReadData("SELECT * FROM Sessions");
	$sessions = ConvertListToSessions($data);
	$sessions = CompleteUsers($database, $sessions);
	return $sessions;
}

function GetSessionsBySessionId($database, $sessionId)
{
	$data = $database->ReadData("SELECT * FROM Sessions WHERE SessionId = $sessionId");
	$sessions = ConvertListToSessions($data);
	if(0== count($sessions))
	{
		return [GetEmptySession()];
	}
	CompleteUsers($database, $sessions);
	return $sessions;
}

function CompleteUsers($database, $sessions)
{
	$users = GetUsers($database);
	foreach($sessions as $session)
	{
		$start = 0;
		$end = count($users) - 1;
		do
		{
	
			$mid = floor(($start + $end) / 2);
			if($session->GetUserId() > $users[$mid]->GetUserId())
			{
				$start = $mid + 1;
			}
			else if($session->GetUserId() < $users[$mid]->GetUserId())
			{
				$end = $mid - 1;
			}
			else if($session->GetUserId() == $users[$mid]->GetUserId())
			{
				$start = $mid + 1;
				$end = $mid - 1;
				$session->SetUser($users[$mid]);
			}
	
		}while($start <= $end);
	}
	
	return $sessions;
}

function AddSession($database, $session)
{
	$query = "INSERT INTO Sessions(UserId, CreationTime) VALUES(";
	$query = $query . $session->GetUserId().", ";
	$query = $query . "NOW()"."";
	
	$query = $query . ");";
	$database->ExecuteSqlWithoutWarning($query);
	$id = $database->GetLastInsertedId();
	$session->SetSessionId($id);
	$session->SetCreationTime(date('Y-m-d H:i:s'));
	$session->SetUser(GetUsersByUserId($database, $session->GetUserId())[0]);
	return $session;
	
}

function UpdateSession($database, $session)
{
	$query = "UPDATE Sessions SET ";
	$query = $query . "UserId=" . $session->GetUserId()."";
	$query = $query . " WHERE SessionId=" . $session->GetSessionId();
	
	$result = $database->ExecuteSqlWithoutWarning($query);
	if(0 == $result)
	{
		$session->SetSessionId(0);
	}
	return $session;
	
}

function TestAddSession($database)
{
	$session = new Session(
		0//UserId
	);
	
	AddSession($database, $session);
}

function GetEmptySession()
{
	$session = new Session(
		0//UserId
	);
	
	return $session;
}

if(CheckGetParameters(["cmd"]))
{
	if("getSessions" == $_GET["cmd"])
	{
		$database = new DatabaseOperations();
			echo json_encode(GetSessions($database));
	}

	else if("getSessionsBySessionId" == $_GET["cmd"])
	{
		if(CheckGetParameters([
			'sessionId'
			]))
		{
			$database = new DatabaseOperations();
			echo json_encode(GetSessionsBySessionId($database, 
				$_GET["sessionId"]
			));
		}
	
	}

	else if("addSession" == $_GET["cmd"])
	{
		if(CheckGetParameters([
			'userId'
		]))
		{
			$database = new DatabaseOperations();
			$session = new Session(
				$_GET['userId']
			);
		
			echo json_encode(AddSession($database, $session));
		}
	
	}

}

if(CheckGetParameters(["cmd"]))
{
	if("addSession" == $_GET["cmd"])
	{
		if(CheckPostParameters([
			'userId'
		]))
		{
			$database = new DatabaseOperations();
			$session = new Session(
				$_POST['userId']
			);
	
			echo json_encode(AddSession($database, $session));
		}

	}
}

if(CheckGetParameters(["cmd"]))
{
	if("updateSession" == $_GET["cmd"])
	{
		$database = new DatabaseOperations();
		$session = new Session(
			$_POST['userId']
		);
		$session->SetSessionId($_POST['sessionId']);
		$session->SetCreationTime($_POST['creationTime']);
		
		$session = UpdateSession($database, $session);
		echo json_encode($session);

	}
}

if("DELETE" == $_SERVER['REQUEST_METHOD']
	&& CheckGetParameters(["cmd"]))
{
	if("deleteSession" == $_GET["cmd"])
	{
		$database = new DatabaseOperations();
		$sessionId = $_GET['sessionId'];
		
		$session = DeleteSession($database, $sessionId);
		echo json_encode($session);

	}
}


function DeleteSession($database, $sessionId)
{
	$session = GetSessionsBySessionId($database, $sessionId)[0];
	
	$query = "DELETE FROM Sessions WHERE SessionId=$sessionId";
	
	$result = $database->ExecuteSqlWithoutWarning($query);
	
	if(0 != $result)
	{
		$session->SetSessionId(0);
	}
	
	return $session;
	
}

?>
