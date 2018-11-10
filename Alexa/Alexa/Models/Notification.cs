//generated automatically
using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Linq;
using System.Text;
using System.Threading.Tasks; 
namespace DatabaseFunctionsGenerator
{
	public class Notification
	{
		private int _notificationId;
		private string _title;
		private DateTime _creationTime;
		
		[JsonProperty(PropertyName = "notificationId")]
		public int NotificationId
		{
			get
			{
				return _notificationId;
			}
			set
			{
				_notificationId = value;
			}
		}
		
		[JsonProperty(PropertyName = "title")]
		public string Title
		{
			get
			{
				return _title;
			}
			set
			{
				_title = value;
			}
		}
		
		[JsonProperty(PropertyName = "creationTime")]
		public DateTime CreationTime
		{
			get
			{
				return _creationTime;
			}
			set
			{
				_creationTime = value;
			}
		}
		
		
		public Notification(string title)
		{
			_title = title;
		}
		
		public Notification()
			 :this(
				"Test" //Title
			)
		{
			_notificationId = 0;
			_creationTime = new DateTime(1970, 1, 1, 0, 0, 0);
		}
		
	
	}

}
