import { Injectable } from '@angular/core';
import {environment} from "../../environments/environment";
import {HttpClient} from "@angular/common/http";
import {Observable} from "rxjs";

@Injectable({
  providedIn: 'root'
})
export class ImageService {
  apiUrl: string = environment.API_URL + '/images'

  constructor(
    private http: HttpClient,
  ) { }

  /**
   * Uploads the given image
   *
   * @param { any } image
   */
  public uploadImage(image: any): Observable<any[]> {
    return this.http.post<any[]>(`${this.apiUrl}`, image);
  }

}
