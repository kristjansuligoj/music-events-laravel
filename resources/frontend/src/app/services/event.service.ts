import { Injectable } from '@angular/core';
import {environment} from "../../environments/environment";
import {HttpClient} from "@angular/common/http";
import {Observable} from "rxjs";
import {getFilterQuery} from "../helpers/functions";

@Injectable({
  providedIn: 'root'
})
export class EventService {
  apiUrl: string = environment.API_URL + "/events";
  constructor(
    private http: HttpClient,
  ) {}

  public paginatedEvents(url: string): Observable<any[]> {
    return this.http.get<any[]>(url);
  }
  public allEvents(keyword: string, filter: any): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}${getFilterQuery(keyword, filter)}`);
  }

  public getEventById(id: string): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/${id}`);
  }

  public addEvent(eventData: any): Observable<any[]> {
    return this.http.post<any[]>(`${this.apiUrl}/add`, eventData);
  }

  public editEvent(eventData: any): Observable<any[]> {
    return this.http.patch<any[]>(`${this.apiUrl}/edit/${eventData.id}`, eventData);
  }

  public removeEvent(id: string): Observable<any[]> {
    return this.http.delete<any[]>(`${this.apiUrl}/remove/${id}`);
  }

  public userEventHistory(userId: string): Observable<any[]> {
    return this.http.delete<any[]>(`${this.apiUrl}/history/${userId}`);
  }

  public addUserToEvent(eventId: string, userId: string): Observable<any[]> {
    return this.http.post<any[]>(`${this.apiUrl}/${eventId}/add-user/${userId}`, {});
  }

  public removeUserFromEvent(eventId: string, userId: string): Observable<any[]> {
    return this.http.post<any[]>(`${this.apiUrl}/${eventId}/remove-user/${userId}`, {});
  }
}
