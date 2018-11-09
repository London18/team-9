import { User } from './User';

export interface Session {
	sessionId: number;
	userId: number;
	creationTime: string;
	user: User;
}