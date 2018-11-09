<?php
class User
{
	var $userId;
	var $nickname;
	var $password;
	var $age;
	var $email;
	var $creationTime;

	function GetUserId()
	{
		return $this->userId;
	}
	function SetUserId($value)
	{
		$this->userId = $value;
	}
	
	function GetNickname()
	{
		return $this->nickname;
	}
	function SetNickname($value)
	{
		$this->nickname = $value;
	}
	
	function GetPassword()
	{
		return $this->password;
	}
	function SetPassword($value)
	{
		$this->password = $value;
	}
	
	function GetAge()
	{
		return $this->age;
	}
	function SetAge($value)
	{
		$this->age = $value;
	}
	
	function GetEmail()
	{
		return $this->email;
	}
	function SetEmail($value)
	{
		$this->email = $value;
	}
	
	function GetCreationTime()
	{
		return $this->creationTime;
	}
	function SetCreationTime($value)
	{
		$this->creationTime = $value;
	}
	

	function User($Nickname, $Password, $Age, $Email)
	{
		$this->userId = 0;
	
		$this->nickname = $Nickname;
		$this->password = $Password;
		$this->age = $Age;
		$this->email = $Email;
	}

}
?>
