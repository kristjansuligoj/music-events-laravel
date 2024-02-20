import {Component, OnInit} from '@angular/core';
import {EventService} from "../../../services/event.service";
import {AuthService} from "../../../services/auth.service";
import {ButtonComponent} from "../../shared/button/button.component";

@Component({
  selector: 'app-profile',
  standalone: true,
  imports: [
    ButtonComponent
  ],
  providers: [
    EventService,
  ],
  templateUrl: './profile.component.html',
  styleUrl: './profile.component.css'
})
export class ProfileComponent implements OnInit {
  public eventHistory = {};

  constructor(
    public eventService: EventService,
    public authService: AuthService,
  ) {}

  public ngOnInit() {
    this.eventService.userEventHistory(this.authService.getLoggedUser().id).subscribe({
      next: (response: any) => {
        console.log(response);
      }
    })
  }

  public viewHistory() {

  }
}
