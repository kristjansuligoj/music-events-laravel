import {Component, Input} from '@angular/core';
import {JsonPipe, NgForOf, NgIf} from "@angular/common";
import {TitleCasePipe} from "../../../pipes/title-case.pipe";
import {FormGroup, ReactiveFormsModule} from "@angular/forms";

@Component({
  selector: 'app-text-input',
  standalone: true,
  imports: [
    NgForOf,
    NgIf,
    ReactiveFormsModule,
    TitleCasePipe,
    TitleCasePipe,
    JsonPipe
  ],
  templateUrl: './text-input.component.html',
  styleUrl: './text-input.component.css'
})
export class TextInputComponent {
  @Input() name: string = '';
  @Input() inputType: string = '';
  @Input() formGroup: FormGroup = new FormGroup({});
  @Input() errors: { [key: string]: string } = {};
  @Input() required: boolean = true;
  @Input() additionalErrors: any = {};

  protected readonly Object = Object;
}
