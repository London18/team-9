import { Injectable } from '@angular/core';

import { ServerUrl } from '../ServerUrl';
import { HttpClient } from '@angular/common/http';
import { Session } from '../../shared/models/Session';
import { User } from '../../shared/models/User';

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
