<?php
require_once 'Session.php';
class Feedback
{
	var $feedbackId;
	var $sessionId;
	var $value;
	var $description;
	var $creationTime;
	var $session;

	function GetFeedbackId()
	{
		return $this->feedbackId;
	}
	function SetFeedbackId($value)
	{
		$this->feedbackId = $value;
	}
	
	function GetSessionId()
	{
		return $this->sessionId;
	}
	function SetSessionId($value)
	{
		$this->sessionId = $value;
	}
	
	function GetValue()
	{
		return $this->value;
	}
	function SetValue($value)
	{
		$this->value = $value;
	}
	
	function GetDescription()
	{
		return $this->description;
	}
	function SetDescription($value)
	{
		$this->description = $value;
	}
	
	function GetCreationTime()
	{
		return $this->creationTime;
	}
	function SetCreationTime($value)
	{
		$this->creationTime = $value;
	}
	
	function GetSession()
	{
		return $this->session;
	}
	function SetSession($value)
	{
		$this->session = $value;
	}
	

	function Feedback($SessionId, $Value, $Description)
	{
		$this->feedbackId = 0;
	
		$this->sessionId = $SessionId;
		$this->value = $Value;
		$this->description = $Description;
	}

}
?>
