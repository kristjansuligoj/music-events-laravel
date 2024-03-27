import {Component, Input} from '@angular/core';
import {ButtonComponent} from "../../shared/button/button.component";
import {JsonPipe, NgOptimizedImage} from "@angular/common";
import {UnorderedListComponent} from "../../shared/unordered-list/unordered-list.component";
import {SpanComponent} from "../../shared/span/span.component";
import {HrComponent} from "../../shared/hr/hr.component";

@Component({
  selector: 'app-song-preview',
  standalone: true,
    imports: [
        ButtonComponent,
        NgOptimizedImage,
        UnorderedListComponent,
        SpanComponent,
        JsonPipe,
        HrComponent
    ],
  templateUrl: './song-preview.component.html',
})
export class SongPreviewComponent {
  @Input() public song: any = {};
}
