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
	public class Feedback
	{
		private int _feedbackId;
		private int _sessionId;
		private string _value;
		private string _description;
		private DateTime _creationTime;
		private Session _session;
		
		[JsonProperty(PropertyName = "feedbackId")]
		public int FeedbackId
		{
			get
			{
				return _feedbackId;
			}
			set
			{
				_feedbackId = value;
			}
		}
		
		[JsonProperty(PropertyName = "sessionId")]
		public int SessionId
		{
			get
			{
				return _sessionId;
			}
			set
			{
				_sessionId = value;
			}
		}
		
		[JsonProperty(PropertyName = "value")]
		public string Value
		{
			get
			{
				return _value;
			}
			set
			{
				_value = value;
			}
		}
		
		[JsonProperty(PropertyName = "description")]
		public string Description
		{
			get
			{
				return _description;
			}
			set
			{
				_description = value;
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
		
		[JsonProperty(PropertyName = "session")]
		public Session Session
		{
			get
			{
				return _session;
			}
			set
			{
				_session = value;
			}
		}
		
		
		public Feedback(int sessionId, string value, string description)
		{
			_sessionId = sessionId;
			_value = value;
			_description = description;
		}
		
		public Feedback(int sessionId, string value, string description, Session session)
			:this(sessionId, value, description)
		{
			_sessionId = sessionId;
			_value = value;
			_description = description;
		}
		
		public Feedback()
			 :this(
				0, //SessionId
				"Test", //Value
				"Test" //Description
			)
		{
			_feedbackId = 0;
			_creationTime = new DateTime(1970, 1, 1, 0, 0, 0);
		}
		
	
	}

}
