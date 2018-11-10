import { User } from './User';

export interface CheckIn {
	checkInId: number;
	userId: number;
	scannerName: string;
	creationTime: string;
	user: User;
}