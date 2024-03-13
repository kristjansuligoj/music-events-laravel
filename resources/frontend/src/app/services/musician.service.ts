import { Injectable } from '@angular/core';
import {environment} from "../../environments/environment";
import {HttpClient} from "@angular/common/http";
import {Observable} from "rxjs";
import {AuthInterceptor} from "../interceptors/auth.interceptor";
import {getFilterQuery} from "../helpers/functions";

@Injectable({
  providedIn: 'root'
})
export class MusicianService {
  apiUrl: string = environment.API_URL + "/musicians";

  constructor(
    private http: HttpClient,
  ) {}

  /**
   * Fetches all musicians using pagination (1 page)
   *
   * @param { string } url
   */
  public paginatedMusicians(url: string): Observable<any[]> {
    return this.http.get<any[]>(url);
  }

  /**
   * Fetches all musicians
   *
   * @param { string } keyword
   * @param { any } filter
   */
  public allMusicians(keyword: string, filter: any): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}${getFilterQuery(keyword, filter)}`);
  }

  /**
   * Fetches all musicians without pagination
   */
  public allMusiciansUnpaginated(): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/unpaginated`);
  }

  /**
   * Fetches musician with the given id
   *
   * @param { string } id
   */
  public getMusicianById(id: string): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/${id}`);
  }

  /**
   * Adds a musician
   *
   * @param { any } musicianData
   */
  public addMusician(musicianData: any): Observable<any[]> {
    return this.http.post<any[]>(`${this.apiUrl}/add`, musicianData);
  }

  /**
   * Edits a musician
   *
   * @param { any } musicianData
   */
  public editMusicians(musicianData: any): Observable<any[]> {
    return this.http.patch<any[]>(`${this.apiUrl}/edit/${musicianData.id}`, musicianData);
  }

  /**
   * Removes a musician with the given id
   *
   * @param id
   */
  public removeMusician(id: string): Observable<any[]> {
    return this.http.delete<any[]>(`${this.apiUrl}/remove/${id}`);
  }
}
