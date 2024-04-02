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
    domain: ['#5AA454', '#E44D25', '#CFC0BB', '#7aa3e5', '#a8385d', '#aae3f5']
  };
}
