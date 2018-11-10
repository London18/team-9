<?php

require_once 'Responses.php';

function getKeywordsFromSentence($message)
{
    $words = explode(" ", $message->GetValue());

    return $words;
}

function getClosest($keywords, $responses)
{

    $most=0;
    $responseMax = null;
    foreach($responses as $response)
    {
        $matches=0;
        foreach($keywords as $keyword)
        {
            foreach($response->GetKeywords() as $Answerkeyword )
            {
                if($Answerkeyword->GetWord() == $keyword)
                {

                   $matches++;

                   break;
                }
            }

            if($matches > $most)
            {

                $most = $matches;
                $responseMax = $response;
            }
        }
        
    }
	return $responseMax;
}

function getResponse($database, $messages)
{


    //first message
    if(0 == sizeof($messages))
    {
        return "Hello! My name is Sam and i'm a chatbot. I want to help while while you are transfered to a real person. Let's start by telling me how you want me to call you";    
    }
    else if(1 == sizeof($messages))
    {
        return "Nice to meet you ".$messages[0]->GetValue().". From a scale from 1 to 10, how are you feeling? ";    
    }

    $keywords = getKeywordsFromSentence($messages[sizeof($messages) - 1]);
file_put_contents("keywords.log",json_encode($keywords)." empty");    
	$closest=getClosest($keywords, GetResponses($database));
	file_put_contents("object4.log",json_encode($closest)." empty");
	$message = "I am sorry but i am still learning. Could you be more clear?";

	if(null != $closest)
{

	$message="You may want to check ".$closest->GetName();
}
    //var_dump();

    return $message;
}

?>