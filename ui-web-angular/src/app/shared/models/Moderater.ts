import { User } from './User';

export interface Moderater {
	moderaterId: number;
	userId: number;
	role: number;
	creationTime: string;
	user: User;
}