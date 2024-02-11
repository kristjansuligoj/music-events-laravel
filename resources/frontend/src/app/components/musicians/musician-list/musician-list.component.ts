import {Component, OnInit} from '@angular/core';
import {MusicianService} from "../../../services/musician.service";
import {NgForOf, NgIf} from "@angular/common";
import {MusicianViewComponent} from "../musician-view/musician-view.component";
import {SearchBarComponent} from "../../shared/search-bar/search-bar.component";
import {MusicianPreviewComponent} from "../musician-preview/musician-preview.component";
import {ButtonComponent} from "../../shared/button/button.component";
import {RouterLink} from "@angular/router";
import {AuthService} from "../../../services/auth.service";

@Component({
  selector: 'app-musician-list',
  standalone: true,
  imports: [
    NgForOf,
    MusicianViewComponent,
    SearchBarComponent,
    MusicianPreviewComponent,
    ButtonComponent,
    NgIf,
    RouterLink
  ],
  providers: [
    MusicianService
  ],
  templateUrl: './musician-list.component.html',
  styleUrl: './musician-list.component.css'
})
export class MusicianListComponent implements OnInit {
  musicians: any[] = [];
  sortOrder: any = {};
  nextPageUrl: string | null = null;
  prevPageUrl: string | null = null;

  constructor(
    public musicianService: MusicianService,
    public authService: AuthService,
  ) {}

  public ngOnInit() {
    this.getMusicians("", null);
  }

  public search(event: any) {
    this.getMusicians(event, null);
  }

  public filter(event: any) {
    this.getMusicians("", event);
  }

  public getMusicians(keyword: string, filter: any) {
    this.musicianService.allMusicians(keyword, filter).subscribe({
      next: (response: any) => {
        this.musicians = response.data.musicians.data;
        this.nextPageUrl = response.data.musicians.next_page_url;
        this.prevPageUrl = response.data.musicians.prev_page_url;
      },
      error: (error) => {
        console.error('Error fetching musicians:', error);
      }
    });
  }

  goToNextPage(): void {
    if (this.nextPageUrl) {
      this.musicianService.paginatedMusicians(this.nextPageUrl).subscribe({
        next: (response: any) => {
          this.musicians = response.data.musicians.data;
          this.nextPageUrl = response.data.musicians.next_page_url;
          this.prevPageUrl = response.data.musicians.prev_page_url;
        },
        error: (error) => {
          console.error('Error fetching musicians:', error);
        }
      });
    }
  }

  goToPrevPage(): void {
    if (this.prevPageUrl) {
      this.musicianService.paginatedMusicians(this.prevPageUrl).subscribe({
        next: (response: any) => {
          this.musicians = response.data.musicians.data;
          this.nextPageUrl = response.data.musicians.next_page_url;
          this.prevPageUrl = response.data.musicians.prev_page_url;
        },
        error: (error) => {
          console.error('Error fetching musicians:', error);
        }
      });
    }
  }
}
