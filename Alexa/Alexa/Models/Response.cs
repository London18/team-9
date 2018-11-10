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
	public class Response
	{
		private int _responseId;
		private string _name;
		private DateTime _creationTime;
		
		[JsonProperty(PropertyName = "responseId")]
		public int ResponseId
		{
			get
			{
				return _responseId;
			}
			set
			{
				_responseId = value;
			}
		}
		
		[JsonProperty(PropertyName = "name")]
		public string Name
		{
			get
			{
				return _name;
			}
			set
			{
				_name = value;
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
		
		
		public Response(string name)
		{
			_name = name;
		}
		
		public Response()
			 :this(
				"Test" //Name
			)
		{
			_responseId = 0;
			_creationTime = new DateTime(1970, 1, 1, 0, 0, 0);
		}
		
	
	}

}
