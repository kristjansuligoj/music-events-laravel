import {Component, Input} from '@angular/core';
import {MusicianPreviewComponent} from "../../musicians/musician-preview/musician-preview.component";
import {NgForOf, NgIf} from "@angular/common";
import {EventPreviewComponent} from "../../events/event-preview/event-preview.component";
import {SongPreviewComponent} from "../../songs/song-preview/song-preview.component";
import {SongService} from "../../../services/song.service";
import {EventService} from "../../../services/event.service";
import {MusicianService} from "../../../services/musician.service";

@Component({
  selector: 'app-pagination',
  standalone: true,
  imports: [
    MusicianPreviewComponent,
    NgForOf,
    NgIf,
    EventPreviewComponent,
    SongPreviewComponent
  ],
  providers: [
    MusicianService,
    EventService,
    SongService,
  ],
  templateUrl: './pagination.component.html',
  styleUrl: './pagination.component.css'
})
export class PaginationComponent {
  public constructor(
    public musicianService: MusicianService,
    public eventService: EventService,
    public songService: SongService,
  ) {}

  @Input() elements: any;
  @Input() name: string = "";
  @Input() nextPageUrl: string | null = null;
  @Input() prevPageUrl: string | null = null;

  /**
   * Uses pagination links to show the next page of musicians
   */
  goToNextPage(): void {
    if (this.nextPageUrl) {
      switch(this.name) {
        case 'musician':
          this.musicianService.paginatedMusicians(this.nextPageUrl).subscribe({
            next: (response: any) => {
              this.elements = response.data.musicians.data;
              this.nextPageUrl = response.data.musicians.next_page_url;
              this.prevPageUrl = response.data.musicians.prev_page_url;
            },
            error: (error) => {
              console.error('Error fetching musicians:', error);
            }
          });
          break;
        case 'event':
          this.eventService.paginatedEvents(this.nextPageUrl).subscribe({
            next: (response: any) => {
              this.elements = response.data.events.data;
              this.nextPageUrl = response.data.events.next_page_url;
              this.prevPageUrl = response.data.events.prev_page_url;
            },
            error: (error) => {
              console.error('Error fetching events:', error);
            }
          });
          break;
        case 'song':
          this.songService.paginatedSongs(this.nextPageUrl).subscribe({
            next: (response: any) => {
              this.elements = response.data.songs.data;
              this.nextPageUrl = response.data.songs.next_page_url;
              this.prevPageUrl = response.data.songs.prev_page_url;
            },
            error: (error) => {
              console.error('Error fetching songs:', error);
            }
          });
          break;
        default:
          console.log("Name is not valid in pagination component.");
          break;
      }
    }
  }

  /**
   * Uses pagination links to show the previous page of musicians
   */
  goToPrevPage(): void {
    if (this.prevPageUrl) {
      switch(this.name) {
        case 'musician':
          this.musicianService.paginatedMusicians(this.prevPageUrl).subscribe({
            next: (response: any) => {
              this.elements = response.data.musicians.data;
              this.nextPageUrl = response.data.musicians.next_page_url;
              this.prevPageUrl = response.data.musicians.prev_page_url;
            },
            error: (error) => {
              console.error('Error fetching musicians:', error);
            }
          });
          break;
        case 'event':
          this.eventService.paginatedEvents(this.prevPageUrl).subscribe({
            next: (response: any) => {
              this.elements = response.data.events.data;
              this.nextPageUrl = response.data.events.next_page_url;
              this.prevPageUrl = response.data.events.prev_page_url;
            },
            error: (error) => {
              console.error('Error fetching events:', error);
            }
          });
          break;
        case 'song':
          this.songService.paginatedSongs(this.prevPageUrl).subscribe({
            next: (response: any) => {
              this.elements = response.data.songs.data;
              this.nextPageUrl = response.data.songs.next_page_url;
              this.prevPageUrl = response.data.songs.prev_page_url;
            },
            error: (error) => {
              console.error('Error fetching songs:', error);
            }
          });
          break;
        default:
          console.log("Name is not valid in pagination component.");
          break;
      }
    }
  }
}
