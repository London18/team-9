import { Session } from './Session'

export interface Feedback {
	feedbackId: number;
	sessionId: number;
	value: string;
	description: string;
	creationTime: string;
	session: Session;
}