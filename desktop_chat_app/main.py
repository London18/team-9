from flask import Flask
from gtts import gTTS
# import pygame
import speech_recognition as sr
import requests

app = Flask(__name__)

r = sr.Recognizer()

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
    if request.method == 'POST':
        audio_file = request.files['file']
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
    app.run()
