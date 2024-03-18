import { Component } from '@angular/core';
import {ButtonComponent} from "../../shared/button/button.component";
import {Location, NgIf, NgOptimizedImage} from "@angular/common";
import {UnorderedListComponent} from "../../shared/unordered-list/unordered-list.component";
import {AuthService} from "../../../services/auth.service";
import {Router} from "@angular/router";
import {SongService} from "../../../services/song.service";
import {SpanComponent} from "../../shared/span/span.component";

@Component({
  selector: 'app-song-view',
  standalone: true,
  imports: [
    ButtonComponent,
    NgIf,
    NgOptimizedImage,
    UnorderedListComponent,
    SpanComponent,
  ],
  providers: [
    SongService,
  ],
  templateUrl: './song-view.component.html',
})
export class SongViewComponent {
  public song: any = {};

  constructor(
    public songService: SongService,
    public authService: AuthService,
    private location: Location,
    private router: Router,
  ) {}

  public ngOnInit(): void {
    const id: string = this.location.path().split('/')[2];
    this.songService.getSongById(id).subscribe({
      next: (response: any) => {
        this.song = response.data.song;
      },
      error: (response: any) => {
        console.log("not good");
      }
    })
  }

  /**
   * Removes the given song
   *
   * @param { string } id
   */
  public removeSong(id: any): void {
    this.songService.removeSong(id).subscribe({
      next: (response: any) => {
        this.router.navigate(['/songs']).then(r => {});
      },
      error: (response: any) => {
        console.log("not good");
      }
    })
  }
}
