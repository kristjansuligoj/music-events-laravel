import {Component, OnInit} from '@angular/core';
import {ButtonComponent} from "../../shared/button/button.component";
import {GoogleMap, MapMarker} from "@angular/google-maps";
import {DatePipe, JsonPipe, Location, NgIf} from "@angular/common";
import {SpanComponent} from "../../shared/span/span.component";
import {UnorderedListComponent} from "../../shared/unordered-list/unordered-list.component";
import {AuthService} from "../../../services/auth.service";
import {Router} from "@angular/router";
import {NoteService} from "../../../services/note.service";

@Component({
  selector: 'app-note-view',
  standalone: true,
  imports: [
    ButtonComponent,
    GoogleMap,
    MapMarker,
    NgIf,
    SpanComponent,
    UnorderedListComponent,
    DatePipe,
    JsonPipe,
  ],
  providers: [
    NoteService,
  ],
  templateUrl: './note-view.component.html',
  styleUrl: './note-view.component.css'
})
export class NoteViewComponent implements OnInit{
  public note: any = {};

  constructor(
    public noteService: NoteService,
    public authService: AuthService,
    private location: Location,
    private router: Router,
  ) {}
  public ngOnInit() {
    const id: string = this.location.path().split('/')[2];
    this.noteService.getNoteById(id).subscribe({
      next: (response: any) => {
        this.note = response.data.note;
      },
      error: (response: any) => {
        console.log("not good");
      }
    })
  }

  public removeNote(id: string) {
    this.noteService.removeNote(id).subscribe({
      next: (response: any) => {
        this.router.navigate(['/notes']).then(r => {});
      },
      error: (response: any) => {
        console.log("not good");
      }
    })
  }
}
