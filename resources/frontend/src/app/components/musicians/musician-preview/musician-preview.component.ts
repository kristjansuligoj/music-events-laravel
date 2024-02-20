import {Component, Input} from '@angular/core';
import {RouterLink} from "@angular/router";
import {JsonPipe, NgForOf, NgIf, NgOptimizedImage} from "@angular/common";
import {ButtonComponent} from "../../shared/button/button.component";
import {UnorderedListComponent} from "../../shared/unordered-list/unordered-list.component";

@Component({
  selector: 'app-musician-preview',
  standalone: true,
  imports: [
    RouterLink,
    NgForOf,
    JsonPipe,
    NgOptimizedImage,
    ButtonComponent,
    NgIf,
    UnorderedListComponent
  ],
  templateUrl: './musician-preview.component.html',
  styleUrl: './musician-preview.component.css'
})
export class MusicianPreviewComponent {
  @Input() musician: any = {};
}
