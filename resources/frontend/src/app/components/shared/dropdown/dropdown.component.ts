import {Component, Input} from '@angular/core';
import {MatFormField, MatFormFieldModule, MatLabel} from "@angular/material/form-field";
import {MatOption, MatSelect, MatSelectModule} from "@angular/material/select";
import {JsonPipe, KeyValuePipe, NgForOf, NgIf} from "@angular/common";
import {FormGroup, ReactiveFormsModule} from "@angular/forms";
import {TitleCasePipe} from "../../../pipes/title-case.pipe";

@Component({
  selector: 'app-dropdown',
  standalone: true,
  templateUrl: './dropdown.component.html',
  styleUrl: './dropdown.component.css',
  imports: [
    NgForOf,
    MatSelect,
    MatLabel,
    MatFormField,
    MatOption,
    MatFormFieldModule,
    MatSelectModule,
    ReactiveFormsModule,
    NgIf,
    TitleCasePipe,
    KeyValuePipe,
    JsonPipe
  ]
})
export class DropdownComponent {
  @Input() options: any = {};
  @Input() formGroup: FormGroup = new FormGroup({});
  @Input() name: string = "";
  protected readonly Object = Object;
}
