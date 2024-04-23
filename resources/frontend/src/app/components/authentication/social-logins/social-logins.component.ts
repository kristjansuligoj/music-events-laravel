import { Component } from '@angular/core';
import {
  FacebookLoginProvider,
  GoogleSigninButtonModule,
  MicrosoftLoginProvider,
  SocialAuthService
} from "@abacritt/angularx-social-login";

@Component({
  selector: 'app-social-logins',
  standalone: true,
  imports: [
    GoogleSigninButtonModule
  ],
  styleUrl: './social-logins.component.css',
  templateUrl: './social-logins.component.html',
})
export class SocialLoginsComponent {
  constructor (
    private socialAuthService: SocialAuthService,
  ) {}

  /**
   * Signs in with Facebook
   */
  signInWithFB(): void {
    this.socialAuthService.signIn(FacebookLoginProvider.PROVIDER_ID);
  }

  /**
   * Signs in with Microsoft
   */
  signInWithMicrosoft(): void {
    this.socialAuthService.signIn(MicrosoftLoginProvider.PROVIDER_ID);
  }
}
