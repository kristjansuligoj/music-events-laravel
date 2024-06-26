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
  // All elements
  public musicians: any = [];
  public songs: any = [];
  public events: any = [];

  // Elements added by the logged user
  public myMusicians: any = [];
  public mySongs: any = [];
  public myEvents: any = [];

  public loggedUser: any;

  // Graph data
  public genreCount: any = [];
  public addedElements: any = [
    {
      "name": "Musicians",
      "value": 0,
    },
    {
      "name": "Songs",
      "value": 0
    },
    {
      "name": "Events",
      "value": 0
    }
  ]

  public topArtists: any = [];
  public mostPopularGenreCount: any = [];
  public mostPopularEvents: any = [];

  public constructor(
    public authService: AuthService,
    public musicianService: MusicianService,
    public songService: SongService,
    public eventService: EventService,
  ) {
    this.loggedUser = this.authService.getLoggedUser();
  }

  public ngOnInit(): void {
    this.fetchElements();
  }

  /**
   * Fetches all elements from the database, for further analysis
   */
  public fetchElements(): void {
    this.musicianService.allMusicians('', null, true).subscribe({
      next: (response: any) => {
        this.musicians = response.data.musicians;

        this.songService.allSongs('', null, true).subscribe({
            next: (response: any) => {
              this.songs = response.data.songs;

              this.eventService.allEvents('', null, true).subscribe({
                  next: (response: any) => {
                    this.events = response.data.events;

                    if (this.loggedUser) {
                      this.filterElements();
                    }

                    this.getGenreCount();
                    this.getAddedElementsCount();
                    this.getTopArtists();
                    this.getMostPopularGenreCount();
                    this.getMostPopularEvents();
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
   * Saves elements that were added by the logged user
   */
  public filterElements(): void {
    this.myMusicians = this.musicians.filter((musician: any) => {return musician.user_id === this.loggedUser.id});
    this.mySongs = this.songs.filter((song: any) => {return song.user_id === this.loggedUser.id});
    this.myEvents = this.events.filter((event: any) => {return event.user_id === this.loggedUser.id});
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

   /**
   * Counts all the added elements and formats the data for pie chart representation
   */
  public getAddedElementsCount(): void {
    this.addedElements = [
      {
        "name": "Musicians",
        "value": this.myMusicians.length,
      },
      {
        "name": "Songs",
        "value": this.mySongs.length,
      },
      {
        "name": "Events",
        "value": this.myEvents.length,
      },
    ]
  }

  /**
   * Goes through musicians and counts how many times they are participating in an event,
   * it then formats the data for number card chart representation
   */
  public getTopArtists(): void {
    this.topArtists = this.musicians.map((musician: any) => ({
      name: musician.name,
      value: musician.events.length
    })).sort((a: any, b: any) => b.value - a.value).slice(0, 12);
  }

   /**
   * Goes through all songs and counts how many times a genre appears,
   * it then formats the data for vertical bar chart representation
   */
  public getMostPopularGenreCount(): void {
    const genreCounts = this.songs.reduce((counts: any, song: any) => {
      song.genres.forEach((genre: any) => {
        counts[genre.name] = (counts[genre.name] || 0) + 1;
      });
      return counts;
    }, {});

    this.mostPopularGenreCount = Object.keys(genreCounts).map((name: string): any => ({
      name,
      value: genreCounts[name]
    })).sort((a: any, b: any) => b.value - a.value);
  }

  /**
   * Goes through events and counts how many users are participating in them,
   * it then formats the data for number card chart representation
   */
  public getMostPopularEvents(): void {
    this.mostPopularEvents = this.events.map((event: any) => ({
      name: event.name,
      value: event.participants.length
    })).sort((a: any, b: any) => b.value - a.value).slice(0, 12);
  }
}
