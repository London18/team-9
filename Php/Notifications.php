<?php
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Headers: *'); 
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
$_POST = json_decode(file_get_contents('php://input'), true);
require_once 'Models/Notification.php';
require_once 'DatabaseOperations.php';
require_once 'Helpers.php';
function ConvertListToNotifications($data)
{
	$notifications = [];
	
	foreach($data as $row)
	{
		$notification = new Notification(
		$row["Title"] 
		);
	
		$notification->SetNotificationId($row["NotificationId"]);
		$notification->SetCreationTime($row["CreationTime"]);
	
		$notifications[count($notifications)] = $notification;
	}
	
	return $notifications;
}

function GetNotifications($database)
{
	$data = $database->ReadData("SELECT * FROM Notifications");
	$notifications = ConvertListToNotifications($data);
	return $notifications;
}

function GetNotificationsByNotificationId($database, $notificationId)
{
	$data = $database->ReadData("SELECT * FROM Notifications WHERE NotificationId = $notificationId");
	$notifications = ConvertListToNotifications($data);
	if(0== count($notifications))
	{
		return [GetEmptyNotification()];
	}
	return $notifications;
}


function AddNotification($database, $notification)
{
	$query = "INSERT INTO Notifications(Title, CreationTime) VALUES(";
	$query = $query . "'" . $notification->GetTitle() . "', ";
	$query = $query . "NOW()"."";
	
	$query = $query . ");";
	$database->ExecuteSqlWithoutWarning($query);
	$id = $database->GetLastInsertedId();
	$notification->SetNotificationId($id);
	$notification->SetCreationTime(date('Y-m-d H:i:s'));
	return $notification;
	
}

function UpdateNotification($database, $notification)
{
	$query = "UPDATE Notifications SET ";
	$query = $query . "Title='" . $notification->GetTitle() . "'";
	$query = $query . " WHERE NotificationId=" . $notification->GetNotificationId();
	
	$result = $database->ExecuteSqlWithoutWarning($query);
	if(0 == $result)
	{
		$notification->SetNotificationId(0);
	}
	return $notification;
	
}

function TestAddNotification($database)
{
	$notification = new Notification(
		'Test'//Title
	);
	
	AddNotification($database, $notification);
}

function GetEmptyNotification()
{
	$notification = new Notification(
		''//Title
	);
	
	return $notification;
}

if(CheckGetParameters(["cmd"]))
{
	if("getNotifications" == $_GET["cmd"])
	{
		$database = new DatabaseOperations();
			echo json_encode(GetNotifications($database));
	}

	else if("getNotificationsByNotificationId" == $_GET["cmd"])
	{
		if(CheckGetParameters([
			'notificationId'
			]))
		{
			$database = new DatabaseOperations();
			echo json_encode(GetNotificationsByNotificationId($database, 
				$_GET["notificationId"]
			));
		}
	
	}

	else if("addNotification" == $_GET["cmd"])
	{
		if(CheckGetParameters([
			'title'
		]))
		{
			$database = new DatabaseOperations();
			$notification = new Notification(
				$_GET['title']
			);
		
			echo json_encode(AddNotification($database, $notification));
		}
	
	}

}

if(CheckGetParameters(["cmd"]))
{
	if("addNotification" == $_GET["cmd"])
	{
		if(CheckPostParameters([
			'title'
		]))
		{
			$database = new DatabaseOperations();
			$notification = new Notification(
				$_POST['title']
			);
	
			echo json_encode(AddNotification($database, $notification));
		}

	}
}

if(CheckGetParameters(["cmd"]))
{
	if("updateNotification" == $_GET["cmd"])
	{
		$database = new DatabaseOperations();
		$notification = new Notification(
			$_POST['title']
		);
		$notification->SetNotificationId($_POST['notificationId']);
		$notification->SetCreationTime($_POST['creationTime']);
		
		$notification = UpdateNotification($database, $notification);
		echo json_encode($notification);

	}
}

if("DELETE" == $_SERVER['REQUEST_METHOD']
	&& CheckGetParameters(["cmd"]))
{
	if("deleteNotification" == $_GET["cmd"])
	{
		$database = new DatabaseOperations();
		$notificationId = $_GET['notificationId'];
		
		$notification = DeleteNotification($database, $notificationId);
		echo json_encode($notification);

	}
}


function DeleteNotification($database, $notificationId)
{
	$notification = GetNotificationsByNotificationId($database, $notificationId)[0];
	
	$query = "DELETE FROM Notifications WHERE NotificationId=$notificationId";
	
	$result = $database->ExecuteSqlWithoutWarning($query);
	
	if(0 != $result)
	{
		$notification->SetNotificationId(0);
	}
	
	return $notification;
	
}

?>
