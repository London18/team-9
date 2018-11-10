<?php
require_once 'Session.php';
require_once 'User.php';
class Message
{
	var $messageId;
	var $userId;
	var $sessionId;
	var $value;
	var $creationTime;
	var $session;
	var $user;

	function GetMessageId()
	{
		return $this->messageId;
	}
	function SetMessageId($value)
	{
		$this->messageId = $value;
	}
	
	function GetUserId()
	{
		return $this->userId;
	}
	function SetUserId($value)
	{
		$this->userId = $value;
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
	
	function GetUser()
	{
		return $this->user;
	}
	function SetUser($value)
	{
		$this->user = $value;
	}
	

	function Message($UserId, $SessionId, $Value)
	{
		$this->messageId = 0;
	
		$this->userId = $UserId;
		$this->sessionId = $SessionId;
		$this->value = $Value;
	}

}
?>
