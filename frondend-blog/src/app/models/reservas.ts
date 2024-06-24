// reserva.model.ts













// reserva.model.ts

export class ReservaAdd {
    fecha_inicio: string;
    fecha_fin: string;
    apartamento: number;
    cliente: number;
   
    constructor(
        fecha_inicio: string,
        fecha_fin: string,
        apartamento: number,
        cliente: number,
       
    ) {
        this.fecha_inicio = fecha_inicio;
        this.fecha_fin = fecha_fin;
        this.apartamento = apartamento;
        this.cliente = cliente;
        
    }
}




export class ReservaList {
    id_reserva: string;
    fecha_inicio: string;
    fecha_fin: string;
    apartamento: Apartamento;
    cliente: Cliente;
    alquiler: string;
    tasa_servicio: string;

    constructor(
        id_reserva: string,
        fecha_inicio: string,
        fecha_fin: string,
        apartamento: Apartamento,
        cliente: Cliente,
        alquiler: string,
        tasa_servicio: string
    ) {
        this.id_reserva = id_reserva;
        this.fecha_inicio = fecha_inicio;
        this.fecha_fin = fecha_fin;
        this.apartamento = apartamento;
        this.cliente = cliente;
        this.alquiler = alquiler;
        this.tasa_servicio = tasa_servicio;
    }
}

export class Apartamento {
    id_apartamento: string;
    nombre: string;
    direccion: string;
    tipo_apartamento: string;
    id_ciudad: string;
    id_tarifa: string;
    imagen: string;

    constructor(
        id_apartamento: string,
        nombre: string,
        direccion: string,
        tipo_apartamento: string,
        id_ciudad: string,
        id_tarifa: string,
        imagen: string
    ) {
        this.id_apartamento = id_apartamento;
        this.nombre = nombre;
        this.direccion = direccion;
        this.tipo_apartamento = tipo_apartamento;
        this.id_ciudad = id_ciudad;
        this.id_tarifa = id_tarifa;
        this.imagen = imagen;
    }
}

export class Cliente {
    id_cliente: string;
    nombre: string;
    email: string;

    constructor(id_cliente: string, nombre: string, email: string) {
        this.id_cliente = id_cliente;
        this.nombre = nombre;
        this.email = email;
    }
}
