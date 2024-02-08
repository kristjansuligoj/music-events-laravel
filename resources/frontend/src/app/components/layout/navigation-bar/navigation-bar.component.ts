import { Component } from '@angular/core';
import {RouterLink} from "@angular/router";
import {ButtonComponent} from "../../shared/button/button.component";
import {NgIf} from "@angular/common";

@Component({
  selector: 'app-navigation-bar',
  standalone: true,
  imports: [
    RouterLink,
    ButtonComponent,
    NgIf
  ],
  templateUrl: './navigation-bar.component.html',
  styleUrl: './navigation-bar.component.css'
})
export class NavigationBarComponent {
  loggedIn: boolean = true;

  /**
   * Logs the user out
   */
  public logout(): void {
    console.log("user is not logged out");
    this.loggedIn = false;
  }
}
