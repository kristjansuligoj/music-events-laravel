import { Component } from '@angular/core';
import {RouterLink, RouterLinkActive} from "@angular/router";
import {ButtonComponent} from "../../shared/button/button.component";
import {JsonPipe, NgIf} from "@angular/common";
import {AuthService} from "../../../services/auth.service";

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
  templateUrl: './navigation-bar.component.html',
  styleUrl: './navigation-bar.component.css'
})
export class NavigationBarComponent {
  loggedIn: boolean = true;

  constructor(
    public authService: AuthService,
  ) {}

  /**
   * Logs the user out
   */
  public logout(): void {
    this.authService.setAuthToken(null);
    this.loggedIn = false;
  }
}
