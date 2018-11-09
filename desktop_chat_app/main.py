from gtts import gTTS
import pygame


def play_message(msg):
	tts = gTTS(msg)
	tts.save('audio.mp3')
	pygame.mixer.init()
	pygame.mixer.music.load('audio.mp3')
	pygame.mixer.music.play()
	while pygame.mixer.music.get_busy() == True:
	    continue


if __name__ == '__main__':
	play_message("some message")
