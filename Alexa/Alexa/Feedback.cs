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
	public static class Feedbacks
	{
		public static async Task<List<Feedback>> GetFeedback()
		{
			List<Feedback> feedback;
			string data;
			
			feedback = new List<Feedback>();
			data = "";
			
			try
			{
				data = await HttpRequestClient.GetRequest("Feedback.php?cmd=getFeedback");
				feedback = JsonConvert.DeserializeObject<List<Feedback>>(data);
			}
			catch(Exception ee)
			{
				Console.WriteLine(ee.Message);
			}
			
			return feedback;
		
		}
		
		public static async Task<Feedback> AddFeedback(Feedback feedback)
		{
			string data;
			
			data = "";
			
			try
			{
				data = await HttpRequestClient.PostRequest("Feedback.php?cmd=addFeedback", feedback);
				feedback = JsonConvert.DeserializeObject<Feedback>(data);
			}
			catch(Exception ee)
			{
				Console.WriteLine(ee.Message);
			}
			
			return feedback;
		
		}
		
	
	}

}
