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
	public class Keyword
	{
		private int _keywordId;
		private int _responseId;
		private string _word;
		private DateTime _creationTime;
		private Response _response;
		
		[JsonProperty(PropertyName = "keywordId")]
		public int KeywordId
		{
			get
			{
				return _keywordId;
			}
			set
			{
				_keywordId = value;
			}
		}
		
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
		
		[JsonProperty(PropertyName = "word")]
		public string Word
		{
			get
			{
				return _word;
			}
			set
			{
				_word = value;
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
		
		[JsonProperty(PropertyName = "response")]
		public Response Response
		{
			get
			{
				return _response;
			}
			set
			{
				_response = value;
			}
		}
		
		
		public Keyword(int responseId, string word)
		{
			_responseId = responseId;
			_word = word;
		}
		
		public Keyword(int responseId, string word, Response response)
			:this(responseId, word)
		{
			_responseId = responseId;
			_word = word;
		}
		
		public Keyword()
			 :this(
				0, //ResponseId
				"Test" //Word
			)
		{
			_keywordId = 0;
			_creationTime = new DateTime(1970, 1, 1, 0, 0, 0);
		}
		
	
	}

}
