import { Component } from '@angular/core';
import {LoginFormComponent} from "../login-form/login-form.component";

@Component({
  selector: 'app-login',
  standalone: true,
  templateUrl: './login.component.html',
  imports: [
    LoginFormComponent,
  ],
  styleUrl: './login.component.css'
})
export class LoginComponent {
}
