import { Observable, of } from 'rxjs';
import { ChatAdapter, User, Message, UserStatus } from 'ng-chat';

export class MyAdapter extends ChatAdapter {

    listFriends(): Observable<User[]> {
        var user1 = new User();
        user1.id = 1;
        user1.displayName = 'Macy';
        user1.status = UserStatus.Online;
        var user2 = new User();
        user2.id = 1;
        user2.displayName = 'Richard';
        user2.status = UserStatus.Online;
        return of([user1, user2]);
    }
    getMessageHistory(userId: any): Observable<Message[]> {
        return of(userId);
    }
    sendMessage(message: Message): void {

    }
    onFriendsListChanged(users: User[]): void {

    }
    onMessageReceived(user: User, message: Message): void {

    }
}