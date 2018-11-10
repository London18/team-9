import { Session } from './Session';
import { User } from './User';

export class Message {
	messageId: number;
	userId: number;
	sessionId: number;
	value: string;
	creationTime: string;
	session: Session;
	user: User;

	public constructor() {
		this.session = new Session();
		this.user = new User();
	}
}