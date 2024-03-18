import {Component, OnInit} from '@angular/core';
import {AuthService} from "../../../services/auth.service";
import {NoteService} from "../../../services/note.service";
import {ButtonComponent} from "../../shared/button/button.component";
import {EventPreviewComponent} from "../../events/event-preview/event-preview.component";
import {NgForOf, NgIf} from "@angular/common";
import {SearchBarComponent} from "../../shared/search-bar/search-bar.component";
import {NotePreviewComponent} from "../note-preview/note-preview.component";
import {LoginFormComponent} from "../../authentication/login-form/login-form.component";
import {SpanComponent} from "../../shared/span/span.component";
import {Router} from "@angular/router";

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
})
export class NoteListComponent implements OnInit {
  public notes: any[] = [];
  public getMine: boolean = false;

  constructor(
    public noteService: NoteService,
    public authService: AuthService,
    private router: Router,
  ) {}

  public ngOnInit(): void {
    if (this.authService.getLukaLoggedUser()) {
      if (this.authService.getLoggedUser()) {
        if (this.router.url === "/events/mine") {
          this.getMine = true;
        }
      }

      this.noteService.allNotes().subscribe({
        next: (response: any) => {
          this.notes = response.data.notes;
        },
        error: (error) => {
          console.error('Error fetching events:', error);
        }
      });
    }
  }

  /**
   * Gets all the authenticated users notes
   */
  public getNotes(): void {
    this.noteService.allNotes().subscribe({
      next: (response: any) => {
        this.notes = response.data.notes;

        if (this.getMine) {
          const loggedUserId: string = this.authService.getLukaLoggedUser().id;
          this.notes = this.notes.filter((item: any) => {
            return item.id === loggedUserId;
          })
        }
      },
      error: (error) => {
        console.error('Error fetching events:', error);
      }
    });
  }
}
