import {Component, Input, Output, EventEmitter} from '@angular/core';
import {ImageService} from "../../../services/image.service";
import {FormGroup, ReactiveFormsModule} from "@angular/forms";

@Component({
  selector: 'app-image-input',
  standalone: true,
  imports: [
    ReactiveFormsModule
  ],
  providers: [
    ImageService,
  ],
  templateUrl: './image-input.component.html',
})
export class ImageInputComponent {
  @Input() public formGroup: FormGroup = new FormGroup({});
  @Input() public name: string = "";
  @Input() public required: boolean = true;
  @Output() public selectedImage: EventEmitter<any> = new EventEmitter();

  /**
   * Emits the selected file
   *
   * @param { any } event
   */
  public onFileSelected(event: any): void {
    this.selectedImage.emit(event.target); // Emit the selected file
  }
}
