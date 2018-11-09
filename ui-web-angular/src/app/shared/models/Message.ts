import { Session } from './Session';
import { User } from './User';

export interface Message {
	messageId: number;
	userId: number;
	sessionId: number;
	value: string;
	creationTime: string;
	session: Session;
	user: User;
}