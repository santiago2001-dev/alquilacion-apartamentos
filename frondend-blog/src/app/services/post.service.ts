import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { environment } from 'src/environments/environment';
import { postadd } from '../models/post';
import { ReservaAdd } from '../models/reservas';

@Injectable({
  providedIn: 'root',
})
export class PostService {
  server = environment.servidor;

  constructor(private http: HttpClient) {}
  getPost(): Observable<any> {
    let url = `${this.server}apartamento`;
    return this.http.get(url);
  }

  addPost(post: ReservaAdd): Observable<any> {
    let url = `${this.server}reservas/create`;
    return this.http.post(url, post);
  }

  getReserva(): Observable<any> {
    let url = `${this.server}reservas`;
    return this.http.get(url);
  }

  getclientes(): Observable<any> {
    let url = `${this.server}clientes`;
    return this.http.get(url);
  }
}
