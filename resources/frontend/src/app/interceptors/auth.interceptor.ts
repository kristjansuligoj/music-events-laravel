import { Injectable } from '@angular/core';
import {
  HttpInterceptor,
  HttpRequest,
  HttpHandler,
  HttpEvent,
} from '@angular/common/http';
import { Observable } from 'rxjs';
import { AuthService } from '../services/auth.service';

@Injectable()
export class AuthInterceptor implements HttpInterceptor {
  constructor(private authService: AuthService) {}

  /**
   * Intercepts HTTP requests and sets an authorization header based on the request's URL
   *
   * @param { HttpRequest<any> } request
   * @param { HttpHandler } next
   * @return Observable<HttpEvent<any>>
   */
  intercept(
    request: HttpRequest<any>,
    next: HttpHandler
  ): Observable<HttpEvent<any>> {
    // Google Maps API does not allow Authorization header in request
    if (request.url.includes('/maps/api/geocode/json')) {
      return next.handle(request);
    }

    let authToken: string | null = "";
    // Based on request's URL, set the correct authentication token
    if (request.url.includes('/api/notes') || request.url.includes('/api/categories')) {
      authToken = this.authService.getLukaAuthToken();
    } else {
      authToken = this.authService.getAuthToken();
    }

    // Add Authorization header if an authentication token is available
    if (authToken) {
      request = request.clone({
        setHeaders: {
          Authorization: `Bearer ${authToken}`,
        },
      });
    }

    return next.handle(request);
  }
}
