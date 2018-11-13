import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';
import { Message } from '../shared/models/Message';
import { HttpClient, HttpParams } from '@angular/common/http';
import { ServerUrl } from './ServerUrl';

@Injectable({
  providedIn: 'root'
})
export class MessagesService {

  messages: Message[];
  messages$: BehaviorSubject<Message[]>;

  welcomeMessage1: Message = this.createMessage('Hello! I am Sam, the friendly bot!');
  welcomeMessage2: Message = this.createMessage('How can I help you today?');

  constructor(private httpClient: HttpClient) {
    this.messages$ = new BehaviorSubject<Message[]>(null);
    this.messages = new Array<Message>();
  }

  public sendMessage(messageText: string, userId: number, sessionId: number) {
    var message = new Message();
    message.userId = userId;
    message.sessionId = sessionId;
    message.value = messageText;
    return this.httpClient.post(ServerUrl.GetUrl() + 'Messages.php?cmd=addMessage', message);
  }

  private createMessage(messageText: string): Message {
    var message = new Message();
    message.value = messageText;
    message.userId = 0;
    message.session.userId = 0;
    return message;
  }

  public getMessagesBySessionId(sessionId: number) {
    return this.httpClient.get<Message[]>(ServerUrl.GetUrl() + "Messages.php?cmd=getMessagesBySessionId&sessionId=" + sessionId);
  }
}
