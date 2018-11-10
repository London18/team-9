import { User } from './User';

export interface VitalSign {
	vitalSignId: number;
	userId: number;
	deviceName: string;
	pulse: number;
	bodyTemperature: number;
	creationTime: string;
	user: User;
}