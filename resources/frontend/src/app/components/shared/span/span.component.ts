import {Component, Input} from '@angular/core';
import {ReactiveFormsModule} from "@angular/forms";
import {NgForOf, NgIf} from "@angular/common";
import {TitleCasePipe} from "../../../pipes/title-case.pipe";

@Component({
  selector: 'app-span',
  standalone: true,
  imports: [
    ReactiveFormsModule,
    NgForOf,
    NgIf,
    TitleCasePipe
  ],
  templateUrl: './span.component.html',
  styleUrl: './span.component.css'
})
export class SpanComponent {
  @Input() title: string = "";
  @Input() data: string = "";
}
