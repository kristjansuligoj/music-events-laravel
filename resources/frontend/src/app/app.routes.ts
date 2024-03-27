import { Routes } from '@angular/router';
import {StatisticsPageComponent} from "./components/statistics-page/statistics-page.component";
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
import {AuthGuard} from "./guards/auth.guard";

export const routes: Routes = [
  {
    path: '',
    component: HomepageComponent,
    title: 'Home',
  },
  {
    path: 'statistics',
    component: StatisticsPageComponent,
    title: 'Statistics',
  },
  {
    path: 'musicians',
    children: [
      {
        path: '',
        component: MusicianListComponent,
        title: 'Musicians',
      },
      {
        path: 'add',
        component: MusicianFormComponent,
        title: 'Add musician',
        canActivate: [AuthGuard],
      },
      {
        path: 'mine',
        component: MusicianListComponent,
        title: 'My musicians'
      },
      {
        path: ':id',
        component: MusicianViewComponent,
        title: 'Musician view'
      },
      {
        path: 'edit/:id',
        component: MusicianFormComponent,
        title: 'Edit musician',
        canActivate: [AuthGuard],
      },
    ]
  },
  {
    path: 'events',
    children: [
      {
        path: '',
        component: EventListComponent,
        title: 'Events',
      },
      {
        path: 'add',
        component: EventFormComponent,
        title: 'Add event',
        canActivate: [AuthGuard],
      },
      {
        path: 'history',
        component: EventListComponent,
        title: 'Event history'
      },
      {
        path: 'mine',
        component: EventListComponent,
        title: 'My events'
      },
      {
        path: ':id',
        component: EventViewComponent,
        title: 'Event view'
      },
      {
        path: 'edit/:id',
        component: EventFormComponent,
        title: 'Edit event',
        canActivate: [AuthGuard],
      },
    ]
  },
  {
    path: 'songs',
    children: [
      {
        path: '',
        component: SongListComponent,
        title: 'Songs',
      },
      {
        path: 'add',
        component: SongFormComponent,
        title: 'Add song',
        canActivate: [AuthGuard],
      },
      {
        path: 'mine',
        component: SongListComponent,
        title: 'My songs'
      },
      {
        path: ':id',
        component: SongViewComponent,
        title: 'Song view'
      },
      {
        path: 'edit/:id',
        component: SongFormComponent,
        title: 'Edit song',
        canActivate: [AuthGuard],
      },
    ],
  },
  {
    path: 'notes',
    children: [
      {
        path: '',
        component: NoteListComponent,
        title: 'Notes',
      },
      {
        path: 'add',
        component: NoteFormComponent,
        title: 'Add note',
        canActivate: [AuthGuard],
      },
      {
        path: 'mine',
        component: NoteListComponent,
        title: 'My notes'
      },
      {
        path: ':id',
        component: NoteViewComponent,
        title: 'Note view',
        canActivate: [AuthGuard],
      },
      {
        path: 'edit/:id',
        component: NoteFormComponent,
        title: 'Edit note',
        canActivate: [AuthGuard],
      },
    ],
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
    title: 'Profile',
    canActivate: [AuthGuard],
  },
];
