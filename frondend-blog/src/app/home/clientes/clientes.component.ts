import { Component, OnInit } from '@angular/core';
import { cliente } from 'src/app/models/cliente';
import { PostService } from 'src/app/services/post.service';

@Component({
  selector: 'app-clientes',
  templateUrl: './clientes.component.html',
  styleUrls: ['./clientes.component.css']
})
export class ClientesComponent implements OnInit {
 listClient : cliente[] = []
  constructor(
    private postServ : PostService,

  ) {
    
   }

  ngOnInit(): void {
    this.getcliente()
  }



  getcliente(){
    this.postServ.getclientes().subscribe(
      data=>{
        this.listClient = data
      },error=>{
        console.log(error);
      }
    )
    
  }
}
