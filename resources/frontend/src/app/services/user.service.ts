import { Injectable } from '@angular/core';
import {environment} from "../../environments/environment";
import {HttpClient} from "@angular/common/http";
import {Observable} from "rxjs";

@Injectable({
  providedIn: 'root'
})
export class UserService {
  apiUrl: string = environment.apiUrl;
  constructor(private http: HttpClient) {}

  public login(userData: any): Observable<any[]> {
    return this.http.post<any[]>(`${this.apiUrl}/login`, userData);
  }

  public logout(): Observable<any[]> {
    return this.http.post<any[]>(`${this.apiUrl}/logout`, null);
  }

  public register(userData: any): Observable<any[]> {
    return this.http.post<any[]>(`${this.apiUrl}/register`, userData);
  }
}
