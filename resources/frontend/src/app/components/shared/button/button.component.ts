import {Component, EventEmitter, Input, Output} from '@angular/core';
import { RouterLink } from "@angular/router";

@Component({
  selector: 'app-button',
  standalone: true,
  imports: [
    RouterLink
  ],
  templateUrl: './button.component.html',
  styleUrl: 'button.component.css',
})
export class ButtonComponent {
  @Input() public route: string = "";
  @Input() public buttonText: string = "";
  @Input() public disabled: boolean = false;
  @Input() public type: string = "";
  @Input() public buttonStyle: string = "";
  @Input() public removeButton: boolean = false;
  @Output() public clickedEmitter: EventEmitter<boolean> = new EventEmitter<boolean>();

  /**
   * Emits an event that the button was clicked
   */
  public handleClick(): void {
    if (this.removeButton) {
      this.clickedEmitter.emit(true);
    }
  }
}
