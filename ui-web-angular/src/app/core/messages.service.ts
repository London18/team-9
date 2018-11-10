import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';
import { Message } from '../shared/models/Message';

@Injectable({
  providedIn: 'root'
})
export class MessagesService {

  messages: Message[];
  messages$: BehaviorSubject<Message[]>;

  welcomeMessage1: Message = this.createMessage('Hello! I am Sam, the friendly bot!');
  welcomeMessage2: Message = this.createMessage('How can I help you today?');

  constructor() {
    this.messages$ = new BehaviorSubject<Message[]>(null);
    this.messages = new Array<Message>();
    setTimeout(() => { this.messages.push(this.welcomeMessage1); this.messages$.next(this.messages); setTimeout(() => { this.messages.push(this.welcomeMessage2); this.messages$.next(this.messages); }, 2000); }, 2000);

  }

  private createMessage(messageText: string): Message {
    var message = new Message();
    message.value = messageText;
    message.userId = 0;
    message.session.userId = 1;
    return message;
  }
}
