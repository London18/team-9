from flask import Flask
from gtts import gTTS
import pygame
import speech_recognition as sr
import requests
import pyttsx3
import json

app = Flask(__name__)

r = sr.Recognizer()

createSessionUrl = 'http://35.242.228.41/Sessions.php?cmd=addSession&userId='
createMessageUrl = 'http://35.242.228.41/Messages.php?cmd=addMessage'
getMessagesUrl = 'http://35.242.228.41/Messages.php?cmd=getMessagesBySessionId&sessionId='


def convert(data):
    harvard = sr.AudioFile(data)
    output = None
    with harvard as source:
        audio = r.record(source)
        output = r.recognize_google(audio)
    return output


def test_convert_audio_to_text():
    harvard = sr.AudioFile('harvard.wav')
    with harvard as source:
        audio = r.record(source, duration=4)
        output = r.recognize_google(audio)
        print(output)


@app.route('/message', methods=['GET', 'POST'])
def message():
    if requests.method == 'POST':
        audio_file = requests.files['file']
        converted = convert(audio_file)
        return converted


def play_message(msg):
    tts = gTTS(msg)
    tts.save('audio.mp3')
    pygame.mixer.init()
    pygame.mixer.music.load('audio.mp3')
    pygame.mixer.music.play()
    while pygame.mixer.music.get_busy() == True:
        continue


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
