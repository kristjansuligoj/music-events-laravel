import { Injectable } from '@angular/core';
import {environment} from "../../environments/environment";
import {HttpClient} from "@angular/common/http";
import {Observable} from "rxjs";

@Injectable({
  providedIn: 'root'
})
export class NoteService {
  apiUrl: string = environment.LUKA_API_URL + "/notes";

  constructor(
    private http: HttpClient,
  ) {}

  /**
   * Fetches all notes using pagination (1 page)
   *
   * @param { string } url
   */
  public paginatedNotes(url: string): Observable<any[]> {
    return this.http.get<any[]>(url);
  }

  /**
   * Fetches all notes of the authorized user
   */
  public allNotes(): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/byUser`);
  }

  /**
   * Fetches event with the given id
   *
   * @param { string } id
   */
  public getNoteById(id: string): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/${id}`);
  }

  /**
   * Adds a note
   *
   * @param { any } noteData
   */
  public addNote(noteData: any): Observable<any[]> {
    return this.http.post<any[]>(`${this.apiUrl}`, noteData);
  }

  /**
   * Edits a note
   *
   * @param { any } noteData
   */
  public editNote(noteData: any): Observable<any[]> {
    return this.http.patch<any[]>(`${this.apiUrl}/edit/${noteData.id}`, noteData);
  }

  /**
   * Remove a note with the given id
   *
   * @param id
   */
  public removeNote(id: string): Observable<any[]> {
    return this.http.delete<any[]>(`${this.apiUrl}/remove/${id}`);
  }
}
