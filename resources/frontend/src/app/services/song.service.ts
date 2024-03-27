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

  /**
   * Fetches all songs using pagination (1 page)
   *
   * @param { string } url
   */
  public paginatedSongs(url: string): Observable<any[]> {
    return this.http.get<any[]>(url);
  }

  /**
   * Fetches all songs
   *
   * @param { string } keyword
   * @param { any } filter
   * @param { boolean } unpaginated
   */
  public allSongs(keyword: string = "", filter: any = null, unpaginated: boolean = false): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}${getFilterQuery(keyword, filter, unpaginated)}`);
  }

  /**
   * Fetches song with the given id
   *
   * @param { string } id
   */
  public getSongById(id: string): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/${id}`);
  }

  /**
   * Adds a song
   *
   * @param { any } songData
   */
  public addSong(songData: any): Observable<any[]> {
    return this.http.post<any[]>(`${this.apiUrl}/add`, songData);
  }

  /**
   * Edits a song
   *
   * @param { any } songData
   */
  public editSong(songData: any): Observable<any[]> {
    return this.http.patch<any[]>(`${this.apiUrl}/edit/${songData.id}`, songData);
  }

  /**
   * Removes a song with the given id
   *
   * @param { string } id
   */
  public removeSong(id: string): Observable<any[]> {
    return this.http.delete<any[]>(`${this.apiUrl}/remove/${id}`);
  }
}
