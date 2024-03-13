import {Component, Input} from '@angular/core';
import {JsonPipe, NgForOf, NgIf} from "@angular/common";
import {TitleCasePipe} from "../../../pipes/title-case.pipe";
import {FormGroup, ReactiveFormsModule} from "@angular/forms";

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
})
export class CheckboxesComponent {
  @Input() public options: any[] = [];
  @Input() public editing: boolean = false;
  @Input() public name: string = "";
  @Input() public required: boolean = true;
  @Input() public formGroup: FormGroup = new FormGroup({});
  @Input() public errors: { [key: string]: string } = {};
  @Input() public additionalErrors: any = {};

  protected readonly Object = Object;
}
