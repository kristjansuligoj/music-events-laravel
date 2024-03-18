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
})
export class TextInputComponent {
  @Input() public name: string = '';
  @Input() public inputType: string = '';
  @Input() public formGroup: FormGroup = new FormGroup({});
  @Input() public errors: { [key: string]: string } = {};
  @Input() public required: boolean = true;
  @Input() public additionalErrors: any = {};

  protected readonly Object = Object;
}
