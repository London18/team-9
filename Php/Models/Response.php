<?php
class Response
{
	var $responseId;
	var $name;
	var $creationTime;

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
	

	function Response($Name)
	{
		$this->responseId = 0;
	
		$this->name = $Name;
	}

}
?>
