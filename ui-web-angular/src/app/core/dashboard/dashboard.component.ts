import { Component, OnInit } from '@angular/core';
import { ChatAdapter } from 'ng-chat';
import { MyAdapter } from './my-adapter';
import { MessagesService } from '../messages.service';
import { Message } from '../../shared/models/Message';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.scss']
})
export class DashboardComponent implements OnInit {

  title = 'app';
  userId = 999;

  messages: Message[];

  public adapter: ChatAdapter = new MyAdapter();

  constructor(private messagesService: MessagesService) {
    this.messagesService.messages$.subscribe((messages) => { this.messages = messages; console.log(messages); });
  }

  ngOnInit() { }

  getMessageDirection(message: Message): boolean {
    return message.userId == message.session.userId;
  }
}
