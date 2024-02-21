import {Component, OnInit} from '@angular/core';
import {ButtonComponent} from "../../shared/button/button.component";
import {JsonPipe, Location, NgIf, NgOptimizedImage} from "@angular/common";
import {UnorderedListComponent} from "../../shared/unordered-list/unordered-list.component";
import {EventService} from "../../../services/event.service";
import {AuthService} from "../../../services/auth.service";
import {Router} from "@angular/router";
import {SpanComponent} from "../../shared/span/span.component";
import {GoogleMap, MapMarker} from "@angular/google-maps";
import {GoogleAPIService} from "../../../services/google-api.service";
import {formatDate, isEventInFuture} from "../../../helpers/functions";

@Component({
  selector: 'app-event-view',
  standalone: true,
  imports: [
    ButtonComponent,
    NgIf,
    NgOptimizedImage,
    UnorderedListComponent,
    JsonPipe,
    SpanComponent,
    GoogleMap,
    MapMarker
  ],
  providers: [
    EventService,
    GoogleAPIService,
  ],
  templateUrl: './event-view.component.html',
  styleUrl: './event-view.component.css'
})
export class EventViewComponent implements OnInit {
  public futureEvent: boolean = false;
  public attending: boolean = false;
  public event: any = {};
  public coordinates: any = {};
  public mapOptions: any = {
    center: { // Default values show center of Maribor
      lat: 46.23469202161742,
      lng: 15.27740625050234,
    },
    zoom: 14
  };

  constructor(
    public eventService: EventService,
    public authService: AuthService,
    public googleApiService: GoogleAPIService,
    private location: Location,
    private router: Router,
  ) {}

  public ngOnInit(): void {
    const id: string = this.location.path().split('/')[2];
    this.eventService.getEventById(id).subscribe({
      next: (response: any) => {
        this.event = response.data.event;
        this.futureEvent = isEventInFuture(formatDate(this.event.date));

        if (this.authService.getLoggedUser()) {
          const index = this.event.participants.findIndex(
            (participant: any) => participant.id === this.authService.getLoggedUser().id);

          if (index !== -1) {
            this.attending = true;
          }
        }

        this.googleApiService.getCoordinates(this.event.address).subscribe({
          next: (response: any) => {
            if (response.status == "OK") {
              this.coordinates = response.results[0].geometry.location;
              this.mapOptions = {
                ...this.mapOptions,
                center: this.coordinates
              };
            } else {
              this.coordinates = {
                lat: 46.23469202161742,
                lng: 15.27740625050234,
              }
            }
          },
          error: (response: any) => {
            console.log(response);
          }
        })
      },
      error: (response: any) => {
        console.log("not good");
      }
    })
  }

  /**
   * Add authorized user as attendee to the given event
   *
   * @param { string } eventId
   */
  public attendEvent(eventId: string): void {
    this.attending = !this.attending;

    if (this.attending) {
      this.eventService.addUserToEvent(eventId, this.authService.getLoggedUser().id).subscribe({
        next: (response: any) => {
          this.event.participants.push(response.data.user);
        }
      })
    } else {
      this.eventService.removeUserFromEvent(eventId, this.authService.getLoggedUser().id).subscribe({
        next: (response: any) => {
          const index = this.event.participants.findIndex(
            (participant: any) => participant.id === response.data.user.id);

          if (index !== -1) {
            this.event.participants.splice(index, 1);
          }
        }
      })
    }
  }

  /**
   * Removes the given event
   *
   * @param { string } id
   */
  public removeEvent(id: string): void {
    this.eventService.removeEvent(id).subscribe({
      next: (response: any) => {
        this.router.navigate(['/events']).then(r => {});
      },
      error: (response: any) => {
        console.log("not good");
      }
    })
  }
}
