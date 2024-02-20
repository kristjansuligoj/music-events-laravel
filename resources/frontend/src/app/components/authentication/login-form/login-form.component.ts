import {Component, EventEmitter, Input, Output} from '@angular/core';
import {FormBuilder, FormControl, FormGroup, ReactiveFormsModule, Validators} from '@angular/forms';
import { UserService } from '../../../services/user.service';
import {NgIf} from "@angular/common";
import {AuthService} from "../../../services/auth.service";
import {Router} from '@angular/router';
import {TextInputComponent} from "../../shared/text-input/text-input.component";
import {HttpErrorResponse} from "@angular/common/http";
import {ButtonComponent} from "../../shared/button/button.component";
import {SubmitButtonComponent} from "../../shared/submit-button/submit-button.component";

@Component({
  selector: 'app-login-form',
  templateUrl: './login-form.component.html',
  standalone: true,
  imports: [
    ReactiveFormsModule,
    NgIf,
    TextInputComponent,
    ButtonComponent,
    SubmitButtonComponent
  ],
  providers: [
    UserService,
  ],
  styleUrls: ['./login-form.component.css']
})
export class LoginFormComponent {
  // This makes the component log in on Lukas' app
  @Input() lukaApp: boolean = false;
  @Output() authenticated: EventEmitter<boolean> = new EventEmitter();

  public errors: string = "";

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

      this.userService.login({email: email, password: password}, this.lukaApp)
        .subscribe({
          next: (response: any): void => {
            if (response.token || response.success) {
              if (this.lukaApp) {
                this.authService.setLukaLoggedUser(response.user);
                this.authService.setLukaAuthToken(response.token);
                this.authenticated.emit(true);
              } else {
                this.authService.setLoggedUser(response.data.user);
                this.authService.setAuthToken(response.data.token);
                this.router.navigate(['/']).then(r => {});
              }
            } else {
              this.errors = response.message;
            }
          },
          error: (response: HttpErrorResponse): void => { this.errors = response.message; console.log(response)},
        })
    }
  }
}