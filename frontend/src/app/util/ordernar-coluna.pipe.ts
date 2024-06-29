import {Pipe, PipeTransform} from '@angular/core';
import {orderBy} from "lodash";

@Pipe({
  name: 'ordernarColuna',
  standalone: true
})
export class OrdernarColunaPipe implements PipeTransform {

  transform(lista: any[], colunaNome: string, ordenar: 'asc' | 'desc'): any[] {
    return orderBy(lista, [colunaNome], [ordenar]);
  }
}
