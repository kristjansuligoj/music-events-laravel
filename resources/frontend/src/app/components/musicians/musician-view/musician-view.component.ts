import {Component, Input, OnInit} from '@angular/core';
import {MusicianService} from "../../../services/musician.service";
import {JsonPipe, Location, NgIf, NgOptimizedImage} from '@angular/common';
import {UnorderedListComponent} from "../../shared/unordered-list/unordered-list.component";
import {AuthService} from "../../../services/auth.service";
import {ButtonComponent} from "../../shared/button/button.component";
import {Router} from "@angular/router";

@Component({
  selector: 'app-musician-view',
  standalone: true,
  imports: [
    JsonPipe,
    NgOptimizedImage,
    UnorderedListComponent,
    NgIf,
    ButtonComponent,
  ],
  providers: [
    MusicianService
  ],
  templateUrl: './musician-view.component.html',
  styleUrl: './musician-view.component.css'
})
export class MusicianViewComponent implements OnInit {
  public musician: any = {};

  constructor(
    public musicianService: MusicianService,
    public authService: AuthService,
    private location: Location,
    private router: Router,
  ) {}
  public ngOnInit() {
    const id: string = this.location.path().split('/')[2];
    this.musicianService.getMusicianById(id).subscribe({
      next: (response: any) => {
        this.musician = response.data.musician;
      },
      error: (response: any) => {
        console.log("not good");
      }
    })
  }

  public removeMusician(id: string) {
    this.musicianService.removeMusician(id).subscribe({
      next: (response: any) => {
        this.router.navigate(['/musicians']).then(r => {});
      },
      error: (response: any) => {
        console.log("not good");
      }
    })
  }
}