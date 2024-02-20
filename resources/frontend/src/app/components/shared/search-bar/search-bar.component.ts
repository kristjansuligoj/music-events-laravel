import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {ButtonComponent} from "../button/button.component";
import {FormsModule} from "@angular/forms";
import {NgForOf} from "@angular/common";
import {SpanComponent} from "../span/span.component";

@Component({
  selector: 'app-search-bar',
  standalone: true,
  imports: [
    ButtonComponent,
    FormsModule,
    NgForOf,
    SpanComponent
  ],
  templateUrl: './search-bar.component.html',
  styleUrl: './search-bar.component.css'
})
export class SearchBarComponent implements OnInit {
  @Input() fields: any = [];
  @Output() searchItemEmitter: EventEmitter<string> = new EventEmitter();
  @Output() filterEmitter: EventEmitter<any> = new EventEmitter();

  public ordersMap: { [key: string]: string } = {};

  public searchItem: string = "";
  public currentField: string = "";

  public ngOnInit() {
    this.fields.forEach((field: string) => {
      this.ordersMap[field] = '';
    });
  }

  public search(searchItem: any) {
    this.searchItemEmitter.emit(searchItem);
  }

  public filter(field: string) {
    this.currentField = field;

    if (this.ordersMap[field] === '') {
      this.ordersMap[field] = 'asc';
    } else if (this.ordersMap[field] === 'asc')  {
      this.ordersMap[field] = 'desc';
    } else {
      this.ordersMap[field] = '';
    }

    this.filterEmitter.emit({
      order: this.ordersMap[field],
      field: field,
    });
  }
}
