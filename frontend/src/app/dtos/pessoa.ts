import {Telefone} from "./telefone";

export interface Pessoa {
  id: number;
  nome: string;
  cpf: string;
  rg: string;
  cep: string;
  logradouro: string;
  complemento: string;
  setor: string;
  cidade: string;
  uf: string;
  telefones: Telefone[];
}

