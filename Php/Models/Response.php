<?php
class Response
{
	var $responseId;
	var $name;
	var $creationTime;
	var $keywords;

	function GetResponseId()
	{
		return $this->responseId;
	}
	function SetResponseId($value)
	{
		$this->responseId = $value;
	}
	
	function GetName()
	{
		return $this->name;
	}
	function SetName($value)
	{
		$this->name = $value;
	}
	
	function GetCreationTime()
	{
		return $this->creationTime;
	}
	function SetCreationTime($value)
	{
		$this->creationTime = $value;
	}

	function GetKeywords()
	{
		return $this->keywords;
	}
	function SetKeywords($value)
	{
		$this->keywords = $value;
	}
	

	function Response($Name)
	{
		$this->responseId = 0;
	
		$this->name = $Name;
	}

}
?>
