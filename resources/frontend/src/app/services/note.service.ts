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

  public paginatedNotes(url: string): Observable<any[]> {
    return this.http.get<any[]>(url);
  }

  public allNotes(): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/byUser`);
  }

  public getNoteById(id: string): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/${id}`);
  }

  public addNote(noteData: any): Observable<any[]> {
    return this.http.post<any[]>(`${this.apiUrl}`, noteData);
  }

  public editNote(noteData: any): Observable<any[]> {
    return this.http.patch<any[]>(`${this.apiUrl}/edit/${noteData.id}`, noteData);
  }

  public removeNote(id: string): Observable<any[]> {
    return this.http.delete<any[]>(`${this.apiUrl}/remove/${id}`);
  }
}
