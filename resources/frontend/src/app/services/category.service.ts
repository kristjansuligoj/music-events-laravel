import { Injectable } from '@angular/core';
import {environment} from "../../environments/environment";
import {HttpClient} from "@angular/common/http";
import {Observable} from "rxjs";

@Injectable({
  providedIn: 'root'
})
export class CategoryService {
  apiUrl: string = environment.LUKA_API_URL + "/categories";

  constructor(
    private http: HttpClient,
  ) {}

  /**
   * Fetches all categories for the given user
   *
   * @param { string } userId
   */
  public allCategories(userId: string): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}`);
  }
}
