<?php
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Headers: *'); 
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
$_POST = json_decode(file_get_contents('php://input'), true);
require_once 'Models/Keyword.php';
require_once 'DatabaseOperations.php';
require_once 'Helpers.php';
function ConvertListToKeywords($data)
{
	$keywords = [];
	
	foreach($data as $row)
	{
		$keyword = new Keyword(
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


function AddKeyword($database, $keyword)
{
	$query = "INSERT INTO Keywords(Word, CreationTime) VALUES(";
	$query = $query . "'" . $keyword->GetWord() . "', ";
	$query = $query . "NOW()"."";
	
	$query = $query . ");";
	$database->ExecuteSqlWithoutWarning($query);
	$id = $database->GetLastInsertedId();
	$keyword->SetKeywordId($id);
	$keyword->SetCreationTime(date('Y-m-d H:i:s'));
	return $keyword;
	
}

function UpdateKeyword($database, $keyword)
{
	$query = "UPDATE Keywords SET ";
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
		'Test'//Word
	);
	
	AddKeyword($database, $keyword);
}

function GetEmptyKeyword()
{
	$keyword = new Keyword(
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

	else if("addKeyword" == $_GET["cmd"])
	{
		if(CheckGetParameters([
			'word'
		]))
		{
			$database = new DatabaseOperations();
			$keyword = new Keyword(
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
			'word'
		]))
		{
			$database = new DatabaseOperations();
			$keyword = new Keyword(
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
