import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { CoreRoutingModule } from './core-routing.module';
import { LoginComponent } from './login/login.component';
import { HeaderComponent } from './header/header.component';
import { NotFoundComponent } from './not-found/not-found.component';
import { RouterModule } from '@angular/router';
import { AuthenticationService } from './services/authentication.service';
import { AuthGuardService } from './services/auth-guard.service';
import { DashboardComponent } from './dashboard/dashboard.component';
import { NgChatModule } from 'ng-chat';
import { MaterialDesignModule } from '../material-design/material-design.module';
import { FormsModule } from '@angular/forms';

@NgModule({
    imports: [
        CommonModule,
        CoreRoutingModule,
        NgChatModule,
        FormsModule,
        MaterialDesignModule
    ],
    declarations: [
        LoginComponent,
        HeaderComponent,
        NotFoundComponent,
        DashboardComponent
    ],
    exports: [
        RouterModule,
        HeaderComponent
    ],
    providers: [
        AuthenticationService,
        AuthGuardService
    ]
})
export class CoreModule { }
