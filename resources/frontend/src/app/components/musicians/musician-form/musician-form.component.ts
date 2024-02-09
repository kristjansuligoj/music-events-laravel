import {Component, OnInit} from '@angular/core';
import {TextInputComponent} from "../../shared/input-form/text-input.component";
import {FormArray, FormControl, FormGroup, ReactiveFormsModule, Validators} from "@angular/forms";
import {MusicianService} from "../../../services/musician.service";
import {ActivatedRoute, Router} from "@angular/router";
import {ImageInputComponent} from "../../shared/image-input/image-input.component";
import {ImageService} from "../../../services/image.service";
import {CheckboxesComponent} from "../../shared/checkboxes/checkboxes.component";
import {genres} from "../../../config/genres";
import {HttpErrorResponse} from "@angular/common/http";
import {JsonPipe} from "@angular/common";

@Component({
  selector: 'app-musician-form',
  standalone: true,
  imports: [
    TextInputComponent,
    ReactiveFormsModule,
    ImageInputComponent,
    CheckboxesComponent,
    JsonPipe
  ],
  providers: [
    MusicianService,
    ImageService,
  ],
  templateUrl: './musician-form.component.html',
  styleUrl: './musician-form.component.css'
})
export class MusicianFormComponent implements OnInit {
  public errors: any = {};
  public editing: boolean = false;
  public musician: any = {};
  public selectedFile: any = {};

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

  public ngOnInit() {
    this.route.params.subscribe(params => {
      const id = params['id'];

      if (id) {
        this.editing = true;
        this.musicianService.getMusicianById(id).subscribe({
          next: (response: any ) => {
            this.musician = response.data.musician;
            this.editForm.patchValue({
              image: this.musician.image,
              name: this.musician.name,
            })
          },
          error: (response: HttpErrorResponse): void => {
            this.router.navigate(['/musicians']).then(r => {});
          },
        })
      }
    })
  }

  onFileSelected(event: any): void {
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

  public onSubmit() {
    const name = this.editForm.value.name;

    const genre: number[] = [];
    this.editForm.value.genre.forEach((value: boolean, index: number) => {
      if (value) { genre.push(genres[index].id); }
    });

    this.imageService.uploadImage(this.selectedFile).subscribe({
      next: (response: any) => {
        this.musicianService.addMusician({image: response.data, name: name, genre: genre}).subscribe({
          next: (response: any) => { this.router.navigate(['/musicians']).then(r => {}); },
          error: (response: HttpErrorResponse): void => {
            this.errors = response.error.data;
          },
        })
      },
    })
  }

  protected readonly genres = genres;
}
