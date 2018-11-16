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
	public class Message
	{
		private int _messageId;
		private int _userId;
		private int _sessionId;
		private string _value;
		private DateTime _creationTime;
		private Session _session;
		private User _user;
		
		[JsonProperty(PropertyName = "messageId")]
		public int MessageId
		{
			get
			{
				return _messageId;
			}
			set
			{
				_messageId = value;
			}
		}
		
		[JsonProperty(PropertyName = "userId")]
		public int UserId
		{
			get
			{
				return _userId;
			}
			set
			{
				_userId = value;
			}
		}
		
		[JsonProperty(PropertyName = "sessionId")]
		public int SessionId
		{
			get
			{
				return _sessionId;
			}
			set
			{
				_sessionId = value;
			}
		}
		
		[JsonProperty(PropertyName = "value")]
		public string Value
		{
			get
			{
				return _value;
			}
			set
			{
				_value = value;
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
		
		[JsonProperty(PropertyName = "session")]
		public Session Session
		{
			get
			{
				return _session;
			}
			set
			{
				_session = value;
			}
		}
		
		[JsonProperty(PropertyName = "user")]
		public User User
		{
			get
			{
				return _user;
			}
			set
			{
				_user = value;
			}
		}
		
		
		public Message(int userId, int sessionId, string value)
		{
			_userId = userId;
			_sessionId = sessionId;
			_value = value;
		}
		
		public Message(int userId, int sessionId, string value, Session session, User user)
			:this(userId, sessionId, value)
		{
			_userId = userId;
			_sessionId = sessionId;
			_value = value;
		}
		
		public Message()
			 :this(
				0, //UserId
				0, //SessionId
				"Test" //Value
			)
		{
			_messageId = 0;
			_creationTime = new DateTime(1970, 1, 1, 0, 0, 0);
		}
		
	
	}

}
