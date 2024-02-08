import { Routes } from '@angular/router';
import {MusicianListComponent} from "./components/musicians/musician-list/musician-list.component";
import {EventListComponent} from "./components/events/event-list/event-list.component";
import {SongListComponent} from "./components/songs/song-list/song-list.component";
import {NoteListComponent} from "./components/notes/note-list/note-list.component";
import {LoginComponent} from "./components/authentication/login/login.component";
import {RegisterComponent} from "./components/authentication/register/register.component";
import {ProfileComponent} from "./components/user/profile/profile.component";
import {HomepageComponent} from "./components/home/homepage/homepage.component";

export const routes: Routes = [
  {
    path: '',
    component: HomepageComponent,
    title: 'Home'
  },
  {
    path: 'musicians',
    component: MusicianListComponent,
    title: 'Musicians'
  },
  {
    path: 'events',
    component: EventListComponent,
    title: 'Events'
  },
  {
    path: 'songs',
    component: SongListComponent,
    title: 'Songs'
  },
  {
    path: 'notes',
    component: NoteListComponent,
    title: 'Notes'
  },
  {
    path: 'login',
    component: LoginComponent,
    title: 'Login'
  },
  {
    path: 'register',
    component: RegisterComponent,
    title: 'Register'
  },
  {
    path: 'profile',
    component: ProfileComponent,
    title: 'Profile'
  },
];
