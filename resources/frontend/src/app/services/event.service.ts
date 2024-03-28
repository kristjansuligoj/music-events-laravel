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

  /**
   * Fetches all events using pagination (1 page)
   *
   * @param { string } url
   */
  public paginatedEvents(url: string): Observable<any[]> {
    return this.http.get<any[]>(url);
  }

  /**
   * Fetches all events
   *
   * @param { string } keyword
   * @param { any } filter
   * @param { boolean } unpaginated
   */
  public allEvents(keyword: string = "", filter: any = null, unpaginated: boolean = false): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}${getFilterQuery(keyword, filter, unpaginated)}`);
  }

  /**
   * Fetches event with the given id
   *
   * @param { string } id
   */
  public getEventById(id: string): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/${id}`);
  }

  /**
   * Adds an event
   *
   * @param { any } eventData
   */
  public addEvent(eventData: any): Observable<any[]> {
    return this.http.post<any[]>(`${this.apiUrl}/add`, eventData);
  }

  /**
   * Edits an event
   *
   * @param { any } eventData
   */
  public editEvent(eventData: any): Observable<any[]> {
    return this.http.patch<any[]>(`${this.apiUrl}/edit/${eventData.id}`, eventData);
  }

  /**
   * Removes an event with the given id
   *
   * @param { string } id
   */
  public removeEvent(id: string): Observable<any[]> {
    return this.http.delete<any[]>(`${this.apiUrl}/remove/${id}`);
  }

  /**
   * Fetches events the user has attended
   *
   * @param { string } userId
   */
  public userEventHistory(userId: string): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/history/${userId}`);
  }

  /**
   * Adds a user as an attendee to an event
   *
   * @param { string } eventId
   * @param { string } userId
   */
  public addUserToEvent(eventId: string, userId: string): Observable<any[]> {
    return this.http.post<any[]>(`${this.apiUrl}/${eventId}/add-user/${userId}`, {});
  }

  /**
   * Removes a user as an attendee from an event
   *
   * @param { string } eventId
   * @param { string } userId
   */
  public removeUserFromEvent(eventId: string, userId: string): Observable<any[]> {
    return this.http.post<any[]>(`${this.apiUrl}/${eventId}/remove-user/${userId}`, {});
  }
}
