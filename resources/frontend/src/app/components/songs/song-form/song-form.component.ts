import {Component, OnInit} from '@angular/core';
import {CheckboxesComponent} from "../../shared/checkboxes/checkboxes.component";
import {ImageInputComponent} from "../../shared/image-input/image-input.component";
import {JsonPipe, NgIf} from "@angular/common";
import {FormArray, FormControl, FormGroup, ReactiveFormsModule, Validators} from "@angular/forms";
import {TextInputComponent} from "../../shared/text-input/text-input.component";
import {extractAuthorNames, formatDate} from '../../../helpers/functions';
import {ActivatedRoute, Router} from "@angular/router";
import {HttpErrorResponse} from "@angular/common/http";
import {SongService} from "../../../services/song.service";
import {genres} from "../../../config/genres";
import {DropdownComponent} from "../../shared/dropdown/dropdown.component";
import {MusicianService} from "../../../services/musician.service";
import {SubmitButtonComponent} from "../../shared/submit-button/submit-button.component";
import {dateRelativeToTodayValidator} from "../../../validators/dateRelativeToTodayValidator";

@Component({
  selector: 'app-song-form',
  standalone: true,
  imports: [
    CheckboxesComponent,
    ImageInputComponent,
    JsonPipe,
    ReactiveFormsModule,
    TextInputComponent,
    NgIf,
    DropdownComponent,
    SubmitButtonComponent
  ],
  providers: [
    SongService,
    MusicianService,
  ],
  templateUrl: './song-form.component.html',
})
export class SongFormComponent implements OnInit {
  public errors: any = {};
  public editing: boolean = false;
  public song: any = {};
  public musicians: any = {};
  public formLoaded: boolean = false;

  constructor(
    public songService: SongService,
    public musicianService: MusicianService,
    private router: Router,
    private route: ActivatedRoute,
  ) {}

  public editForm: FormGroup = new FormGroup({
    musician: new FormControl('', [Validators.required]),
    title: new FormControl('', [Validators.required]),
    length: new FormControl('', [Validators.required, Validators.min(10), Validators.max(300)]),
    releaseDate: new FormControl('', [Validators.required, dateRelativeToTodayValidator('before')]),
    authors: new FormControl('', [Validators.required]),
    genre: new FormArray([]),
  });

  public ngOnInit(): void {
    this.getDefaultValues();
  }

  /**
   * Gets default values for song form. If user is editing, fill the inputs with current values
   */
  public getDefaultValues(): void {
    this.musicianService.allMusiciansUnpaginated().subscribe({
      next: (response: any) => {
        // Maps the object to correct property names for dropdown component
        this.musicians = response.data.musicians.map((item: any) => ({
          key: item.id,
          value: item.name,
        }));

        this.route.params.subscribe(params => {
          const id = params['id'];

          if (id) {
            this.editing = true;
            this.songService.getSongById(id).subscribe({
              next: (response: any ) => {
                this.song = response.data.song;

                this.resetForm();

                this.genres.forEach((genre: any) => {
                  const formArray: FormArray = this.editForm.get('genre') as FormArray;
                  const checked = this.song.genres?.some((item: any) => item.name === genre.label);
                  formArray.push(new FormControl(checked));
                });
              },
            })
          } else {
            this.genres.forEach((genre: any) => {
              const formArray: FormArray = this.editForm.get('genre') as FormArray;
              formArray.push(new FormControl(false));
            });

            this.formLoaded = true;
          }
        })
      }
    })
  }

  public onSubmit(): void {
    const genre: number[] = [];
    this.editForm.value.genre.forEach((value: boolean, index: number) => {
      if (value) { genre.push(genres[index].id); }
    });

    const songData: any = {
      musician: this.editForm.value.musician,
      title: this.editForm.value.title,
      length: this.editForm.value.length,
      releaseDate: this.editForm.value.releaseDate,
      authors: this.editForm.value.authors,
      genre: genre,
    }

    if (this.editing) {
      songData.id = this.song.id;

      this.songService.editSong(songData).subscribe({
        next: (response: any) => { this.router.navigate(['/songs']).then(r => {}); },
        error: (response: HttpErrorResponse): void => {
          this.errors = response.error.data;
        },
      })
    } else {
      this.songService.addSong(songData).subscribe({
        next: (response: any) => { this.router.navigate(['/songs']).then(r => {}); },
        error: (response: HttpErrorResponse): void => {
          this.errors = response.error.data;
        },
      })
    }
  }

  public resetForm(): void {
    this.editForm.reset({
      musician: this.song.musician_id,
      title: this.song.title,
      length: this.song.length,
      releaseDate: formatDate(this.song.releaseDate),
      authors: extractAuthorNames(this.song.authors),
    });

    this.formLoaded = true;
  }

  protected readonly genres = genres;
}
