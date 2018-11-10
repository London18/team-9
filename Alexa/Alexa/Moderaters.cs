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
	public static class Moderaters
	{
		public static async Task<List<Moderater>> GetModeraters()
		{
			List<Moderater> moderaters;
			string data;
			
			moderaters = new List<Moderater>();
			data = "";
			
			try
			{
				data = await HttpRequestClient.GetRequest("Moderaters.php?cmd=getModeraters");
				moderaters = JsonConvert.DeserializeObject<List<Moderater>>(data);
			}
			catch(Exception ee)
			{
				Console.WriteLine(ee.Message);
			}
			
			return moderaters;
		
		}
		
		public static async Task<Moderater> AddModerater(Moderater moderater)
		{
			string data;
			
			data = "";
			
			try
			{
				data = await HttpRequestClient.PostRequest("Moderaters.php?cmd=addModerater", moderater);
				moderater = JsonConvert.DeserializeObject<Moderater>(data);
			}
			catch(Exception ee)
			{
				Console.WriteLine(ee.Message);
			}
			
			return moderater;
		
		}
		
	
	}

}
