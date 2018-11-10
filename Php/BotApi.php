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

    //ask about nickname
    if(1 == sizeof($messages))
    {
        return "Please tell how would you like me to call you!";    
    }

    $keywords = getKeywordsFromSentence($messages[sizeof($messages) - 1]);
    
    getClosest($keywords, GetResponses($database));
    //var_dump();

    return "Api message " . sizeof($messages);
}

?>