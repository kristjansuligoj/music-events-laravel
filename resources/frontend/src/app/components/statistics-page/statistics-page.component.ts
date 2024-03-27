import { Component } from '@angular/core';
import {PieChartComponent} from "../shared/pie-chart/pie-chart.component";
import {VerticalBarChartComponent} from "../shared/vertical-bar-chart/vertical-bar-chart.component";
import {NumberCardChartComponent} from "../shared/number-card-chart/number-card-chart.component";
import {ButtonComponent} from "../shared/button/button.component";
import {NgIf} from "@angular/common";
import {AuthService} from "../../services/auth.service";
import {HrComponent} from "../shared/hr/hr.component";

@Component({
  selector: 'app-statistics-page',
  standalone: true,
  imports: [
    PieChartComponent,
    VerticalBarChartComponent,
    NumberCardChartComponent,
    ButtonComponent,
    NgIf,
    HrComponent
  ],
  templateUrl: './statistics-page.component.html',
})
export class StatisticsPageComponent {

  public constructor(
    public authService: AuthService,
  ) {

  }
}
