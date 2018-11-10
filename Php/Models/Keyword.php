<?php
require_once 'Response.php';
class Keyword
{
	var $keywordId;
	var $responseId;
	var $word;
	var $creationTime;
	var $response;

	function GetKeywordId()
	{
		return $this->keywordId;
	}
	function SetKeywordId($value)
	{
		$this->keywordId = $value;
	}
	
	function GetResponseId()
	{
		return $this->responseId;
	}
	function SetResponseId($value)
	{
		$this->responseId = $value;
	}
	
	function GetWord()
	{
		return $this->word;
	}
	function SetWord($value)
	{
		$this->word = $value;
	}
	
	function GetCreationTime()
	{
		return $this->creationTime;
	}
	function SetCreationTime($value)
	{
		$this->creationTime = $value;
	}
	
	function GetResponse()
	{
		return $this->response;
	}
	function SetResponse($value)
	{
		$this->response = $value;
	}
	

	function Keyword($ResponseId, $Word)
	{
		$this->keywordId = 0;
	
		$this->responseId = $ResponseId;
		$this->word = $Word;
	}

}
?>
