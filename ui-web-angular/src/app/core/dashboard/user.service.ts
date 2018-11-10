import { Injectable } from '@angular/core';
import { ServerUrl } from '../ServerUrl';
import { HttpClient } from '@angular/common/http';
import { pipe } from 'rxjs';
import { map } from 'rxjs/operators';
import { Session } from '../../shared/models/Session';
import { User } from '../../shared/models/User';
import { Message } from '../../shared/models/Message';

@Injectable({
  providedIn: 'root'
})
export class UserService {

  constructor(private httpClient: HttpClient) { }

  public createUser(user) {
    return this.httpClient.post<User>(ServerUrl.GetUrl() + "Users.php?cmd=addUser", user);
  }

  public createSession(userId) {
    return this.httpClient.get<Session>(ServerUrl.GetUrl() + "Sessions.php?cmd=addSession" + "&userId=" + userId);
  }
}
