import {Component, Input} from '@angular/core';
import {RouterLink} from "@angular/router";
import {JsonPipe, NgForOf, NgIf, NgOptimizedImage} from "@angular/common";
import {ButtonComponent} from "../../shared/button/button.component";
import {UnorderedListComponent} from "../../shared/unordered-list/unordered-list.component";
import {environment} from "../../../../environments/environment";
import {HrComponent} from "../../shared/hr/hr.component";

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
        UnorderedListComponent,
        HrComponent
    ],
  templateUrl: './musician-preview.component.html',
})
export class MusicianPreviewComponent {
  @Input() public musician: any = {};

  protected readonly environment = environment;
}
