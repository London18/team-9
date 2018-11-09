<?php
class Notification
{
	var $notificationId;
	var $title;
	var $creationTime;

	function GetNotificationId()
	{
		return $this->notificationId;
	}
	function SetNotificationId($value)
	{
		$this->notificationId = $value;
	}
	
	function GetTitle()
	{
		return $this->title;
	}
	function SetTitle($value)
	{
		$this->title = $value;
	}
	
	function GetCreationTime()
	{
		return $this->creationTime;
	}
	function SetCreationTime($value)
	{
		$this->creationTime = $value;
	}
	

	function Notification($Title)
	{
		$this->notificationId = 0;
	
		$this->title = $Title;
	}

}
?>
