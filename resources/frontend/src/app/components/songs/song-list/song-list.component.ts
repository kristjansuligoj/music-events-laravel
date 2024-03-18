import {Component, OnInit} from '@angular/core';
import {ButtonComponent} from "../../shared/button/button.component";
import {MusicianPreviewComponent} from "../../musicians/musician-preview/musician-preview.component";
import {NgForOf, NgIf} from "@angular/common";
import {SearchBarComponent} from "../../shared/search-bar/search-bar.component";
import {AuthService} from "../../../services/auth.service";
import {SongService} from "../../../services/song.service";
import {Router, RouterLink} from "@angular/router";
import {SongPreviewComponent} from "../song-preview/song-preview.component";
import {PaginationComponent} from "../../shared/pagination/pagination.component";

@Component({
  selector: 'app-song-list',
  standalone: true,
    imports: [
        ButtonComponent,
        MusicianPreviewComponent,
        NgForOf,
        NgIf,
        SearchBarComponent,
        RouterLink,
        SongPreviewComponent,
        PaginationComponent,
    ],
  providers: [
    SongService
  ],
  templateUrl: './song-list.component.html',
  styleUrl: './song-list.component.css'
})
export class SongListComponent implements OnInit {
  public songs: any[] = [];
  public getMine: boolean = false;
  public nextPageUrl: string | null = null;
  public prevPageUrl: string | null = null;

  constructor(
    public songService: SongService,
    public authService: AuthService,
    public router: Router,
  ) {}

  public ngOnInit(): void {
    if (this.authService.getLoggedUser()) {
      if (this.router.url === "/events/mine") {
        this.getMine = true;
      }
    }

    this.getSongs("", null);
  }

  /**
   * Gets songs based on the given search string
   *
   * @param { any } event
   */
  public search(event: any): void {
    this.getSongs(event, null);
  }

  /**
   * Gets songs based on the given filter
   *
   * @param { any } event
   */
  public filter(event: any): void {
    this.getSongs("", event);
  }

  /**
   * Gets the songs based on the given parameters
   *
   * @param { string } keyword
   * @param { any } filter
   */
  public getSongs(keyword: string, filter: any): void {
    this.songService.allSongs(keyword, filter).subscribe({
      next: (response: any) => {
        this.songs = response.data.songs.data;

        if (this.getMine) {
          const loggedUserId: string = this.authService.getLoggedUser().id;
          this.songs = this.songs.filter((item: any) => {
            return item.id === loggedUserId;
          })
        }

        this.nextPageUrl = response.data.songs.next_page_url;
        this.prevPageUrl = response.data.songs.prev_page_url;
      },
      error: (error) => {
        console.error('Error fetching songs:', error);
      }
    });
  }
}
