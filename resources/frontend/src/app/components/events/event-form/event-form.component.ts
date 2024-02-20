import {Component, OnInit} from '@angular/core';
import {CheckboxesComponent} from "../../shared/checkboxes/checkboxes.component";
import {ImageInputComponent} from "../../shared/image-input/image-input.component";
import {JsonPipe, NgIf} from "@angular/common";
import {FormControl, FormGroup, ReactiveFormsModule, Validators} from "@angular/forms";
import {TextInputComponent} from "../../shared/text-input/text-input.component";
import {ActivatedRoute, Router} from "@angular/router";
import {EventService} from "../../../services/event.service";
import {HttpErrorResponse} from "@angular/common/http";
import {TextareaInputComponent} from "../../shared/textarea-input/textarea-input.component";
import {DropdownComponent} from "../../shared/dropdown/dropdown.component";
import {formatDate} from '../../../helpers/functions';
import {SubmitButtonComponent} from "../../shared/submit-button/submit-button.component";
import {MusicianService} from "../../../services/musician.service";
import {dateRelativeToTodayValidator} from "../../../validators/dateRelativeToTodayValidator";

@Component({
  selector: 'app-event-form',
  standalone: true,
  imports: [
    CheckboxesComponent,
    ImageInputComponent,
    JsonPipe,
    ReactiveFormsModule,
    TextInputComponent,
    TextareaInputComponent,
    DropdownComponent,
    SubmitButtonComponent,
    NgIf,
  ],
  providers:[
    EventService,
    MusicianService,
  ],
  templateUrl: './event-form.component.html',
  styleUrl: './event-form.component.css'
})
export class EventFormComponent implements OnInit {
  public errors: any = {};
  public editing: boolean = false;
  public event: any = {};
  public musicians: any = {};
  public formLoaded: boolean = false;

  constructor(
    public eventService: EventService,
    public musicianService: MusicianService,
    private router: Router,
    private route: ActivatedRoute,
  ) {}

  public editForm: FormGroup = new FormGroup({
    date: new FormControl('', [Validators.required, dateRelativeToTodayValidator('after')]),
    time: new FormControl('', [Validators.required]),
    name: new FormControl('', [Validators.required]),
    address: new FormControl('', [Validators.required]),
    ticketPrice: new FormControl('', [Validators.required, Validators.min(10), Validators.max(300)]),
    description: new FormControl('', [Validators.required]),
    musician: new FormControl('', [Validators.required]),
  });

  public ngOnInit() {
    this.getDefaultValues()
  }

  public getDefaultValues() {
    this.musicianService.allMusiciansUnpaginated().subscribe({
      next: (response: any) => {
        // Maps the object to correct property names for dropdown component
        this.musicians = response.data.musicians.map((item: any) => ({
          key: item.id,
          value: item.name,
        }));

        console.log(this.musicians);

        this.route.params.subscribe(params => {
          const id = params['id'];

          if (id) {
            this.editing = true;
            this.eventService.getEventById(id).subscribe({
              next: (response: any ) => {
                this.event = response.data.event;

                this.editForm.patchValue({
                  date: formatDate(this.event.date),
                  time: this.event.time,
                  name: this.event.name,
                  address: this.event.address,
                  ticketPrice: this.event.ticketPrice,
                  description: this.event.description,
                  musician: this.event.musicians[0].id,
                })

                this.formLoaded = true;
              },
              error: (response: HttpErrorResponse): void => {
                this.router.navigate(['/events']).then(r => {});
              },
            })
          } else {
            this.formLoaded = true;
          }
        })
      }
    });
  }

  public onSubmit() {
    const eventData: any = {
      date: this.editForm.value.date,
      time: this.editForm.value.time,
      name: this.editForm.value.name,
      address: this.editForm.value.address,
      ticketPrice: this.editForm.value.ticketPrice,
      description: this.editForm.value.description,
      musician: this.editForm.value.musician,
    }

    if (this.editing) {
      eventData.id = this.event.id;

      this.eventService.editEvent(eventData).subscribe({
        next: (response: any) => { this.router.navigate(['/events']).then(r => {}); },
        error: (response: HttpErrorResponse): void => {
          this.errors = response.error.data;
        },
      })
    } else {
      this.eventService.addEvent(eventData).subscribe({
        next: (response: any) => { this.router.navigate(['/events']).then(r => {}); },
        error: (response: HttpErrorResponse): void => {
          this.errors = response.error.data;
        },
      })
    }
  }
}
