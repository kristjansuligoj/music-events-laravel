import { Injectable } from '@angular/core';
import {environment} from "../../environments/environment";
import {HttpClient} from "@angular/common/http";
import {Observable} from "rxjs";

@Injectable({
  providedIn: 'root'
})
export class UserService {
  public apiUrl: string = environment.API_URL;
  public lukaApiUrl: string = environment.LUKA_API_URL;

  constructor(private http: HttpClient) {}

  /**
   * Logs the user in the system
   *
   * @param { any } userData
   * @param { boolean } lukaApp
   */
  public login(userData: any, lukaApp: boolean): Observable<any[]> {
    if (lukaApp) {
      return this.http.post<any[]>(`${this.lukaApiUrl}/tokens/authenticate`, userData);
    } else {
      return this.http.post<any[]>(`${this.apiUrl}/login`, userData);
    }
  }

  /**
   * Logs the user in the system with socials
   *
   * @param { string } tokenId
   * @param { string } social
   */
  public loginWithSocials(tokenId: string, social: string): Observable<any[]> {
    return this.http.post<any[]>(`${this.apiUrl}/loginWithSocials/${social}`, {'tokenId': tokenId});
  }

  /**
   * Logs the user out of the system
   */
  public logout(): Observable<any[]> {
    return this.http.post<any[]>(`${this.apiUrl}/logout`, null);
  }

  /**
   * Registers user to the site
   *
   * @param { any } userData
   */
  public register(userData: any): Observable<any[]> {
    return this.http.post<any[]>(`${this.apiUrl}/register`, userData);
  }

  /**
   * Resends email verification link
   *
   * @param { string } email
   */
  public resendVerificationEmail(email: string): Observable<any[]> {
    return this.http.post<any[]>(`${this.apiUrl}/verify-email/notification`, {email: email});
  }
}
