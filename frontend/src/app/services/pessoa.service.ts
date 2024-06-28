import { Injectable } from '@angular/core';
import {Pessoa} from "../dtos/pessoa";
import {Observable} from "rxjs";
import {HttpClient} from "@angular/common/http";

@Injectable({
  providedIn: 'root'
})
export class PessoaService {

  url: string = 'http://127.0.0.1:34209/pessoa/';

  constructor(private httpClient: HttpClient) { }

  newPessoa(pessoa: Pessoa): Observable<Pessoa> {
    return this.httpClient.post<Pessoa>(this.url, pessoa);
  }

  getPessoas(): Observable<Pessoa[]> {
    return this.httpClient.get<Pessoa[]>(this.url);
  }

  putPessoa(pessoa: Pessoa): Observable<Pessoa> {
    return this.httpClient.put<Pessoa>(this.url + pessoa.id, pessoa);
  }

  deletePessoa(id: number): Observable<any> {
    return this.httpClient.delete(this.url + id);
  }
}
