import { Component } from '@angular/core';
import { ChatAdapter } from 'ng-chat';
import { MyAdapter } from './my-adapter';

@Component({
    selector: 'app-root',
    templateUrl: './app.component.html',
    styleUrls: ['./app.component.scss']
})
export class AppComponent {
    title = 'app';
    userId = 999;

    public adapter: ChatAdapter = new MyAdapter();
}
