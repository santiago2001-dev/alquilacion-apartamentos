import { Component, OnInit } from '@angular/core';
import { ReservaList } from 'src/app/models/reservas';
import { PostService } from 'src/app/services/post.service';

@Component({
  selector: 'app-reservas',
  templateUrl: './reservas.component.html',
  styleUrls: ['./reservas.component.css']
})
export class ReservasComponent implements OnInit {
  listPost : ReservaList[] = []

  constructor(
    private postServ : PostService,

  ) { }

  ngOnInit(): void {
    this.getReserva()
  }


  getReserva(){
    this.postServ.getReserva().subscribe(
      data=>{
        this.listPost = data.data
      },error=>{
        console.log(error);
      }
    )
    
  }
}
