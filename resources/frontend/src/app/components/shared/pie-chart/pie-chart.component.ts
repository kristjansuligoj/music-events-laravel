import {Component, Input} from '@angular/core';
import {LegendPosition, NgxChartsModule} from '@swimlane/ngx-charts';

@Component({
  selector: 'app-pie-chart',
  standalone: true,
  imports: [
    NgxChartsModule
  ],
  templateUrl: './pie-chart.component.html',
})
export class PieChartComponent {
  @Input() public data: any[] = [];
  @Input() public size: [number, number] = [500, 500];
  @Input() public showLegend: boolean = true;
  @Input() public showLabels: boolean = true;
  @Input() public isDoughnut: boolean = false;
  @Input() public legendPosition: LegendPosition = LegendPosition.Right;
  @Input() public gradient: boolean = true;
  @Input() public colorScheme: any = {
    domain: ['#5AA454', '#A10A28', '#C7B42C', '#AAAAAA']
  };
}
