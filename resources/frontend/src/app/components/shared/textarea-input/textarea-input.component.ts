import {Component, Input} from '@angular/core';
import {NgForOf, NgIf} from "@angular/common";
import {FormGroup, ReactiveFormsModule} from "@angular/forms";
import {TitleCasePipe} from "../../../pipes/title-case.pipe";

@Component({
  selector: 'app-textarea-input',
  standalone: true,
    imports: [
        NgForOf,
        NgIf,
        ReactiveFormsModule,
        TitleCasePipe
    ],
  templateUrl: './textarea-input.component.html',
  styleUrl: './textarea-input.component.css'
})
export class TextareaInputComponent {
  @Input() name: string = '';
  @Input() formGroup: FormGroup = new FormGroup({});
  @Input() errors: { [key: string]: string } = {};
  @Input() required: boolean = true;
  @Input() additionalErrors: any = {};
  protected readonly Object = Object;
}
