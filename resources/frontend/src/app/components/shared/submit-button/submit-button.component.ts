import {Component, Input} from '@angular/core';

@Component({
  selector: 'app-submit-button',
  standalone: true,
  imports: [],
  templateUrl: './submit-button.component.html',
})
export class SubmitButtonComponent {
  @Input() public editing: boolean = false;
  @Input() public formInvalid: boolean = true;
  @Input() public customText: string = "";
}
