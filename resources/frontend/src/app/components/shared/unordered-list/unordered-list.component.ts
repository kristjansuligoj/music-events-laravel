import {Component, Input} from '@angular/core';
import {JsonPipe, NgForOf} from "@angular/common";
import {TitleCasePipe} from "../../../pipes/title-case.pipe";

@Component({
  selector: 'app-unordered-list',
  standalone: true,
  imports: [
    NgForOf,
    TitleCasePipe,
    JsonPipe,
  ],
  templateUrl: './unordered-list.component.html',
  styleUrl: './unordered-list.component.css'
})
export class UnorderedListComponent {
  @Input() target: string = "";
  @Input() title: string = "";
  @Input() items: [] = [];
}
