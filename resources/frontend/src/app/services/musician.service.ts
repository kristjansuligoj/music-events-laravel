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

  public paginatedMusicians(url: string): Observable<any[]> {
    return this.http.get<any[]>(url);
  }
  public allMusicians(keyword: string, filter: any): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}${getFilterQuery(keyword, filter)}`);
  }

  public allMusiciansUnpaginated(): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/unpaginated`);
  }

  public getMusicianById(id: string): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/${id}`);
  }

  public addMusician(musicianData: any): Observable<any[]> {
    return this.http.post<any[]>(`${this.apiUrl}/add`, musicianData);
  }

  public editMusicians(musicianData: any): Observable<any[]> {
    return this.http.patch<any[]>(`${this.apiUrl}/edit/${musicianData.id}`, musicianData);
  }

  public removeMusician(id: string): Observable<any[]> {
    return this.http.delete<any[]>(`${this.apiUrl}/remove/${id}`);
  }
}
