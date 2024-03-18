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
  @Input() public fields: any = [];
  @Output() public searchItemEmitter: EventEmitter<string> = new EventEmitter();
  @Output() public filterEmitter: EventEmitter<any> = new EventEmitter();

  public ordersMap: { [key: string]: string } = {};

  public searchItem: string = "";
  public currentField: string = "";

  public ngOnInit(): void {
    this.fields.forEach((field: string) => {
      this.ordersMap[field] = '';
    });
  }

  /**
   * Emits the search string, so form components can catch it, and use it for search
   *
   * @param { string } searchItem
   */
  public search(searchItem: string): void {
    this.searchItemEmitter.emit(searchItem);
  }

  /**
   * Emits the search map, so form components can catch it, and use it for filtering
   *
   * @param { string } field
   */
  public filter(field: string): void {
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
