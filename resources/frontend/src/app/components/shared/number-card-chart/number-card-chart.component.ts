import {Component, Input} from '@angular/core';
import {NgxChartsModule} from "@swimlane/ngx-charts";

@Component({
  selector: 'app-number-card-chart',
  standalone: true,
  imports: [
    NgxChartsModule
  ],
  templateUrl: './number-card-chart.component.html',
})
export class NumberCardChartComponent {
  @Input() public data: any[] = [];
  @Input() public size: [number, number] = [700, 400];
  @Input() public cardColor: string = '#232837';
  @Input() public colorScheme: any = {
    domain: ['#5AA454', '#A10A28', '#C7B42C', '#AAAAAA', '#2D5A71', '#E37222', '#6E44FF']
  };
}
