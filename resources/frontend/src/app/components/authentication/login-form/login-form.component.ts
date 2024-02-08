import { Component } from '@angular/core';
import {FormBuilder, FormControl, FormGroup, ReactiveFormsModule, Validators} from '@angular/forms';
import { UserService } from '../../../services/user.service';
import {NgIf} from "@angular/common";
import {AuthService} from "../../../services/auth.service";
import {Router} from '@angular/router';
import {InputFormComponent} from "../../shared/input-form/input-form.component";

@Component({
  selector: 'app-login-form',
  templateUrl: './login-form.component.html',
  standalone: true,
  imports: [
    ReactiveFormsModule,
    NgIf,
    InputFormComponent
  ],
  providers: [
    UserService,
    AuthService
  ],
  styleUrls: ['./login-form.component.css']
})
export class LoginFormComponent {
  public loginForm: FormGroup = new FormGroup({
    email: new FormControl('', [Validators.required, Validators.email, Validators.maxLength(255)]),
    password: new FormControl('', [Validators.required, Validators.minLength(8)]),
  });
  constructor(
    private fb: FormBuilder,
    private router: Router,
    private userService: UserService,
    private authService: AuthService,
  ) { }

  onSubmit(): void {
    if (this.loginForm.valid) {
      const email = this.loginForm.value.email;
      const password = this.loginForm.value.password;
      this.userService.login({email: email, password: password})
        .subscribe((response: any) => {
          this.authService.setAuthToken(response.token);
          this.router.navigate(['/']).then(r => {});
      })
    }
  }
}
