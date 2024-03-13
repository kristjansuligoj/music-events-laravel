import { Component } from '@angular/core';
import {RouterLink, RouterLinkActive} from "@angular/router";
import {ButtonComponent} from "../../shared/button/button.component";
import {JsonPipe, NgIf} from "@angular/common";
import {AuthService} from "../../../services/auth.service";
import {UserService} from "../../../services/user.service";

@Component({
  selector: 'app-navigation-bar',
  standalone: true,
  imports: [
    RouterLink,
    ButtonComponent,
    NgIf,
    RouterLinkActive,
    JsonPipe
  ],
  providers: [
    UserService,
  ],
  templateUrl: './navigation-bar.component.html',
})
export class NavigationBarComponent {
  public loggedIn: boolean = true;

  constructor(
    public authService: AuthService,
    public userService: UserService,
  ) {}

  /**
   * Logs the user out
   */
  public logout(): void {
    this.userService.logout();
    this.authService.setAuthToken(null);
    this.authService.setLoggedUser(null);
    this.loggedIn = false;
  }
}
