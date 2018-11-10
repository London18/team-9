import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { NgChatModule } from 'ng-chat';

import { AppComponent } from './app.component';
import { CoreModule } from './core/core.module';
import { MaterialDesignModule } from './material-design/material-design.module';

@NgModule({
    declarations: [
        AppComponent
    ],
    imports: [
        BrowserModule,
        CoreModule,
        MaterialDesignModule,
        NgChatModule
    ],
    providers: [],
    bootstrap: [AppComponent],
    exports: [
        MaterialDesignModule,
        NgChatModule
    ]
})
export class AppModule { }
