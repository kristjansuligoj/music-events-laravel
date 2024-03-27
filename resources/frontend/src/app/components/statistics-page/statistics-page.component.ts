import {Component, OnInit} from '@angular/core';
import {PieChartComponent} from "../shared/pie-chart/pie-chart.component";
import {VerticalBarChartComponent} from "../shared/vertical-bar-chart/vertical-bar-chart.component";
import {NumberCardChartComponent} from "../shared/number-card-chart/number-card-chart.component";
import {ButtonComponent} from "../shared/button/button.component";
import {NgIf} from "@angular/common";
import {AuthService} from "../../services/auth.service";
import {HrComponent} from "../shared/hr/hr.component";
import {SongService} from "../../services/song.service";
import {MusicianService} from "../../services/musician.service";
import {EventService} from "../../services/event.service";

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
  providers: [
    MusicianService,
    SongService,
    EventService,
  ],
  templateUrl: './statistics-page.component.html',
})
export class StatisticsPageComponent implements OnInit {
  public myMusicians: any = [];
  public mySongs: any = [];
  public myEvents: any = [];
  public genreCount: any[] = [];

  public constructor(
    public authService: AuthService,
    public musicianService: MusicianService,
    public songService: SongService,
    public eventService: EventService,
  ) {}

  public ngOnInit(): void {
    const loggedUser: any = this.authService.getLoggedUser();

    if (loggedUser) {
      this.fetchMyAddedElements(loggedUser.id);
    }
  }

  /**
   * Fetches all elements the logged user has added, for further analysis
   *
   * @param { string } id
   */
  public fetchMyAddedElements(id: string): void {
    this.musicianService.allMusicians(id, null, true).subscribe({
      next: (response: any) => {
        this.myMusicians = response.data.musicians;

        this.songService.allSongs(id, null, true).subscribe({
            next: (response: any) => {
              this.mySongs = response.data.songs;

              this.getGenreCount();

              this.eventService.allEvents(id, null, true).subscribe({
                  next: (response: any) => {
                    this.myEvents = response.data.events;
                  },
                  error: (response: any) => {
                    console.log(response);
                  }
                }
              );
            },
            error: (response: any) => {
              console.log(response);
            }
          }
        );
      },
      error: (response: any) => {
        console.log(response);
      }
    });
  }

  /**
   * Goes through songs and counts how many times a genre appears,
   * it then formats the data for pie chart representation
   */
  public getGenreCount(): void {
    const genreCounts = this.mySongs.reduce((counts: any, song: any) => {
      song.genres.forEach((genre: any) => {
        counts[genre.name] = (counts[genre.name] || 0) + 1;
      });
      return counts;
    }, {});

    this.genreCount = Object.keys(genreCounts).map((name: string): any => ({
      name,
      value: genreCounts[name]
    }));
  }
}
