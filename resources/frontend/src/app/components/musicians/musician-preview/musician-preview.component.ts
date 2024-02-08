import {Component, Input} from '@angular/core';
import {RouterLink} from "@angular/router";
import {JsonPipe, NgForOf, NgOptimizedImage} from "@angular/common";
import {ButtonComponent} from "../../shared/button/button.component";

@Component({
  selector: 'app-musician-preview',
  standalone: true,
  imports: [
    RouterLink,
    NgForOf,
    JsonPipe,
    NgOptimizedImage,
    ButtonComponent
  ],
  templateUrl: './musician-preview.component.html',
  styleUrl: './musician-preview.component.css'
})
export class MusicianPreviewComponent {
  @Input() musician: any = {};
}
