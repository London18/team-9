<?php
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Headers: *'); 
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
$_POST = json_decode(file_get_contents('php://input'), true);
require_once 'Models/Keyword.php';
require_once 'DatabaseOperations.php';
require_once 'Helpers.php';
require_once 'Responses.php';
function ConvertListToKeywords($data)
{
	$keywords = [];
	
	foreach($data as $row)
	{
		$keyword = new Keyword(
		$row["ResponseId"], 
		$row["Word"] 
		);
	
		$keyword->SetKeywordId($row["KeywordId"]);
		$keyword->SetCreationTime($row["CreationTime"]);
	
		$keywords[count($keywords)] = $keyword;
	}
	
	return $keywords;
}

function GetKeywords($database)
{
	$data = $database->ReadData("SELECT * FROM Keywords");
	$keywords = ConvertListToKeywords($data);
	return $keywords;
}

function GetKeywordsByKeywordId($database, $keywordId)
{
	$data = $database->ReadData("SELECT * FROM Keywords WHERE KeywordId = $keywordId");
	$keywords = ConvertListToKeywords($data);
	if(0== count($keywords))
	{
		return [GetEmptyKeyword()];
	}
	return $keywords;
}
function GetKeywordsByResponseId($database, $responseId)
{
	$data = $database->ReadData("SELECT * FROM Keywords WHERE ResponseId = $responseId");
	$keywords = ConvertListToKeywords($data);
	if(0== count($keywords))
	{
		return [GetEmptyKeyword()];
	}
	return $keywords;
}

function CompleteResponses($database, $keywords)
{
	$responses = GetResponses($database);
	foreach($keywords as $keyword)
	{
		$start = 0;
		$end = count($responses) - 1;
		do
		{
	
			$mid = floor(($start + $end) / 2);
			if($keyword->GetResponseId() > $responses[$mid]->GetResponseId())
			{
				$start = $mid + 1;
			}
			else if($keyword->GetResponseId() < $responses[$mid]->GetResponseId())
			{
				$end = $mid - 1;
			}
			else if($keyword->GetResponseId() == $responses[$mid]->GetResponseId())
			{
				$start = $mid + 1;
				$end = $mid - 1;
				$keyword->SetResponse($responses[$mid]);
			}
	
		}while($start <= $end);
	}
	
	return $keywords;
}

function AddKeyword($database, $keyword)
{
	$query = "INSERT INTO Keywords(ResponseId, Word, CreationTime) VALUES(";
	$query = $query . $keyword->GetResponseId().", ";
	$query = $query . "'" . $keyword->GetWord() . "', ";
	$query = $query . "NOW()"."";
	
	$query = $query . ");";
	$database->ExecuteSqlWithoutWarning($query);
	$id = $database->GetLastInsertedId();
	$keyword->SetKeywordId($id);
	$keyword->SetCreationTime(date('Y-m-d H:i:s'));
	$keyword->SetResponse(GetResponsesByResponseId($database, $keyword->GetResponseId())[0]);
	return $keyword;
	
}

function UpdateKeyword($database, $keyword)
{
	$query = "UPDATE Keywords SET ";
	$query = $query . "ResponseId=" . $keyword->GetResponseId().", ";
	$query = $query . "Word='" . $keyword->GetWord() . "'";
	$query = $query . " WHERE KeywordId=" . $keyword->GetKeywordId();
	
	$result = $database->ExecuteSqlWithoutWarning($query);
	if(0 == $result)
	{
		$keyword->SetKeywordId(0);
	}
	return $keyword;
	
}

function TestAddKeyword($database)
{
	$keyword = new Keyword(
		0,//ResponseId
		'Test'//Word
	);
	
	AddKeyword($database, $keyword);
}

function GetEmptyKeyword()
{
	$keyword = new Keyword(
		0,//ResponseId
		''//Word
	);
	
	return $keyword;
}

if(CheckGetParameters(["cmd"]))
{
	if("getKeywords" == $_GET["cmd"])
	{
		$database = new DatabaseOperations();
			echo json_encode(GetKeywords($database));
	}

	else if("getKeywordsByKeywordId" == $_GET["cmd"])
	{
		if(CheckGetParameters([
			'keywordId'
			]))
		{
			$database = new DatabaseOperations();
			echo json_encode(GetKeywordsByKeywordId($database, 
				$_GET["keywordId"]
			));
		}
	
	}
	else if("getKeywordsByResponseId" == $_GET["cmd"])
	{
		if(CheckGetParameters([
			'responseId'
			]))
		{
			$database = new DatabaseOperations();
			echo json_encode(GetKeywordsByResponseId($database, 
				$_GET["responseId"]
			));
		}
	
	}

	else if("addKeyword" == $_GET["cmd"])
	{
		if(CheckGetParameters([
			'responseId',
			'word'
		]))
		{
			$database = new DatabaseOperations();
			$keyword = new Keyword(
				$_GET['responseId'],
				$_GET['word']
			);
		
			echo json_encode(AddKeyword($database, $keyword));
		}
	
	}

}

if(CheckGetParameters(["cmd"]))
{
	if("addKeyword" == $_GET["cmd"])
	{
		if(CheckPostParameters([
			'responseId',
			'word'
		]))
		{
			$database = new DatabaseOperations();
			$keyword = new Keyword(
				$_POST['responseId'],
				$_POST['word']
			);
	
			echo json_encode(AddKeyword($database, $keyword));
		}

	}
}

if(CheckGetParameters(["cmd"]))
{
	if("updateKeyword" == $_GET["cmd"])
	{
		$database = new DatabaseOperations();
		$keyword = new Keyword(
			$_POST['responseId'],
			$_POST['word']
		);
		$keyword->SetKeywordId($_POST['keywordId']);
		$keyword->SetCreationTime($_POST['creationTime']);
		
		$keyword = UpdateKeyword($database, $keyword);
		echo json_encode($keyword);

	}
}

if("DELETE" == $_SERVER['REQUEST_METHOD']
	&& CheckGetParameters(["cmd"]))
{
	if("deleteKeyword" == $_GET["cmd"])
	{
		$database = new DatabaseOperations();
		$keywordId = $_GET['keywordId'];
		
		$keyword = DeleteKeyword($database, $keywordId);
		echo json_encode($keyword);

	}
}


function DeleteKeyword($database, $keywordId)
{
	$keyword = GetKeywordsByKeywordId($database, $keywordId)[0];
	
	$query = "DELETE FROM Keywords WHERE KeywordId=$keywordId";
	
	$result = $database->ExecuteSqlWithoutWarning($query);
	
	if(0 != $result)
	{
		$keyword->SetKeywordId(0);
	}
	
	return $keyword;
	
}

?>
