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
	public class User
	{
		private int _userId;
		private string _nickname;
		private string _username;
		private string _password;
		private int _age;
		private string _email;
		private DateTime _creationTime;
		
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
		
		[JsonProperty(PropertyName = "nickname")]
		public string Nickname
		{
			get
			{
				return _nickname;
			}
			set
			{
				_nickname = value;
			}
		}
		
		[JsonProperty(PropertyName = "username")]
		public string Username
		{
			get
			{
				return _username;
			}
			set
			{
				_username = value;
			}
		}
		
		[JsonProperty(PropertyName = "password")]
		public string Password
		{
			get
			{
				return _password;
			}
			set
			{
				_password = value;
			}
		}
		
		[JsonProperty(PropertyName = "age")]
		public int Age
		{
			get
			{
				return _age;
			}
			set
			{
				_age = value;
			}
		}
		
		[JsonProperty(PropertyName = "email")]
		public string Email
		{
			get
			{
				return _email;
			}
			set
			{
				_email = value;
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
		
		
		public User(string nickname, string username, string password, int age, string email)
		{
			_nickname = nickname;
			_username = username;
			_password = password;
			_age = age;
			_email = email;
		}
		
		public User()
			 :this(
				"Test", //Nickname
				"Test", //Username
				"Test", //Password
				0, //Age
				"Test" //Email
			)
		{
			_userId = 0;
			_creationTime = new DateTime(1970, 1, 1, 0, 0, 0);
		}
		
	
	}

}
