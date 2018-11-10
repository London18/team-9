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
	public static class Responses
	{
		public static async Task<List<Response>> GetResponses()
		{
			List<Response> responses;
			string data;
			
			responses = new List<Response>();
			data = "";
			
			try
			{
				data = await HttpRequestClient.GetRequest("Responses.php?cmd=getResponses");
				responses = JsonConvert.DeserializeObject<List<Response>>(data);
			}
			catch(Exception ee)
			{
				Console.WriteLine(ee.Message);
			}
			
			return responses;
		
		}
		
		public static async Task<Response> AddResponse(Response response)
		{
			string data;
			
			data = "";
			
			try
			{
				data = await HttpRequestClient.PostRequest("Responses.php?cmd=addResponse", response);
				response = JsonConvert.DeserializeObject<Response>(data);
			}
			catch(Exception ee)
			{
				Console.WriteLine(ee.Message);
			}
			
			return response;
		
		}
		
	
	}

}
