import {Component, OnInit} from '@angular/core';
import {DropdownComponent} from "../../shared/dropdown/dropdown.component";
import {JsonPipe, NgIf} from "@angular/common";
import {FormControl, FormGroup, ReactiveFormsModule, Validators} from "@angular/forms";
import {SubmitButtonComponent} from "../../shared/submit-button/submit-button.component";
import {TextInputComponent} from "../../shared/text-input/text-input.component";
import {TextareaInputComponent} from "../../shared/textarea-input/textarea-input.component";
import {ActivatedRoute, Router} from "@angular/router";
import {dateRelativeToTodayValidator} from "../../../validators/dateRelativeToTodayValidator";
import {HttpErrorResponse} from "@angular/common/http";
import {NoteService} from "../../../services/note.service";
import {CategoryService} from "../../../services/category.service";
import {AuthService} from "../../../services/auth.service";
import {DatetimeInputComponent} from "../../shared/datetime-input/datetime-input.component";

@Component({
  selector: 'app-note-form',
  standalone: true,
  imports: [
    DropdownComponent,
    NgIf,
    ReactiveFormsModule,
    SubmitButtonComponent,
    TextInputComponent,
    TextareaInputComponent,
    DatetimeInputComponent,
    JsonPipe
  ],
  providers: [
    NoteService,
    CategoryService,
  ],
  templateUrl: './note-form.component.html',
  styleUrl: './note-form.component.css'
})
export class NoteFormComponent implements OnInit {
  public errors: any = {};
  public editing: boolean = false
  public categories: any = {};
  public note: any = {};
  public formLoaded: boolean = false;

  constructor(
    public noteService: NoteService,
    public categoryService: CategoryService,
    public authService: AuthService,
    private router: Router,
    private route: ActivatedRoute,
  ) {}

  public editForm: FormGroup = new FormGroup({
    title: new FormControl('', [Validators.required, Validators.minLength(5), Validators.maxLength(50)]),
    content: new FormControl('', [Validators.required, Validators.maxLength(500)]),
    priority: new FormControl('', [Validators.required, Validators.min(1), Validators.max(5)]),
    deadline: new FormControl('', [Validators.required, dateRelativeToTodayValidator('after')]),
    tags: new FormControl('', [Validators.required, Validators.maxLength(200)]),
    visibility: new FormControl('', [Validators.required]),
    category: new FormControl('', [Validators.required]),
  });

  public ngOnInit() {
    this.getDefaultValues()
  }

  public getDefaultValues() {
    if (this.authService.getAuthToken() && this.authService.getLukaAuthToken()) {
      this.categoryService.allCategories(this.authService.getLukaLoggedUser().id).subscribe({
        next: (response: any) => {
          this.categories = response.data.categories.map((item: any) => ({
            key: item.id,
            value: item.title,
          }));

          this.route.params.subscribe(params => {
            const id = params['id'];

            if (id) {
              this.editing = true;
              this.noteService.getNoteById(id).subscribe({
                next: (response: any ) => {
                  this.note = response.data.note;

                  this.editForm.patchValue({
                    title: this.note.title,
                    content: this.note.content,
                    priority: this.note.priority,
                    deadline: this.note.deadline,
                    tags: this.note.tags,
                    visibility: this.note.public,
                    category: this.note.category_id,
                  })

                  this.formLoaded = true;
                },
                error: (response: HttpErrorResponse): void => {
                  this.router.navigate(['/notes']).then(r => {});
                },
              })
            } else {
              this.formLoaded = true;
            }
          })
        }
      })
    } else {
      this.router.navigate(['/login']).then(r => {});
    }
  }

  public onSubmit() {
    const noteData: any = {
      title: this.editForm.value.title,
      content: this.editForm.value.content,
      priority: this.editForm.value.priority,
      deadline: this.editForm.value.deadline,
      tags: this.editForm.value.tags,
      public: this.editForm.value.visibility,
      category_id: this.editForm.value.category,
      user_id: this.authService.getLukaLoggedUser().id,
    }

    if (this.editing) {
      noteData.id = this.note.id;

      this.noteService.editNote(noteData).subscribe({
        next: (response: any) => { this.router.navigate(['/notes']).then(r => {}); },
        error: (response: HttpErrorResponse): void => {
          this.errors = response.error.data;
        },
      })
    } else {
      this.noteService.addNote(noteData).subscribe({
        next: (response: any) => { this.router.navigate(['/notes']).then(r => {}); },
        error: (response: HttpErrorResponse): void => {
          this.errors = response.error.data;
        },
      })
    }
  }
}
