<?php
require_once 'User.php';
class Moderater
{
	var $moderaterId;
	var $userId;
	var $role;
	var $creationTime;
	var $user;

	function GetModeraterId()
	{
		return $this->moderaterId;
	}
	function SetModeraterId($value)
	{
		$this->moderaterId = $value;
	}
	
	function GetUserId()
	{
		return $this->userId;
	}
	function SetUserId($value)
	{
		$this->userId = $value;
	}
	
	function GetRole()
	{
		return $this->role;
	}
	function SetRole($value)
	{
		$this->role = $value;
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
	

	function Moderater($UserId, $Role)
	{
		$this->moderaterId = 0;
	
		$this->userId = $UserId;
		$this->role = $Role;
	}

}
?>
