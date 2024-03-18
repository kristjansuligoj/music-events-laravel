import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root',
})
export class AuthService {
  private authToken: string | null = null;
  private lukaAuthToken: string | null = null;
  private loggedUser: any = null;
  private lukaLoggedUser: any = null;

  /**
   * Sets auth token
   *
   * @param { string | null } token
   */
  setAuthToken(token: string | null): void {
    this.authToken = token;
  }

  /**
   * Gets auth token
   */
  getAuthToken(): string | null {
    return this.authToken;
  }

  /**
   * Sets auth token for Lukas app
   *
   * @param { string | null } token
   */
  setLukaAuthToken(token: string | null): void {
    this.lukaAuthToken = token;
  }

  /**
   * Gets auth token for Lukas app
   */
  getLukaAuthToken(): string | null {
    return this.lukaAuthToken;
  }

  /**
   * Sets logged user
   *
   * @param { any | null } user
   */
  setLoggedUser(user: any | null): void {
    this.loggedUser = user;
  }

  /**
   * Gets logged user
   */
  getLoggedUser(): any | null {
    return this.loggedUser;
  }

  /**
   * Sets logged user for Lukas app
   *
   * @param { any | null } user
   */
  setLukaLoggedUser(user: any | null): void {
    this.lukaLoggedUser = user;
  }

  /**
   * Gets logged user for Lukas app
   */
  getLukaLoggedUser(): any | null {
    return this.lukaLoggedUser;
  }
}
