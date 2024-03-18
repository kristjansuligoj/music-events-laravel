import {Component} from '@angular/core';
import {NgClass, NgForOf, NgIf} from "@angular/common";
import {FormControl, FormGroup, ReactiveFormsModule, Validators} from "@angular/forms";
import {Router} from "@angular/router";
import {UserService} from "../../../services/user.service";
import {AuthService} from "../../../services/auth.service";
import {HttpErrorResponse} from "@angular/common/http";
import {TextInputComponent} from "../../shared/text-input/text-input.component";
import {passwordMatchValidator} from "../../../validators/passwordMatchValidator";
import {SubmitButtonComponent} from "../../shared/submit-button/submit-button.component";

@Component({
  selector: 'app-register-form',
  standalone: true,
  imports: [
    NgIf,
    ReactiveFormsModule,
    NgForOf,
    TextInputComponent,
    NgClass,
    SubmitButtonComponent,
  ],
  providers: [
    UserService,
    AuthService,
  ],
  templateUrl: './register-form.component.html',
})
export class RegisterFormComponent {
  public registerForm: FormGroup = new FormGroup({
    username: new FormControl('', [Validators.required, Validators.maxLength(255)]),
    email: new FormControl('', [Validators.required, Validators.email, Validators.maxLength(255)]),
    password: new FormControl('', [Validators.required, Validators.minLength(8)]),
    confirmPassword: new FormControl('', [Validators.required, Validators.minLength(8)]),
  }, { validators: passwordMatchValidator })

  public errors: any = {};

  constructor(
    private router: Router,
    private userService: UserService,
  ) { }

  /**
   * Checks if 'passwordMismatch' error exists, and returns it, so user can see the error
   *
   * @return any
   */
  public getAdditionalErrors(): any {
    if (this.registerForm.hasError('passwordMismatch') && !this.registerForm.controls["password"].pristine) {
      return { confirmPassword: ['Passwords do not match'] };
    } else return this.errors;
  }

  onSubmit(): void {
    if (this.registerForm.valid) {
      const username = this.registerForm.value.username;
      const email = this.registerForm.value.email;
      const password = this.registerForm.value.password;
      const passwordConfirmation = this.registerForm.value.confirmPassword;

      this.userService.register({
        username: username,
        email: email,
        password: password,
        password_confirmation: passwordConfirmation,
      }).subscribe({
          next: (): void => { this.router.navigate(['/login']); },
          error: (response: HttpErrorResponse): void => {
            this.errors = response.error.errors;
          },
        });
    }
  }
}
