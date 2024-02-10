import { Injectable } from '@angular/core';
import {HttpClient, HttpParams} from "@angular/common/http";
import {Observable} from "rxjs";
import {environment} from "../../environments/environment";

@Injectable({
  providedIn: 'root'
})
export class GoogleAPIService {
  apiUrl: string = 'https://maps.googleapis.com/maps/api/geocode/json';

  constructor(
    private http: HttpClient,
  ) { }

  public getCoordinates(address: string): Observable<any[]> {
    const params = new HttpParams()
      .set('address', address)
      .set('key', environment.GOOGLE_API_KEY);

    return this.http.get<any[]>(`${this.apiUrl}`, {params});
  }
}
