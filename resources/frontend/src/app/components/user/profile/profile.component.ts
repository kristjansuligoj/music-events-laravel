import {Component, OnInit} from '@angular/core';
import {EventService} from "../../../services/event.service";
import {AuthService} from "../../../services/auth.service";
import {ButtonComponent} from "../../shared/button/button.component";
import {SpanComponent} from "../../shared/span/span.component";

@Component({
  selector: 'app-profile',
  standalone: true,
  imports: [
    ButtonComponent,
    SpanComponent
  ],
  providers: [
    EventService,
  ],
  templateUrl: './profile.component.html',
})
export class ProfileComponent implements OnInit {
  public loggedUser: any = {};

  constructor(
    public eventService: EventService,
    public authService: AuthService,
  ) {
    this.loggedUser = authService.getLoggedUser();
  }

  public ngOnInit(): void {
    this.eventService.userEventHistory(this.authService.getLoggedUser().id).subscribe({
      next: (response: any) => {
        console.log(response);
      }
    })
  }
}
