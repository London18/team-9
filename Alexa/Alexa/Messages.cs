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
	public static class Messages
	{
		public static async Task<List<Message>> GetMessages()
		{
			List<Message> messages;
			string data;
			
			messages = new List<Message>();
			data = "";
			
			try
			{
				data = await HttpRequestClient.GetRequest("Messages.php?cmd=getMessages");
				messages = JsonConvert.DeserializeObject<List<Message>>(data);
			}
			catch(Exception ee)
			{
				Console.WriteLine(ee.Message);
			}
			
			return messages;
		
		}
		
		public static async Task<Message> AddMessage(Message message)
		{
			string data;
			
			data = "";
			
			try
			{
				data = await HttpRequestClient.PostRequest("Messages.php?cmd=addMessage", message);
				message = JsonConvert.DeserializeObject<Message>(data);
			}
			catch(Exception ee)
			{
				Console.WriteLine(ee.Message);
			}
			
			return message;
		
		}
		
	
	}

}
