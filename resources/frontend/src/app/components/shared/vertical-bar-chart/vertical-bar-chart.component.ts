import {Component, Input} from '@angular/core';
import {NgxChartsModule} from "@swimlane/ngx-charts";

@Component({
  selector: 'app-vertical-bar-chart',
  standalone: true,
  imports: [
    NgxChartsModule
  ],
  templateUrl: './vertical-bar-chart.component.html',
})
export class VerticalBarChartComponent {
  @Input() public data: any[] = [];
  @Input() public size: [number, number] = [400, 400];
  @Input() public showXAxis: boolean = true;
  @Input() public showYAxis: boolean = true;
  @Input() public gradient: boolean = false;
  @Input() public showLegend: boolean = true;
  @Input() public showXAxisLabel: boolean = true;
  @Input() public xAxisLabel: string = 'X axis label';
  @Input() public showYAxisLabel: boolean = true;
  @Input() public yAxisLabel: string = 'Y axis label';
  @Input() public colorScheme: any = {
    domain: ['#5AA454', '#A10A28', '#C7B42C', '#AAAAAA']
  };
}
