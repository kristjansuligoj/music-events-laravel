import { Injectable } from '@angular/core';
import {environment} from "../../environments/environment";
import {HttpClient} from "@angular/common/http";
import {Observable} from "rxjs";
import {getFilterQuery} from "../helpers/functions";

@Injectable({
  providedIn: 'root'
})
export class SongService {
  apiUrl: string = environment.API_URL + "/songs";
  constructor(
    private http: HttpClient,
  ) {}

  public paginatedSongs(url: string): Observable<any[]> {
    return this.http.get<any[]>(url);
  }
  public allSongs(keyword: string, filter: any): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}${getFilterQuery(keyword, filter)}`);
  }

  public getSongById(id: string): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/${id}`);
  }

  public addSong(songData: any): Observable<any[]> {
    return this.http.post<any[]>(`${this.apiUrl}/add`, songData);
  }

  public editSong(songData: any): Observable<any[]> {
    return this.http.patch<any[]>(`${this.apiUrl}/edit/${songData.id}`, songData);
  }

  public removeSong(id: string): Observable<any[]> {
    return this.http.delete<any[]>(`${this.apiUrl}/remove/${id}`);
  }
}
