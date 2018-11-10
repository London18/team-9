import { User } from './User';

export interface Location {
	locationId: number;
	userId: number;
	deviceName: string;
	x: number;
	y: number;
	creationTime: string;
	user: User;
}