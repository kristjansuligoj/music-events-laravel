import {Component, Input} from '@angular/core';
import {NgForOf, NgIf} from "@angular/common";
import {TitleCasePipe} from "../../../pipes/title-case.pipe";
import {FormGroup, ReactiveFormsModule} from "@angular/forms";

@Component({
  selector: 'app-input-form',
  standalone: true,
  imports: [
    NgForOf,
    NgIf,
    ReactiveFormsModule,
    TitleCasePipe,
    TitleCasePipe
  ],
  templateUrl: './input-form.component.html',
  styleUrl: './input-form.component.css'
})
export class InputFormComponent {
  @Input() name: string = '';
  @Input() inputType: string = '';
  @Input() formGroup: FormGroup = new FormGroup({});
  @Input() errors: { [key: string]: string } = {};

  protected readonly Object = Object;
}
