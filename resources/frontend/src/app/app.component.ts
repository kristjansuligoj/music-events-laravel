import { Component } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import {HttpClientModule} from "@angular/common/http";
import {NavigationBarComponent} from "./components/layout/navigation-bar/navigation-bar.component";

@Component({
  selector: 'app-root',
  standalone: true,
  imports: [
    RouterOutlet,
    HttpClientModule,
    NavigationBarComponent,
  ],
  templateUrl: './app.component.html',
  styleUrl: './app.component.css'
})
export class AppComponent {
  title = 'frontend';
}
