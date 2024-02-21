import {Component, OnInit} from '@angular/core';
import {ButtonComponent} from "../../shared/button/button.component";
import {MusicianPreviewComponent} from "../../musicians/musician-preview/musician-preview.component";
import {NgForOf, NgIf} from "@angular/common";
import {SearchBarComponent} from "../../shared/search-bar/search-bar.component";
import {AuthService} from "../../../services/auth.service";
import {SongService} from "../../../services/song.service";
import {RouterLink} from "@angular/router";
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
  songs: any[] = [];
  nextPageUrl: string | null = null;
  prevPageUrl: string | null = null;

  constructor(
    public songService: SongService,
    public authService: AuthService,
  ) {}

  public ngOnInit(): void {
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
        this.nextPageUrl = response.data.songs.next_page_url;
        this.prevPageUrl = response.data.songs.prev_page_url;
      },
      error: (error) => {
        console.error('Error fetching songs:', error);
      }
    });
  }
}
