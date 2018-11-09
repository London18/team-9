<?php
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Headers: *'); 
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
$_POST = json_decode(file_get_contents('php://input'), true);
require_once 'Models/Feedback.php';
require_once 'DatabaseOperations.php';
require_once 'Helpers.php';
require_once 'Sessions.php';
function ConvertListToFeedback($data)
{
	$feedback = [];
	
	foreach($data as $row)
	{
		$feedback = new Feedback(
		$row["SessionId"], 
		$row["Value"], 
		$row["Description"] 
		);
	
		$feedback->SetFeedbackId($row["FeedbackId"]);
		$feedback->SetCreationTime($row["CreationTime"]);
	
		$feedback[count($feedback)] = $feedback;
	}
	
	return $feedback;
}

function GetFeedback($database)
{
	$data = $database->ReadData("SELECT * FROM Feedback");
	$feedback = ConvertListToFeedback($data);
	$feedback = CompleteSessions($database, $feedback);
	return $feedback;
}

function GetFeedbackByFeedbackId($database, $feedbackId)
{
	$data = $database->ReadData("SELECT * FROM Feedback WHERE FeedbackId = $feedbackId");
	$feedback = ConvertListToFeedback($data);
	if(0== count($feedback))
	{
		return [GetEmptyFeedback()];
	}
	CompleteSessions($database, $feedback);
	return $feedback;
}

function CompleteSessions($database, $feedback)
{
	$sessions = GetSessions($database);
	foreach($feedback as $feedback)
	{
		$start = 0;
		$end = count($sessions) - 1;
		do
		{
	
			$mid = floor(($start + $end) / 2);
			if($feedback->GetSessionId() > $sessions[$mid]->GetSessionId())
			{
				$start = $mid + 1;
			}
			else if($feedback->GetSessionId() < $sessions[$mid]->GetSessionId())
			{
				$end = $mid - 1;
			}
			else if($feedback->GetSessionId() == $sessions[$mid]->GetSessionId())
			{
				$start = $mid + 1;
				$end = $mid - 1;
				$feedback->SetSession($sessions[$mid]);
			}
	
		}while($start <= $end);
	}
	
	return $feedback;
}

function AddFeedback($database, $feedback)
{
	$query = "INSERT INTO Feedback(SessionId, Value, Description, CreationTime) VALUES(";
	$query = $query . $feedback->GetSessionId().", ";
	$query = $query . "'" . $feedback->GetValue() . "', ";
	$query = $query . "'" . $feedback->GetDescription() . "', ";
	$query = $query . "NOW()"."";
	
	$query = $query . ");";
	$database->ExecuteSqlWithoutWarning($query);
	$id = $database->GetLastInsertedId();
	$feedback->SetFeedbackId($id);
	$feedback->SetCreationTime(date('Y-m-d H:i:s'));
	$feedback->SetSession(GetSessionsBySessionId($database, $feedback->GetSessionId())[0]);
	return $feedback;
	
}

function UpdateFeedback($database, $feedback)
{
	$query = "UPDATE Feedback SET ";
	$query = $query . "SessionId=" . $feedback->GetSessionId().", ";
	$query = $query . "Value='" . $feedback->GetValue() . "', ";
	$query = $query . "Description='" . $feedback->GetDescription() . "'";
	$query = $query . " WHERE FeedbackId=" . $feedback->GetFeedbackId();
	
	$result = $database->ExecuteSqlWithoutWarning($query);
	if(0 == $result)
	{
		$feedback->SetFeedbackId(0);
	}
	return $feedback;
	
}

function TestAddFeedback($database)
{
	$feedback = new Feedback(
		0,//SessionId
		'Test',//Value
		'Test'//Description
	);
	
	AddFeedback($database, $feedback);
}

function GetEmptyFeedback()
{
	$feedback = new Feedback(
		0,//SessionId
		'',//Value
		''//Description
	);
	
	return $feedback;
}

if(CheckGetParameters(["cmd"]))
{
	if("getFeedback" == $_GET["cmd"])
	{
		$database = new DatabaseOperations();
			echo json_encode(GetFeedback($database));
	}

	else if("getFeedbackByFeedbackId" == $_GET["cmd"])
	{
		if(CheckGetParameters([
			'feedbackId'
			]))
		{
			$database = new DatabaseOperations();
			echo json_encode(GetFeedbackByFeedbackId($database, 
				$_GET["feedbackId"]
			));
		}
	
	}

	else if("addFeedback" == $_GET["cmd"])
	{
		if(CheckGetParameters([
			'sessionId',
			'value',
			'description'
		]))
		{
			$database = new DatabaseOperations();
			$feedback = new Feedback(
				$_GET['sessionId'],
				$_GET['value'],
				$_GET['description']
			);
		
			echo json_encode(AddFeedback($database, $feedback));
		}
	
	}

}

if(CheckGetParameters(["cmd"]))
{
	if("addFeedback" == $_GET["cmd"])
	{
		if(CheckPostParameters([
			'sessionId',
			'value',
			'description'
		]))
		{
			$database = new DatabaseOperations();
			$feedback = new Feedback(
				$_POST['sessionId'],
				$_POST['value'],
				$_POST['description']
			);
	
			echo json_encode(AddFeedback($database, $feedback));
		}

	}
}

if(CheckGetParameters(["cmd"]))
{
	if("updateFeedback" == $_GET["cmd"])
	{
		$database = new DatabaseOperations();
		$feedback = new Feedback(
			$_POST['sessionId'],
			$_POST['value'],
			$_POST['description']
		);
		$feedback->SetFeedbackId($_POST['feedbackId']);
		$feedback->SetCreationTime($_POST['creationTime']);
		
		$feedback = UpdateFeedback($database, $feedback);
		echo json_encode($feedback);

	}
}

if("DELETE" == $_SERVER['REQUEST_METHOD']
	&& CheckGetParameters(["cmd"]))
{
	if("deleteFeedback" == $_GET["cmd"])
	{
		$database = new DatabaseOperations();
		$feedbackId = $_GET['feedbackId'];
		
		$feedback = DeleteFeedback($database, $feedbackId);
		echo json_encode($feedback);

	}
}


function DeleteFeedback($database, $feedbackId)
{
	$feedback = GetFeedbackByFeedbackId($database, $feedbackId)[0];
	
	$query = "DELETE FROM Feedback WHERE FeedbackId=$feedbackId";
	
	$result = $database->ExecuteSqlWithoutWarning($query);
	
	if(0 != $result)
	{
		$feedback->SetFeedbackId(0);
	}
	
	return $feedback;
	
}

?>
