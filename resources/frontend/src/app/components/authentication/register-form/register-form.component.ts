import {Component, TemplateRef, ViewChild} from '@angular/core';
import {NgForOf, NgIf} from "@angular/common";
import {FormBuilder, FormControl, FormGroup, ReactiveFormsModule, Validators} from "@angular/forms";
import {Router} from "@angular/router";
import {UserService} from "../../../services/user.service";
import {AuthService} from "../../../services/auth.service";
import {HttpErrorResponse} from "@angular/common/http";
import {TextInputComponent} from "../../shared/text-input/text-input.component";
import {passwordMatchValidator} from "../../../validators/passwordMatchValidator";

@Component({
  selector: 'app-register-form',
  standalone: true,
  imports: [
    NgIf,
    ReactiveFormsModule,
    NgForOf,
    TextInputComponent,
  ],
  providers: [
    UserService,
    AuthService,
  ],
  templateUrl: './register-form.component.html',
  styleUrl: './register-form.component.css'
})
export class RegisterFormComponent {
  public registerForm: FormGroup = new FormGroup({
    name: new FormControl('', [Validators.required, Validators.maxLength(255)]),
    email: new FormControl('', [Validators.required, Validators.email, Validators.maxLength(255)]),
    password: new FormControl('', [Validators.required, Validators.minLength(8)]),
    confirmPassword: new FormControl('', [Validators.required, Validators.minLength(8)]),
  }, { validators: passwordMatchValidator })

  public errors: any = {};

  constructor(
    private router: Router,
    private userService: UserService,
  ) { }

  public getAdditionalErrors() {
    if (this.registerForm.hasError('passwordMismatch')) {
      return { confirmPassword: ['Passwords do not match'] };
    } else return this.errors;
  }

  onSubmit(): void {
    if (this.registerForm.valid) {
      const name = this.registerForm.value.name;
      const email = this.registerForm.value.email;
      const password = this.registerForm.value.password;
      this.userService.register({name: name, email: email, password: password})
        .subscribe({
          next: (): void => { this.router.navigate(['/login']); },
          error: (response: HttpErrorResponse): void => {
            this.errors = response.error.errors;
          },
        });
    }
  }
}
