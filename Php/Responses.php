<?php
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Headers: *'); 
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
$_POST = json_decode(file_get_contents('php://input'), true);
require_once 'Models/Response.php';
require_once 'DatabaseOperations.php';
require_once 'Helpers.php';
require_once 'Keywords.php';
function ConvertListToResponses($data)
{
	$responses = [];
	
	foreach($data as $row)
	{
		$response = new Response(
		$row["Name"] 
		);
	
		$response->SetResponseId($row["ResponseId"]);
		$response->SetCreationTime($row["CreationTime"]);
	
		$responses[count($responses)] = $response;
	}
	
	return $responses;
}

function GetResponses($database)
{
	$data = $database->ReadData("SELECT * FROM Responses");
	$responses = ConvertListToResponses($data);
	return $responses;
}



function GetResponsesByResponseId($database, $responseId)
{
	$data = $database->ReadData("SELECT * FROM Responses WHERE ResponseId = $responseId");
	$responses = ConvertListToResponses($data);
	if(0== count($responses))
	{
		return [GetEmptyResponse()];
	}
	return $responses;
}


function AddResponse($database, $response)
{
	$query = "INSERT INTO Responses(Name, CreationTime) VALUES(";
	$query = $query . "'" . $response->GetName() . "', ";
	$query = $query . "NOW()"."";
	
	$query = $query . ");";
	$database->ExecuteSqlWithoutWarning($query);
	$id = $database->GetLastInsertedId();
	$response->SetResponseId($id);
	$response->SetCreationTime(date('Y-m-d H:i:s'));
	return $response;
	
}

function UpdateResponse($database, $response)
{
	$query = "UPDATE Responses SET ";
	$query = $query . "Name='" . $response->GetName() . "'";
	$query = $query . " WHERE ResponseId=" . $response->GetResponseId();
	
	$result = $database->ExecuteSqlWithoutWarning($query);
	if(0 == $result)
	{
		$response->SetResponseId(0);
	}
	return $response;
	
}

function TestAddResponse($database)
{
	$response = new Response(
		'Test'//Name
	);
	
	AddResponse($database, $response);
}

function GetEmptyResponse()
{
	$response = new Response(
		''//Name
	);
	
	return $response;
}

if(CheckGetParameters(["cmd"]))
{
	if("getResponses" == $_GET["cmd"])
	{
		$database = new DatabaseOperations();
		$responses = GetResponses($database);

		foreach($responses as $response)
		{
			//var_dump(GetKeywordsByResponseId($database, $response->GetResponseId()));
			echo "<br>";
			 $response->SetKeywords(GetKeywordsByResponseId($database, $response->GetResponseId()));
		}
			echo json_encode($responses);
	}

	else if("getResponsesByResponseId" == $_GET["cmd"])
	{
		if(CheckGetParameters([
			'responseId'
			]))
		{
			$database = new DatabaseOperations();
			echo json_encode(GetResponsesByResponseId($database, 
				$_GET["responseId"]
			));
		}
	
	}

	else if("addResponse" == $_GET["cmd"])
	{
		if(CheckGetParameters([
			'name'
		]))
		{
			$database = new DatabaseOperations();
			$response = new Response(
				$_GET['name']
			);
		
			echo json_encode(AddResponse($database, $response));
		}
	
	}

}

if(CheckGetParameters(["cmd"]))
{
	if("addResponse" == $_GET["cmd"])
	{
		if(CheckPostParameters([
			'name'
		]))
		{
			$database = new DatabaseOperations();
			$response = new Response(
				$_POST['name']
			);
	
			echo json_encode(AddResponse($database, $response));
		}

	}
}

if(CheckGetParameters(["cmd"]))
{
	if("updateResponse" == $_GET["cmd"])
	{
		$database = new DatabaseOperations();
		$response = new Response(
			$_POST['name']
		);
		$response->SetResponseId($_POST['responseId']);
		$response->SetCreationTime($_POST['creationTime']);
		
		$response = UpdateResponse($database, $response);
		echo json_encode($response);

	}
}

if("DELETE" == $_SERVER['REQUEST_METHOD']
	&& CheckGetParameters(["cmd"]))
{
	if("deleteResponse" == $_GET["cmd"])
	{
		$database = new DatabaseOperations();
		$responseId = $_GET['responseId'];
		
		$response = DeleteResponse($database, $responseId);
		echo json_encode($response);

	}
}


function DeleteResponse($database, $responseId)
{
	$response = GetResponsesByResponseId($database, $responseId)[0];
	
	$query = "DELETE FROM Responses WHERE ResponseId=$responseId";
	
	$result = $database->ExecuteSqlWithoutWarning($query);
	
	if(0 != $result)
	{
		$response->SetResponseId(0);
	}
	
	return $response;
	
}

?>
