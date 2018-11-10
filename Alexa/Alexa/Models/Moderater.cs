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
	public class Moderater
	{
		private int _moderaterId;
		private int _userId;
		private int _role;
		private DateTime _creationTime;
		private User _user;
		
		[JsonProperty(PropertyName = "moderaterId")]
		public int ModeraterId
		{
			get
			{
				return _moderaterId;
			}
			set
			{
				_moderaterId = value;
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
		
		[JsonProperty(PropertyName = "role")]
		public int Role
		{
			get
			{
				return _role;
			}
			set
			{
				_role = value;
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
		
		
		public Moderater(int userId, int role)
		{
			_userId = userId;
			_role = role;
		}
		
		public Moderater(int userId, int role, User user)
			:this(userId, role)
		{
			_userId = userId;
			_role = role;
		}
		
		public Moderater()
			 :this(
				0, //UserId
				0 //Role
			)
		{
			_moderaterId = 0;
			_creationTime = new DateTime(1970, 1, 1, 0, 0, 0);
		}
		
	
	}

}
