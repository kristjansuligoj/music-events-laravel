import {Component, Input, OnInit} from '@angular/core';
import {JsonPipe, NgForOf, NgIf} from "@angular/common";
import {TitleCasePipe} from "../../../pipes/title-case.pipe";
import {FormArray, FormControl, FormGroup, ReactiveFormsModule} from "@angular/forms";

@Component({
  selector: 'app-checkboxes',
  standalone: true,
  imports: [
    NgForOf,
    TitleCasePipe,
    ReactiveFormsModule,
    NgIf,
    JsonPipe
  ],
  templateUrl: './checkboxes.component.html',
  styleUrl: './checkboxes.component.css'
})
export class CheckboxesComponent {
  @Input() options: any[] = [];
  @Input() editing: boolean = false;
  @Input() name: string = "";
  @Input() required: boolean = true;
  @Input() formGroup: FormGroup = new FormGroup({});
  @Input() errors: { [key: string]: string } = {};
  @Input() additionalErrors: any = {};

  protected readonly Object = Object;
}
