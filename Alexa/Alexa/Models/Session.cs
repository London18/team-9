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
	public class Session
	{
		private int _sessionId;
		private int _userId;
		private DateTime _creationTime;
		private User _user;
		
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
		
		
		public Session(int userId)
		{
			_userId = userId;
		}
		
		public Session(int userId, User user)
			:this(userId)
		{
			_userId = userId;
		}
		
		public Session()
			 :this(
				0 //UserId
			)
		{
			_sessionId = 0;
			_creationTime = new DateTime(1970, 1, 1, 0, 0, 0);
		}
		
	
	}

}
