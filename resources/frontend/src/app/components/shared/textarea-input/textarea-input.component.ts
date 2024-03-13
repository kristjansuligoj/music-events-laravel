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
})
export class TextareaInputComponent {
  @Input() public name: string = '';
  @Input() public formGroup: FormGroup = new FormGroup({});
  @Input() public errors: { [key: string]: string } = {};
  @Input() public required: boolean = true;
  @Input() public additionalErrors: any = {};
  protected readonly Object = Object;
}
