using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using System.Net.Http;
using Alexa.NET.Response;
using Alexa.NET.Request.Type;
using Alexa.NET.Request;
using Amazon.Lambda.Core;

// Assembly attribute to enable the Lambda function's JSON input to be converted into a .NET class.
[assembly: LambdaSerializer(typeof(Amazon.Lambda.Serialization.Json.JsonSerializer))]

namespace Alexa
{
    public class Function
    {

        /// <summary>
        /// A simple function that takes a string and does a ToUpper
        /// </summary>
        /// <param name="input"></param>
        /// <param name="context"></param>
        /// <returns></returns>
        public async Task<SkillResponse> FunctionHandler(SkillRequest input, ILambdaContext context)
        {
            var requestType = input.GetRequestType();
            if ((requestType == typeof(IntentRequest)))
            {
                var intentRequest = input.Request as IntentRequest;
                context.Logger.LogLine($"Intent:\n{intentRequest.Intent}");
                context.Logger.LogLine($"Intent.name:\n{intentRequest.Intent.Name}");


                var intentName = intentRequest.Intent.Name;
                var outputText = "I have nothing to say";



                if ("Help" == intentName)
                {
                    /*Entry entry = (await TriggerAction<Entry>("getStatus.php", context));
                    //BoardInfo board = (await TriggerAction<BoardInfo>("getBoardData.php", context));
                    outputText = $"The eldery person has a pulse of {entry.Data[0].Temperature} beats per minute, today has done {entry.Data[0].Steps} steps and ";

                    if (entry.Status[0].Description.Equals("FALL"))
                    {
                        outputText += "fall was detected";
                    }
                    else
                    {*/
                    outputText = "no fall was detected";
                    //}
                }



                else
                {
                    outputText = $"Cosmin loves to suck the shaft.";
                }
                return MakeSkillResponse(outputText, true);
            }
            else
            {
                return MakeSkillResponse(
                       "no data",
                        true);
            }
        }

        private SkillResponse MakeSkillResponse(string outputSpeech,
            bool shouldEndSession,
            string repromptText = "Just say, tell me about Canada to learn more. To exit, say, exit.")
        {
            var response = new ResponseBody
            {
                ShouldEndSession = shouldEndSession,
                OutputSpeech = new PlainTextOutputSpeech { Text = outputSpeech }
            };

            if (repromptText != null)
            {
                response.Reprompt = new Reprompt() { OutputSpeech = new PlainTextOutputSpeech() { Text = repromptText } };
            }

            var skillResponse = new SkillResponse
            {
                Response = response,
                Version = "1.0"
            };
            return skillResponse;
        }

        private int SearchInString(string text, string searchedString)
        {

            for (int i = 0; i < text.Length; i++)
            {
                for (int j = 0; j < searchedString.Length; j++)
                {
                    if (searchedString[j] != text[i + j])
                    {
                        break;
                    }
                    else if ((searchedString.Length - 1) == j)
                    {
                        return i;
                    }
                }
            }

            return -1;
        }
    }
}
