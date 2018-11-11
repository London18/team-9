import { Component, OnInit, Renderer } from '@angular/core';
import { MyAdapter } from './my-adapter';
import { MessagesService } from '../messages.service';
import { Message } from '../../shared/models/Message';
import { UserService } from './user.service';
import { Session } from '../../shared/models/Session';
import { User } from '../../shared/models/User';
import { ForumService } from '../forum.service';
import { PostCategory } from '../../shared/models/PostCategory';
import { Post } from '../../shared/models/Post';
import { Router, ActivatedRoute } from '@angular/router';

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

  keywords: string[];
  categories: PostCategory[];

  selectedPosts: Post[];

  constructor(
    private messagesService: MessagesService,
    private userService: UserService,
    private forumService: ForumService,
    private router: Router,
    private activatedRoute: ActivatedRoute
  ) {
    this.messagesService.messages$.subscribe((messages) => { this.messages = messages; });
    var guest = new User();
    guest.nickname = 'guest';
    guest.username = 'guest';
    guest.email = 'guest@mail.com';
    guest.password = 'empty';
    guest.age = 20;
    this.userService.createUser(guest)
      .subscribe((user) => {
        this.userId = user.userId;

        setInterval(() => { this.getAllMessages(); }, 2000);
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

    this.forumService.getCategories()
      .subscribe((categories: Object[]) => {
        this.categories = new Array<PostCategory>();
        categories.forEach(c => this.categories.push(new PostCategory(c['id'], c['name'], c['description'])));
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

  getImageForCategory(category: string) {
    switch (category) {
      case 'Abortion':
        return 'https://cdn.themix.org.uk/uploads/2016/01/GetInfo-sex-and-relationship.png';
    }
  }

  selectCategory(categoryId: number) {
    this.forumService.getPostsByCategoryId(categoryId)
      .subscribe((posts: Object[]) => {
        this.categories = null;
        this.selectedPosts = new Array<Post>();
        posts.forEach(p => this.selectedPosts.push(new Post(p['title']['rendered'], p['excerpt']['rendered'].slice(3, p['excerpt']['rendered'].length - 5), p['featured_image_url'], p['guid']['rendered'])))
      })
  }

  navigateToArticle(articleUrl: string): void {
    window.open(articleUrl, '_self');
  }
}
