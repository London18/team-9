<?php
require_once 'User.php';
class Session
{
	var $sessionId;
	var $userId;
	var $creationTime;
	var $user;

	function GetSessionId()
	{
		return $this->sessionId;
	}
	function SetSessionId($value)
	{
		$this->sessionId = $value;
	}
	
	function GetUserId()
	{
		return $this->userId;
	}
	function SetUserId($value)
	{
		$this->userId = $value;
	}
	
	function GetCreationTime()
	{
		return $this->creationTime;
	}
	function SetCreationTime($value)
	{
		$this->creationTime = $value;
	}
	
	function GetUser()
	{
		return $this->user;
	}
	function SetUser($value)
	{
		$this->user = $value;
	}
	

	function Session($UserId)
	{
		$this->sessionId = 0;
	
		$this->userId = $UserId;
	}

}
?>
