export class Apartamento {
    id_apartamento: string;
    nombre: string;
    direccion: string;
    tipo_apartamento: string;
    id_ciudad: string;
    id_tarifa: string;
    imagen: string;
    ciudad: Ciudad;
    tarifa: Tarifa;

    constructor(
        id_apartamento: string,
        nombre: string,
        direccion: string,
        tipo_apartamento: string,
        id_ciudad: string,
        id_tarifa: string,
        imagen: string,
        ciudad: Ciudad,
        tarifa: Tarifa
    ) {
        this.id_apartamento = id_apartamento;
        this.nombre = nombre;
        this.direccion = direccion;
        this.tipo_apartamento = tipo_apartamento;
        this.id_ciudad = id_ciudad;
        this.id_tarifa = id_tarifa;
        this.imagen = imagen;
        this.ciudad = ciudad;
        this.tarifa = tarifa;
    }
}












export class ApartamentoAdd {
    nombre: string;
    direccion: string;
    tipo_apartamento: number;
    id_ciudad: number;
    id_tarifa: number;
    imagen: string;
    ciudad: number;
    tarifa: number;

    constructor(
        nombre: string,
        direccion: string,
        tipo_apartamento: number,
        id_ciudad: number,
        id_tarifa: number,
        imagen: string,
        ciudad: number,
        tarifa: number
    ) {
        this.nombre = nombre;
        this.direccion = direccion;
        this.tipo_apartamento = tipo_apartamento;
        this.id_ciudad = id_ciudad;
        this.id_tarifa = id_tarifa;
        this.imagen = imagen;
        this.ciudad = ciudad;
        this.tarifa = tarifa;
    }
}



export class Ciudad {
    id_ciudad: string;
    nombre: string;

    constructor(id_ciudad: string, nombre: string) {
        this.id_ciudad = id_ciudad;
        this.nombre = nombre;
    }
}


export class Tarifa {
    id_tipo_tarifa: string;
    name: string;
    fecha_inicio: string;
    fecha_fin: string;
    valor_tarifa: string;

    constructor(
        id_tipo_tarifa: string,
        name: string,
        fecha_inicio: string,
        fecha_fin: string,
        valor_tarifa: string
    ) {
        this.id_tipo_tarifa = id_tipo_tarifa;
        this.name = name;
        this.fecha_inicio = fecha_inicio;
        this.fecha_fin = fecha_fin;
        this.valor_tarifa = valor_tarifa;
    }
}
