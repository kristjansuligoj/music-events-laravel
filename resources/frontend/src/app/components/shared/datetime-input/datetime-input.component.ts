import {Component, Input} from '@angular/core';
import {MatFormField} from "@angular/material/form-field";
import {MatInput, MatInputModule} from "@angular/material/input";
import {
  MatDatepicker,
  MatDatepickerInput,
  MatDatepickerModule,
  MatDatepickerToggle
} from "@angular/material/datepicker";
import {MatNativeDateModule} from "@angular/material/core";
import {NgIf} from "@angular/common";
import {FormGroup, ReactiveFormsModule} from "@angular/forms";

@Component({
  selector: 'app-datetime-input',
  standalone: true,
  imports: [
    MatFormField,
    MatInput,
    MatDatepickerToggle,
    MatDatepicker,
    MatDatepickerInput,
    MatDatepickerModule,
    MatNativeDateModule,
    MatInputModule,
    NgIf,
    ReactiveFormsModule,
  ],
  templateUrl: './datetime-input.component.html',
  styleUrl: './datetime-input.component.css'
})
export class DatetimeInputComponent {
  @Input() formGroup: FormGroup = new FormGroup({});
  @Input() name: string = "";
}
