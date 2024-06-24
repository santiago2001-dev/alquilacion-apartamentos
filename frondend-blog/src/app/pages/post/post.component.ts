import { Component, OnInit } from '@angular/core';
import swal from 'sweetalert2';
import { Apartamento } from 'src/app/models/apartamento';
import { PostService } from 'src/app/services/post.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-post',
  templateUrl: './post.component.html',
  styleUrls: ['./post.component.css']
})
export class PostComponent implements OnInit {
  listPost : Apartamento[] = []
  constructor(
    private router :Router,
    private postServ : PostService,

  ) { }

  ngOnInit(): void {
    this.getPost();
  }
  getPost(){
    this.postServ.getPost().subscribe(
      data=>{
        this.listPost = data
      },error=>{
        console.log(error);
      }
    )
    
  }




  }

