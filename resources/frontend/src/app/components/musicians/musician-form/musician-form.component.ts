import {Component, OnInit} from '@angular/core';
import {TextInputComponent} from "../../shared/text-input/text-input.component";
import {FormArray, FormControl, FormGroup, ReactiveFormsModule, Validators} from "@angular/forms";
import {MusicianService} from "../../../services/musician.service";
import {ActivatedRoute, Router} from "@angular/router";
import {ImageInputComponent} from "../../shared/image-input/image-input.component";
import {ImageService} from "../../../services/image.service";
import {CheckboxesComponent} from "../../shared/checkboxes/checkboxes.component";
import {genres} from "../../../config/genres";
import {HttpErrorResponse} from "@angular/common/http";
import {JsonPipe, NgIf} from "@angular/common";
import {SubmitButtonComponent} from "../../shared/submit-button/submit-button.component";

@Component({
  selector: 'app-musician-form',
  standalone: true,
  imports: [
    TextInputComponent,
    ReactiveFormsModule,
    ImageInputComponent,
    CheckboxesComponent,
    JsonPipe,
    NgIf,
    SubmitButtonComponent
  ],
  providers: [
    MusicianService,
    ImageService,
  ],
  templateUrl: './musician-form.component.html',
})
export class MusicianFormComponent implements OnInit {
  public errors: any = {};
  public editing: boolean = false;
  public musician: any = {};
  public selectedFile: any = {};
  public formLoaded: boolean = false;

  constructor(
    public musicianService: MusicianService,
    public imageService: ImageService,
    private router: Router,
    private route: ActivatedRoute,
  ) {}

  public editForm: FormGroup = new FormGroup({
    image: new FormControl('', [Validators.required]),
    name: new FormControl('', [Validators.required]),
    genre: new FormArray([], [Validators.required]),
  });

  public ngOnInit(): void {
    this.getDefaultValues();
  }

  /**
   * Gets default values for musician form. If user is editing, fill the inputs with current values
   */
  public getDefaultValues(): void {
    this.route.params.subscribe(params => {
      const id = params['id'];

      if (id) {
        this.editing = true;
        this.musicianService.getMusicianById(id).subscribe({
          next: (response: any ) => {
            this.musician = response.data.musician;
            this.editForm.patchValue({
              name: this.musician.name,
            });

            this.genres.forEach((genre: any) => {
              const formArray: FormArray = this.editForm.get('genre') as FormArray;
              const checked = this.musician.genres?.some((item: any) => item.name === genre.label);
              formArray.push(new FormControl(checked));
            });

            this.formLoaded = true;
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

  /**
   * Ready the file to be uploaded when user submits the form
   *
   * @param { any } event
   */
  public onFileSelected(event: any): void {
    const file: File = event.files[0];
    const reader: FileReader = new FileReader();

    reader.readAsDataURL(file);

    reader.onload = () => {
      this.selectedFile = {
        image: reader.result,
        type: file.type,
      };
    }
  }

  public onSubmit(): void {
    const genre: number[] = [];
    this.editForm.value.genre.forEach((value: boolean, index: number) => {
      if (value) { genre.push(genres[index].id); }
    });

    const musicianData: any = {
      name: this.editForm.value.name,
      genre: genre,
    }

    this.imageService.uploadImage(this.selectedFile).subscribe({
      next: (response: any) => {
        musicianData.image = response.data;

        if (this.editing) {
          musicianData.id = this.musician.id;

          this.musicianService.editMusicians(musicianData).subscribe({
            next: (response: any) => { this.router.navigate(['/musicians']).then(r => {}); },
            error: (response: HttpErrorResponse): void => {
              this.errors = response.error.data;
            },
          })
        } else {
          this.musicianService.addMusician(musicianData).subscribe({
            next: (response: any) => { this.router.navigate(['/musicians']).then(r => {}); },
            error: (response: HttpErrorResponse): void => {
              this.errors = response.error.data;
            },
          })
        }
      },
    })
  }

  protected readonly genres = genres;
}
