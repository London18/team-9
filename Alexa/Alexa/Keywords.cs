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
	public static class Keywords
	{
		public static async Task<List<Keyword>> GetKeywords()
		{
			List<Keyword> keywords;
			string data;
			
			keywords = new List<Keyword>();
			data = "";
			
			try
			{
				data = await HttpRequestClient.GetRequest("Keywords.php?cmd=getKeywords");
				keywords = JsonConvert.DeserializeObject<List<Keyword>>(data);
			}
			catch(Exception ee)
			{
				Console.WriteLine(ee.Message);
			}
			
			return keywords;
		
		}
		
		public static async Task<Keyword> AddKeyword(Keyword keyword)
		{
			string data;
			
			data = "";
			
			try
			{
				data = await HttpRequestClient.PostRequest("Keywords.php?cmd=addKeyword", keyword);
				keyword = JsonConvert.DeserializeObject<Keyword>(data);
			}
			catch(Exception ee)
			{
				Console.WriteLine(ee.Message);
			}
			
			return keyword;
		
		}
		
	
	}

}
