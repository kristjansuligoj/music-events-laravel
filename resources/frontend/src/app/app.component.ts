import { Component } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import {HttpClientModule} from "@angular/common/http";
import {NavigationBarComponent} from "./components/layout/navigation-bar/navigation-bar.component";
import {GoogleMapsModule} from "@angular/google-maps";
import {GoogleLoginProvider, SocialLoginModule} from "@abacritt/angularx-social-login";

@Component({
  selector: 'app-root',
  standalone: true,
  imports: [
    RouterOutlet,
    HttpClientModule,
    NavigationBarComponent,
    GoogleMapsModule,
    SocialLoginModule,
  ],
  templateUrl: './app.component.html',
  styleUrl: './app.component.css'
})
export class AppComponent {
  public title: string = 'frontend';
}
