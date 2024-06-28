import {Component, OnInit} from '@angular/core';
import {PessoaService} from "../services/pessoa.service";
import {Pessoa} from "../dtos/pessoa";
import {FormsModule} from "@angular/forms";
import {NgForOf} from "@angular/common";
import {ToastrService} from "ngx-toastr";
import {catchError, EMPTY} from "rxjs";

@Component({
  selector: 'app-tela-inicio',
  standalone: true,
  imports: [
    FormsModule,
    NgForOf
  ],
  templateUrl: './tela-inicio.component.html',
  styleUrl: './tela-inicio.component.scss'
})
export class TelaInicioComponent implements OnInit {

  pessoa: Pessoa = {
    id: 0,
    nome: '',
    cpf: '',
    rg: '',
    cep: '',
    logradouro: '',
    complemento: '',
    setor: '',
    cidade: '',
    uf: '',
    telefones: []
  }

  pessoas: Pessoa[] = [];

  constructor(private pessoaService: PessoaService, private toastr: ToastrService) {
  }

  ngOnInit() {
    this.pessoa.telefones = Array.from({length: 5}, () => ({id: 0, telefone: '', descricao: ''}));

    this.pessoaService.getPessoas()
      .pipe(
        catchError(err => {
          console.error(err);
          this.toastr.error('Erro ao buscar pessoas!', 'Erro!');
          return EMPTY;
        })
      )
      .subscribe(pessoas => {
        this.pessoas = pessoas;
    });
  }

  criarPessoa() {
    this.pessoa.telefones = this.pessoa.telefones.filter(t => t.telefone !== '');
    this.pessoaService.newPessoa(this.pessoa)
      .pipe(
        catchError(err => {
          console.error(err);
          this.toastr.error(err.error.message, 'Erro!');
          return EMPTY;
        })
      )
      .subscribe(pessoa => {
      this.toastr.success('Pessoa criada com sucesso!', 'Sucesso!');
    });

    this.pessoa = this.pessoaVazia();
    this.pessoa.telefones = Array.from({length: 5}, () => ({id: 0, telefone: '', descricao: ''}));
  }

  verificaQuantidadeTelefones() {
    const telefones = this.pessoa.telefones.filter(t => t.telefone === '').length == 0;

    if (telefones) {
      this.pessoa.telefones.push({id: 0, telefone: '', descricao: ''});
    }
  }

  private pessoaVazia(): Pessoa {
    return {
      id: 0,
      nome: '',
      cpf: '',
      rg: '',
      cep: '',
      logradouro: '',
      complemento: '',
      setor: '',
      cidade: '',
      uf: '',
      telefones: []
    }
  }
}
