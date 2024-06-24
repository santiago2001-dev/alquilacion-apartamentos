export class cliente {
  id_cliente?: string;
  nombre: string;
  email: string;

  constructor(id_cliente: string, nombre: string, email: string) {
    this.email =  email,
    this.nombre =  nombre,
    this.id_cliente = id_cliente
  }
}
