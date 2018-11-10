import { User } from './User';

export class Session {
	sessionId: number;
	userId: number;
	creationTime: string;
	user: User;

	public Session() {
		this.user = new User();
	}
}