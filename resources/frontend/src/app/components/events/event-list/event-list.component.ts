import {Component, OnInit} from '@angular/core';
import {ButtonComponent} from "../../shared/button/button.component";
import {MusicianPreviewComponent} from "../../musicians/musician-preview/musician-preview.component";
import {JsonPipe, NgForOf, NgIf} from "@angular/common";
import {SearchBarComponent} from "../../shared/search-bar/search-bar.component";
import {EventService} from "../../../services/event.service";
import {AuthService} from "../../../services/auth.service";
import {EventPreviewComponent} from "../event-preview/event-preview.component";
import {Router} from "@angular/router";
import {PaginationComponent} from "../../shared/pagination/pagination.component";

@Component({
  selector: 'app-event-list',
  standalone: true,
  imports: [
    ButtonComponent,
    MusicianPreviewComponent,
    NgForOf,
    NgIf,
    SearchBarComponent,
    EventPreviewComponent,
    JsonPipe,
    PaginationComponent
  ],
  providers: [
    EventService
  ],
  templateUrl: './event-list.component.html',
  styleUrl: './event-list.component.css'
})
export class EventListComponent implements OnInit {
  public events: any[] = [];
  public getHistory: boolean = false;
  public getMine: boolean = false;
  public nextPageUrl: string | null = null;
  public prevPageUrl: string | null = null;

  constructor(
    public eventService: EventService,
    public authService: AuthService,
    private router: Router,
  ) {}

  public ngOnInit(): void {
    if (this.authService.getLoggedUser()) {
      if (this.router.url === "/events/history") {
        this.getHistory = true;
      }

      if (this.router.url === "/events/mine") {
        this.getMine = true;
      }
    }

    if (this.authService.getLoggedUser() && this.router.url === "/events/history") {
      this.getHistory = true;
    }

    this.getEvents("", null);
  }

  /**
   * Gets events based on the given search string
   *
   * @param { any } event
   */
  public search(event: any): void {
    this.getEvents(event, null);
  }

  /**
   * Gets events based on the given filter
   *
   * @param { any } event
   */
  public filter(event: any): void {
    this.getEvents("", event);
  }

  /**
   * Gets the events based on the given parameters
   *
   * @param { string } keyword
   * @param { any } filter
   */
  public getEvents(keyword: string, filter: any): void {
    if (this.authService.getLoggedUser() && this.getHistory) {
      this.eventService.userEventHistory(this.authService.getLoggedUser().id).subscribe({
        next: (response: any) => {
          this.events = response.data.events.data;
          this.nextPageUrl = response.data.events.next_page_url;
          this.prevPageUrl = response.data.events.prev_page_url;
        },
        error: (error) => {
          console.error('Error fetching events:', error);
        }
      })
    } else {
      this.eventService.allEvents(keyword, filter).subscribe({
        next: (response: any) => {
          this.events = response.data.events.data;

          if (this.getMine) {
            const loggedUserId: string = this.authService.getLoggedUser().id;
            this.events = this.events.filter((item: any) => {
              return item.id === loggedUserId;
            })
          }

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
