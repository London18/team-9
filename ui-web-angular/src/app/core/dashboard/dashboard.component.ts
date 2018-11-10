import { Component, OnInit } from '@angular/core';
import { MyAdapter } from './my-adapter';
import { MessagesService } from '../messages.service';
import { Message } from '../../shared/models/Message';
import { UserService } from './user.service';
import { Session } from '../../shared/models/Session';
import { User } from '../../shared/models/User';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.scss']
})
export class DashboardComponent implements OnInit {

  messages: Message[];
  messageInput: string;

  userId: number;
  sessionId: number;


  constructor(
    private messagesService: MessagesService,
    private userService: UserService) {
    this.messagesService.messages$.subscribe((messages) => { this.messages = messages; console.log(messages); });
    var guest = new User();
    guest.nickname = 'guest';
    guest.username = 'guest';
    guest.email = 'guest@mail.com';
    guest.password = 'empty';
    guest.age = 20;
    this.userService.createUser(guest)
      .subscribe((user) => {
        this.userId = user.userId;

        setInterval(/* function () {
          this.messagesService.getMessagesBySessionId(this.sessionId).subscribe((messages: Message[]) => {
            this.messages = new Array<Message>();
            messages.forEach(m => this.messages.push(m));
          });
        } */() => { console.log("HERE"); this.getAllMessages(); }, 2000);
        console.log("HEREEEEE")
        this.userService.createSession(user.userId)
          .subscribe((session: Session) => {
            this.sessionId = session.sessionId;
            this.messagesService.getMessagesBySessionId(this.sessionId)
              .subscribe((messages: Message[]) => {
                this.messages = new Array<Message>();
                messages.forEach(m => this.messages.push(m));
              })
          })
      });
  }

  ngOnInit() { }

  getMessageDirection(message: Message): boolean {
    if (message.session) {
      return message.userId == message.session.userId;
    }
  }

  getAllMessages() {
    this.messagesService.getMessagesBySessionId(this.sessionId).subscribe((messages: Message[]) => {
      this.messages = new Array<Message>();
      messages.forEach(m => this.messages.push(m));
    })
  }

  sendMessage() {
    this.messagesService.sendMessage(this.messageInput, this.userId, this.sessionId).subscribe();
    this.messageInput = '';
  }
}
