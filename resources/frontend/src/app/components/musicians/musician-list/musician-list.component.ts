import {Component, OnInit} from '@angular/core';
import {MusicianService} from "../../../services/musician.service";
import {NgForOf, NgIf} from "@angular/common";
import {MusicianViewComponent} from "../musician-view/musician-view.component";
import {SearchBarComponent} from "../../shared/search-bar/search-bar.component";
import {MusicianPreviewComponent} from "../musician-preview/musician-preview.component";
import {ButtonComponent} from "../../shared/button/button.component";
import {Router, RouterLink} from "@angular/router";
import {AuthService} from "../../../services/auth.service";
import {EventPreviewComponent} from "../../events/event-preview/event-preview.component";
import {PaginationComponent} from "../../shared/pagination/pagination.component";

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
    RouterLink,
    EventPreviewComponent,
    PaginationComponent
  ],
  providers: [
    MusicianService
  ],
  templateUrl: './musician-list.component.html',
  styleUrl: './musician-list.component.css'
})
export class MusicianListComponent implements OnInit {
  public musicians: any[] = [];
  public sortOrder: any = {};
  public getMine: boolean = false;
  public nextPageUrl: string | null = null;
  public prevPageUrl: string | null = null;

  constructor(
    public musicianService: MusicianService,
    public authService: AuthService,
    private router: Router,
  ) {}

  public ngOnInit(): void {
    if (this.authService.getLoggedUser()) {
      if (this.router.url === "/musicians/mine") {
        this.getMine = true;
      }
    }

    this.getMusicians("", null);
  }

  /**
   * Gets musicians based on the given search string
   *
   * @param { any } event
   */
  public search(event: any): void {
    this.getMusicians(event, null);
  }

  /**
   * Gets musicians based on the given filter
   *
   * @param { any } event
   */
  public filter(event: any): void {
    this.getMusicians("", event);
  }

  /**
   * Gets the musicians based on the given parameters
   *
   * @param { string } keyword
   * @param { any } filter
   */
  public getMusicians(keyword: string, filter: any): void {
    if (this.getMine) {
      keyword = this.authService.getLoggedUser().id;
    }

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
}
