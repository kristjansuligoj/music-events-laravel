import {Component, OnInit} from '@angular/core';
import {ButtonComponent} from "../../shared/button/button.component";
import {MusicianPreviewComponent} from "../../musicians/musician-preview/musician-preview.component";
import {NgForOf, NgIf} from "@angular/common";
import {SearchBarComponent} from "../../shared/search-bar/search-bar.component";
import {MusicianService} from "../../../services/musician.service";
import {AuthService} from "../../../services/auth.service";
import {SongService} from "../../../services/song.service";
import {RouterLink} from "@angular/router";
import {SongPreviewComponent} from "../song-preview/song-preview.component";

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

  public ngOnInit() {
    this.getSongs("", null);
  }

  public search(event: any) {
    this.getSongs(event, null);
  }

  public filter(event: any) {
    this.getSongs("", event);
  }

  public getSongs(keyword: string, filter: any) {
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

  goToNextPage(): void {
    if (this.nextPageUrl) {
      this.songService.paginatedSongs(this.nextPageUrl).subscribe({
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

  goToPrevPage(): void {
    if (this.prevPageUrl) {
      this.songService.paginatedSongs(this.prevPageUrl).subscribe({
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
}
