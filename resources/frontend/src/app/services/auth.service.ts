import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root',
})
export class AuthService {
  private authToken: string | null = null;
  private lukaAuthToken: string | null = null;
  private loggedUser: any = null;
  private lukaLoggedUser: any = null;

  constructor() {}

  setAuthToken(token: string | null): void {
    this.authToken = token;
  }

  getAuthToken(): string | null {
    return this.authToken;
  }

  setLukaAuthToken(token: string | null): void {
    this.lukaAuthToken = token;
  }

  getLukaAuthToken(): string | null {
    return this.lukaAuthToken;
  }


  setLoggedUser(user: any | null): void {
    this.loggedUser = user;
  }

  getLoggedUser(): any | null {
    return this.loggedUser;
  }

  setLukaLoggedUser(user: any | null): void {
    this.lukaLoggedUser = user;
  }

  getLukaLoggedUser(): any | null {
    return this.lukaLoggedUser;
  }
}
