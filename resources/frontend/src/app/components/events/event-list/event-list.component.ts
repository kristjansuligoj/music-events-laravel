import {Component, OnInit} from '@angular/core';
import {ButtonComponent} from "../../shared/button/button.component";
import {MusicianPreviewComponent} from "../../musicians/musician-preview/musician-preview.component";
import {NgForOf, NgIf} from "@angular/common";
import {SearchBarComponent} from "../../shared/search-bar/search-bar.component";
import {EventService} from "../../../services/event.service";
import {AuthService} from "../../../services/auth.service";
import {EventPreviewComponent} from "../event-preview/event-preview.component";

@Component({
  selector: 'app-event-list',
  standalone: true,
  imports: [
    ButtonComponent,
    MusicianPreviewComponent,
    NgForOf,
    NgIf,
    SearchBarComponent,
    EventPreviewComponent
  ],
  providers: [
    EventService
  ],
  templateUrl: './event-list.component.html',
  styleUrl: './event-list.component.css'
})
export class EventListComponent implements OnInit {
  events: any[] = [];
  nextPageUrl: string | null = null;
  prevPageUrl: string | null = null;

  constructor(
    public eventService: EventService,
    public authService: AuthService,
  ) {}
  public ngOnInit() {
    this.getEvents("", null);
  }

  public search(event: any) {
    this.getEvents(event, null);
  }

  public filter(event: any) {
    this.getEvents("", event);
  }

  public getEvents(keyword: string, filter: any) {
    this.eventService.allEvents(keyword, filter).subscribe({
      next: (response: any) => {
        this.events = response.data.events.data;
        this.nextPageUrl = response.data.events.next_page_url;
        this.prevPageUrl = response.data.events.prev_page_url;
      },
      error: (error) => {
        console.error('Error fetching events:', error);
      }
    });
  }

  goToNextPage(): void {
    if (this.nextPageUrl) {
      this.eventService.paginatedEvents(this.nextPageUrl).subscribe({
        next: (response: any) => {
          this.events = response.data.events.data;
          this.nextPageUrl = response.data.events.next_page_url;
          this.prevPageUrl = response.data.events.prev_page_url;
        },
        error: (error) => {
          console.error('Error fetching events:', error);
        }
      });
    }
  }

  goToPrevPage(): void {
    if (this.prevPageUrl) {
      this.eventService.paginatedEvents(this.prevPageUrl).subscribe({
        next: (response: any) => {
          this.events = response.data.events.data;
          this.nextPageUrl = response.data.events.next_page_url;
          this.prevPageUrl = response.data.events.prev_page_url;
        },
        error: (error) => {
          console.error('Error fetching events:', error);
        }
      });
    }
  }
}
