import {Component, OnInit} from '@angular/core';
import {PessoaService} from "../services/pessoa.service";
import {Pessoa} from "../dtos/pessoa";
import {FormsModule, ReactiveFormsModule} from "@angular/forms";
import {NgForOf, NgIf} from "@angular/common";
import {ToastrService} from "ngx-toastr";
import {catchError, EMPTY} from "rxjs";
import {Telefone} from "../dtos/telefone";
import {OrdernarColunaPipe} from "../util/ordernar-coluna.pipe";
import {NgxMaskDirective} from "ngx-mask";

@Component({
  selector: 'app-tela-inicio',
  standalone: true,
  imports: [
    FormsModule,
    NgForOf,
    NgIf,
    OrdernarColunaPipe,
    NgxMaskDirective,
    ReactiveFormsModule
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
  editando: boolean = false;
  nomeColuna: string = 'nome';
  ordernar: 'asc' | 'desc' = 'asc';

  constructor(private pessoaService: PessoaService, private toastr: ToastrService) {
  }

  ngOnInit() {
    this.pessoa.telefones = Array.from({length: 5}, () => ({id: 0, telefone: '', descricao: ''}));
    this.getPessoas();
  }

  getPessoas() {
    this.pessoaService.getPessoas()
      .pipe(
        catchError(err => {
          console.error(err);
          this.toastr.error(err.error.message, 'Erro!');
          return EMPTY;
        })
      )
      .subscribe(pessoas => {
        this.pessoas = pessoas;
      });
  }

  criarPessoa() {

    if (!this.verificaSeTodosOsDadosEstaoPreenchidos()) {
      this.toastr.error('Preencha todos os campos!', 'Erro!');
      return;
    }

    this.pessoa.telefones = this.pessoa.telefones.filter(t => t.telefone !== '');
    this.pessoaService.newPessoa(this.pessoa)
      .pipe(
        catchError(err => {
          this.toastr.error(err.error.message, 'Erro!');
          return EMPTY;
        })
      )
      .subscribe(pessoa => {
        this.toastr.success('Pessoa criada com sucesso!', 'Sucesso!');
        this.getPessoas();
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

  retiraTelefonesVazios(telefones: Telefone[]): Telefone[] {
    return telefones.filter(t => t.telefone !== '');
  }

  atualizaPessoa() {

    if (!this.verificaSeTodosOsDadosEstaoPreenchidos()) {
      this.toastr.error('Preencha todos os campos!', 'Erro!');
      return;
    }

    this.pessoa.telefones = this.retiraTelefonesVazios(this.pessoa.telefones);
    this.pessoaService.putPessoa(this.pessoa)
      .pipe(
        catchError(err => {
          console.error(err);
          this.toastr.error(err.error.message, 'Erro!');
          return EMPTY;
        })
      )
      .subscribe(pessoa => {
        this.toastr.success('Pessoa atualizada com sucesso!', 'Sucesso!');
        this.getPessoas();
      });

    this.pessoa = this.pessoaVazia();
    this.pessoa.telefones = Array.from({length: 5}, () => ({id: 0, telefone: '', descricao: ''}));
    this.editando = false;
  }

  editarPessoa(id: number) {
    this.pessoa = this.pessoas.find(p => p.id === id) || this.pessoaVazia();

    if (this.pessoa != this.pessoaVazia()) {
      this.editando = true;
      this.pessoa.telefones.filter(t => t.telefone === '').forEach(t => t.telefone = '');
      if (this.pessoa.telefones.length < 5) {
        this.pessoa.telefones = this.pessoa.telefones.concat(Array.from({length: 5 - this.pessoa.telefones.length}, () => ({id: 0, telefone: '', descricao: ''})));
      }
    }
  }

  deletarPessoa(id: number) {
    this.pessoaService.deletePessoa(id)
      .pipe(
        catchError(err => {
          console.error(err);
          this.toastr.error(err.error.message, 'Erro!');
          return EMPTY;
        })
      )
      .subscribe(() => {
        this.toastr.success('Pessoa deletada com sucesso!', 'Sucesso!');
        this.getPessoas();
      });
  }

  sort(nome: string) {
    this.nomeColuna = nome;
    this.ordernar = this.ordernar === 'asc' ? 'desc' : 'asc';
  }

  private verificaSeTodosOsDadosEstaoPreenchidos(): boolean {
    return this.pessoa.nome !== '' && this.pessoa.cpf !== '' && this.pessoa.rg !== '' && this.pessoa.cep !== ''
      && this.pessoa.logradouro !== '' && this.pessoa.complemento !== '' && this.pessoa.setor !== ''
      && this.pessoa.cidade !== '' && this.pessoa.uf !== '';
  }
}
