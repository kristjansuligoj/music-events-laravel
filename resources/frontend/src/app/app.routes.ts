import { Routes } from '@angular/router';
import {MusicianListComponent} from "./components/musicians/musician-list/musician-list.component";
import {EventListComponent} from "./components/events/event-list/event-list.component";
import {SongListComponent} from "./components/songs/song-list/song-list.component";
import {NoteListComponent} from "./components/notes/note-list/note-list.component";
import {LoginComponent} from "./components/authentication/login/login.component";
import {RegisterComponent} from "./components/authentication/register/register.component";
import {ProfileComponent} from "./components/user/profile/profile.component";
import {HomepageComponent} from "./components/home/homepage/homepage.component";
import {MusicianViewComponent} from "./components/musicians/musician-view/musician-view.component";
import {MusicianFormComponent} from "./components/musicians/musician-form/musician-form.component";
import {EventFormComponent} from "./components/events/event-form/event-form.component";
import {EventViewComponent} from "./components/events/event-view/event-view.component";
import {SongFormComponent} from "./components/songs/song-form/song-form.component";
import {SongViewComponent} from "./components/songs/song-view/song-view.component";
import {NoteFormComponent} from "./components/notes/note-form/note-form.component";
import {NoteViewComponent} from "./components/notes/note-view/note-view.component";

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
    path: 'musicians/add',
    component: MusicianFormComponent,
    title: 'Musician'
  },
  {
    path: 'musicians/:id',
    component: MusicianViewComponent,
    title: 'Musician'
  },
  {
    path: 'musicians/edit/:id',
    component: MusicianFormComponent,
    title: 'Musician'
  },
  {
    path: 'events',
    component: EventListComponent,
    title: 'Events'
  },
  {
    path: 'events/add',
    component: EventFormComponent,
    title: 'event'
  },
  {
    path: 'events/:id',
    component: EventViewComponent,
    title: 'event'
  },
  {
    path: 'events/edit/:id',
    component: EventFormComponent,
    title: 'event'
  },
  {
    path: 'songs',
    component: SongListComponent,
    title: 'Songs'
  },
  {
    path: 'songs/add',
    component: SongFormComponent,
    title: 'song'
  },
  {
    path: 'songs/:id',
    component: SongViewComponent,
    title: 'song'
  },
  {
    path: 'songs/edit/:id',
    component: SongFormComponent,
    title: 'song'
  },
  {
    path: 'notes',
    component: NoteListComponent,
    title: 'Notes'
  },
  {
    path: 'notes/add',
    component: NoteFormComponent,
    title: 'note'
  },
  {
    path: 'notes/:id',
    component: NoteViewComponent,
    title: 'note'
  },
  {
    path: 'notes/edit/:id',
    component: NoteFormComponent,
    title: 'note'
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
