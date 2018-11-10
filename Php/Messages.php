<?php
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Headers: *'); 
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
$_POST = json_decode(file_get_contents('php://input'), true);
require_once 'Models/Message.php';
require_once 'DatabaseOperations.php';
require_once 'Helpers.php';
require_once 'Sessions.php';
function ConvertListToMessages($data)
{
	$messages = [];
	
	foreach($data as $row)
	{
		$message = new Message(
		$row["SessionId"], 
		$row["Value"] 
		);
	
		$message->SetMessageId($row["MessageId"]);
		$message->SetCreationTime($row["CreationTime"]);
	
		$messages[count($messages)] = $message;
	}
	
	return $messages;
}

function GetMessages($database)
{
	$data = $database->ReadData("SELECT * FROM Messages");
	$messages = ConvertListToMessages($data);
	$messages = CompleteSessions($database, $messages);
	return $messages;
}

function GetMessagesByMessageId($database, $messageId)
{
	$data = $database->ReadData("SELECT * FROM Messages WHERE MessageId = $messageId");
	$messages = ConvertListToMessages($data);
	if(0== count($messages))
	{
		return [GetEmptyMessage()];
	}
	CompleteSessions($database, $messages);
	return $messages;
}
function GetMessagesByValue($database, $value)
{
	$data = $database->ReadData("SELECT * FROM Messages WHERE Value = '$value'");
	$messages = ConvertListToMessages($data);
	if(0== count($messages))
	{
		return [GetEmptyMessage()];
	}
	CompleteSessions($database, $messages);
	return $messages;
}

function CompleteSessions($database, $messages)
{
	$sessions = GetSessions($database);
	foreach($messages as $message)
	{
		$start = 0;
		$end = count($sessions) - 1;
		do
		{
	
			$mid = floor(($start + $end) / 2);
			if($message->GetSessionId() > $sessions[$mid]->GetSessionId())
			{
				$start = $mid + 1;
			}
			else if($message->GetSessionId() < $sessions[$mid]->GetSessionId())
			{
				$end = $mid - 1;
			}
			else if($message->GetSessionId() == $sessions[$mid]->GetSessionId())
			{
				$start = $mid + 1;
				$end = $mid - 1;
				$message->SetSession($sessions[$mid]);
			}
	
		}while($start <= $end);
	}
	
	return $messages;
}

function AddMessage($database, $message)
{
	$query = "INSERT INTO Messages(SessionId, Value, CreationTime) VALUES(";
	$query = $query . $message->GetSessionId().", ";
	$query = $query . "'" . $message->GetValue() . "', ";
	$query = $query . "NOW()"."";
	
	$query = $query . ");";
	$database->ExecuteSqlWithoutWarning($query);
	$id = $database->GetLastInsertedId();
	$message->SetMessageId($id);
	$message->SetCreationTime(date('Y-m-d H:i:s'));
	$message->SetSession(GetSessionsBySessionId($database, $message->GetSessionId())[0]);
	return $message;
	
}

function UpdateMessage($database, $message)
{
	$query = "UPDATE Messages SET ";
	$query = $query . "SessionId=" . $message->GetSessionId().", ";
	$query = $query . "Value='" . $message->GetValue() . "'";
	$query = $query . " WHERE MessageId=" . $message->GetMessageId();
	
	$result = $database->ExecuteSqlWithoutWarning($query);
	if(0 == $result)
	{
		$message->SetMessageId(0);
	}
	return $message;
	
}

function TestAddMessage($database)
{
	$message = new Message(
		0,//SessionId
		'Test'//Value
	);
	
	AddMessage($database, $message);
}

function GetEmptyMessage()
{
	$message = new Message(
		0,//SessionId
		''//Value
	);
	
	return $message;
}

if(CheckGetParameters(["cmd"]))
{
	if("getMessages" == $_GET["cmd"])
	{
		$database = new DatabaseOperations();
			echo json_encode(GetMessages($database));
	}

	else if("getMessagesByMessageId" == $_GET["cmd"])
	{
		if(CheckGetParameters([
			'messageId'
			]))
		{
			$database = new DatabaseOperations();
			echo json_encode(GetMessagesByMessageId($database, 
				$_GET["messageId"]
			));
		}
	
	}
	else if("getMessagesByValue" == $_GET["cmd"])
	{
		if(CheckGetParameters([
			'value'
			]))
		{
			$database = new DatabaseOperations();
			echo json_encode(GetMessagesByValue($database, 
				$_GET["value"]
			));
		}
	
	}

	else if("addMessage" == $_GET["cmd"])
	{
		if(CheckGetParameters([
			'sessionId',
			'value'
		]))
		{
			$database = new DatabaseOperations();
			$message = new Message(
				$_GET['sessionId'],
				$_GET['value']
			);
		
			echo json_encode(AddMessage($database, $message));
		}
	
	}

}

if(CheckGetParameters(["cmd"]))
{
	if("addMessage" == $_GET["cmd"])
	{
		if(CheckPostParameters([
			'sessionId',
			'value'
		]))
		{
			$database = new DatabaseOperations();
			$message = new Message(
				$_POST['sessionId'],
				$_POST['value']
			);
	
			echo json_encode(AddMessage($database, $message));
		}

	}
}

if(CheckGetParameters(["cmd"]))
{
	if("updateMessage" == $_GET["cmd"])
	{
		$database = new DatabaseOperations();
		$message = new Message(
			$_POST['sessionId'],
			$_POST['value']
		);
		$message->SetMessageId($_POST['messageId']);
		$message->SetCreationTime($_POST['creationTime']);
		
		$message = UpdateMessage($database, $message);
		echo json_encode($message);

	}
}

if("DELETE" == $_SERVER['REQUEST_METHOD']
	&& CheckGetParameters(["cmd"]))
{
	if("deleteMessage" == $_GET["cmd"])
	{
		$database = new DatabaseOperations();
		$messageId = $_GET['messageId'];
		
		$message = DeleteMessage($database, $messageId);
		echo json_encode($message);

	}
}


function DeleteMessage($database, $messageId)
{
	$message = GetMessagesByMessageId($database, $messageId)[0];
	
	$query = "DELETE FROM Messages WHERE MessageId=$messageId";
	
	$result = $database->ExecuteSqlWithoutWarning($query);
	
	if(0 != $result)
	{
		$message->SetMessageId(0);
	}
	
	return $message;
	
}

?>
