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
  styleUrl: './image-input.component.css'
})
export class ImageInputComponent {
  @Output() selectedImage: EventEmitter<any> = new EventEmitter();
  @Input() formGroup: FormGroup = new FormGroup({});
  @Input() name: string = "";
  @Input() required: boolean = true;

  constructor() {}
  public onFileSelected(event: any) {
    this.selectedImage.emit(event.target); // Emit the selected file
  }
}
