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
})
export class UnorderedListComponent {
  @Input() public target: string = "";
  @Input() public title: string = "";
  @Input() public items: [] = [];
}
