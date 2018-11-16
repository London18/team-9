//generated automatically
using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Linq;
using System.Text;
using System.Threading.Tasks; 
using Newtonsoft.Json;
namespace DatabaseFunctionsGenerator
{
	public static class Users
	{
		public static async Task<List<User>> GetUsers()
		{
			List<User> users;
			string data;
			
			users = new List<User>();
			data = "";
			
			try
			{
				data = await HttpRequestClient.GetRequest("Users.php?cmd=getUsers");
				users = JsonConvert.DeserializeObject<List<User>>(data);
			}
			catch(Exception ee)
			{
				Console.WriteLine(ee.Message);
			}
			
			return users;
		
		}
		
		public static async Task<User> AddUser(User user)
		{
			string data;
			
			data = "";
			
			try
			{
				data = await HttpRequestClient.PostRequest("Users.php?cmd=addUser", user);
				user = JsonConvert.DeserializeObject<User>(data);
			}
			catch(Exception ee)
			{
				Console.WriteLine(ee.Message);
			}
			
			return user;
		
		}
		
	
	}

}
