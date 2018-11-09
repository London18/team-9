import speech_recognition as sr


r = sr.Recognizer()

with sr.Microphone() as source:
	print('Hi I am Sam')
	audio = r.listen(source)
	print('Time over, boss')

try:
	print('Text: ', r.recognize_google(audio))
except:
	pass