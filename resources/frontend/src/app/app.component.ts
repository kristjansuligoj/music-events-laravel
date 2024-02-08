import { Component } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import { MusicianListComponent } from "./components/musicians/musician-list/musician-list.component";
import { NoteListComponent } from "./components/notes/note-list/note-list.component";
import { SongListComponent } from "./components/songs/song-list/song-list.component";
import { EventListComponent } from "./components/events/event-list/event-list.component";
import { RouterModule } from '@angular/router';
import {NavigationBarComponent} from "./components/layout/navigation-bar/navigation-bar.component";
import {LoginComponent} from "./components/authentication/login/login.component";
import {RegisterComponent} from "./components/authentication/register/register.component";
import {ProfileComponent} from "./components/user/profile/profile.component";
import {HomepageComponent} from "./components/home/homepage/homepage.component";

@Component({
  selector: 'app-root',
  standalone: true,
  imports: [
    RouterOutlet,
    MusicianListComponent,
    SongListComponent,
    EventListComponent,
    NoteListComponent,
    RouterModule,
    NavigationBarComponent,
    LoginComponent,
    RegisterComponent,
    ProfileComponent,
    HomepageComponent,
  ],
  templateUrl: './app.component.html',
  styleUrl: './app.component.css'
})
export class AppComponent {
  title = 'frontend';
}
