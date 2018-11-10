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
	public static class Sessions
	{
		public static async Task<List<Session>> GetSessions()
		{
			List<Session> sessions;
			string data;
			
			sessions = new List<Session>();
			data = "";
			
			try
			{
				data = await HttpRequestClient.GetRequest("Sessions.php?cmd=getSessions");
				sessions = JsonConvert.DeserializeObject<List<Session>>(data);
			}
			catch(Exception ee)
			{
				Console.WriteLine(ee.Message);
			}
			
			return sessions;
		
		}
		
		public static async Task<Session> AddSession(Session session)
		{
			string data;
			
			data = "";
			
			try
			{
				data = await HttpRequestClient.PostRequest("Sessions.php?cmd=addSession", session);
				session = JsonConvert.DeserializeObject<Session>(data);
			}
			catch(Exception ee)
			{
				Console.WriteLine(ee.Message);
			}
			
			return session;
		
		}
		
	
	}

}
