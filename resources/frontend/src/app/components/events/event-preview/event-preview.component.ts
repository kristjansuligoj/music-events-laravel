import {Component, Input} from '@angular/core';
import {ButtonComponent} from "../../shared/button/button.component";
import {JsonPipe, NgIf, NgOptimizedImage} from "@angular/common";
import {UnorderedListComponent} from "../../shared/unordered-list/unordered-list.component";
import {SpanComponent} from "../../shared/span/span.component";
import {HrComponent} from "../../shared/hr/hr.component";

@Component({
  selector: 'app-event-preview',
  standalone: true,
  imports: [
    ButtonComponent,
    NgOptimizedImage,
    UnorderedListComponent,
    SpanComponent,
    JsonPipe,
    HrComponent,
    NgIf
  ],
  templateUrl: './event-preview.component.html',
})
export class EventPreviewComponent {
  @Input() public event: any = {};
}
