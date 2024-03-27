import {Component, Input} from '@angular/core';
import {ButtonComponent} from "../../shared/button/button.component";
import {SpanComponent} from "../../shared/span/span.component";
import {DatePipe} from "@angular/common";
import {HrComponent} from "../../shared/hr/hr.component";

@Component({
  selector: 'app-note-preview',
  standalone: true,
    imports: [
        ButtonComponent,
        SpanComponent,
        DatePipe,
        HrComponent
    ],
  templateUrl: './note-preview.component.html',
})
export class NotePreviewComponent {
  @Input() public note: any = {};
}
