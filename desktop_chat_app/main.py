from flask import Flask
import speech_recognition as sr
import requests
import pyttsx3
import json

app = Flask(__name__)

r = sr.Recognizer()

createSessionUrl = 'http://35.242.228.41/Sessions.php?cmd=addSession&userId='
createMessageUrl = 'http://35.242.228.41/Messages.php?cmd=addMessage'
getMessagesUrl = 'http://35.242.228.41/Messages.php?cmd=getMessagesBySessionId&sessionId='


if __name__ == '__main__':
    userIs = '1112'
    resp = requests.get(createSessionUrl + userIs)
    sessionId = resp.json()['sessionId']
    while True:
        with sr.Microphone() as source:
            audio = r.listen(source, phrase_time_limit=3)
            heard = r.recognize_sphinx(audio)
        jsony = dict(
            sessionId=sessionId,
            userId=userIs,
            value=heard
        )
        print("I sent:" + heard)
        resp = requests.post(createMessageUrl, json.dumps(jsony))
        answer = requests.get(getMessagesUrl + str(sessionId)).json()[-1]['value']
        print("I received:" + answer)
        engine = pyttsx3.init()
        engine.say(answer)
        engine.runAndWait()
