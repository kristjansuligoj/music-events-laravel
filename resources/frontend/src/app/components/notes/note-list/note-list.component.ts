import { Component } from '@angular/core';
import {EventService} from "../../../services/event.service";
import {AuthService} from "../../../services/auth.service";
import {NoteService} from "../../../services/note.service";
import {ButtonComponent} from "../../shared/button/button.component";
import {EventPreviewComponent} from "../../events/event-preview/event-preview.component";
import {NgForOf, NgIf} from "@angular/common";
import {SearchBarComponent} from "../../shared/search-bar/search-bar.component";
import {NotePreviewComponent} from "../note-preview/note-preview.component";
import {LoginFormComponent} from "../../authentication/login-form/login-form.component";
import {SpanComponent} from "../../shared/span/span.component";

@Component({
  selector: 'app-note-list',
  standalone: true,
  imports: [
    ButtonComponent,
    EventPreviewComponent,
    NgForOf,
    NgIf,
    SearchBarComponent,
    NotePreviewComponent,
    LoginFormComponent,
    SpanComponent
  ],
  providers: [
    NoteService,
  ],
  templateUrl: './note-list.component.html',
  styleUrl: './note-list.component.css'
})
export class NoteListComponent {
  notes: any[] = [];
  nextPageUrl: string | null = null;
  prevPageUrl: string | null = null;

  constructor(
    public noteService: NoteService,
    public authService: AuthService,
  ) {}
  public ngOnInit() {
    if (this.authService.getLukaLoggedUser()) {
      this.noteService.allNotes(this.authService.getLukaLoggedUser().id).subscribe({
        next: (response: any) => {
          this.notes = response.data.notes;
          this.nextPageUrl = response.data.notes.next_page_url;
          this.prevPageUrl = response.data.notes.prev_page_url;
        },
        error: (error) => {
          console.error('Error fetching events:', error);
        }
      });
    }
  }

  public loadNotes() {
    this.noteService.allNotes(this.authService.getLukaLoggedUser().id).subscribe({
      next: (response: any) => {
        this.notes = response.data.notes;
        this.nextPageUrl = response.data.notes.next_page_url;
        this.prevPageUrl = response.data.notes.prev_page_url;
      },
      error: (error) => {
        console.error('Error fetching events:', error);
      }
    });
  }

  goToNextPage(): void {
    if (this.nextPageUrl) {
      this.noteService.paginatedNotes(this.nextPageUrl).subscribe({
        next: (response: any) => {
          this.notes = response.data.notes.data;
          this.nextPageUrl = response.data.notes.next_page_url;
          this.prevPageUrl = response.data.notes.prev_page_url;
        },
        error: (error) => {
          console.error('Error fetching events:', error);
        }
      });
    }
  }

  goToPrevPage(): void {
    if (this.prevPageUrl) {
      this.noteService.paginatedNotes(this.prevPageUrl).subscribe({
        next: (response: any) => {
          this.notes = response.data.notes.data;
          this.nextPageUrl = response.data.notes.next_page_url;
          this.prevPageUrl = response.data.notes.prev_page_url;
        },
        error: (error) => {
          console.error('Error fetching events:', error);
        }
      });
    }
  }
}
