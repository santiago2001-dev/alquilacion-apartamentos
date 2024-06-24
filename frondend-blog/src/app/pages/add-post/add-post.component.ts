import { Component, OnInit } from '@angular/core';
import { FormBuilder,Validators,FormGroup } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { postadd } from 'src/app/models/post';
import { autorget } from 'src/app/models/autor';
import swal from 'sweetalert2';
import { PostService } from 'src/app/services/post.service';
import { AutoresService } from 'src/app/services/autores.service';
import { Apartamento, Ciudad } from 'src/app/models/apartamento';
import { cliente } from 'src/app/models/cliente';
import { ReservaAdd } from 'src/app/models/reservas';
@Component({
  selector: 'app-add-post',
  templateUrl: './add-post.component.html',
  styleUrls: ['./add-post.component.css']
})
export class AddPostComponent implements OnInit {
listAutors : autorget[] = []
listApartamentos :  Apartamento[] = []
listCliente : cliente[] = []

postForm : FormGroup
Titulo = 'crear post'
  constructor(
    private autroserv : AutoresService,
    private postServ  : PostService,
    private fb : FormBuilder,
    private router : Router,
    
  ) { 
    this.postForm =  this.fb.group({
      fechaInicio:['',Validators.required],
      fechaFin:['',Validators.required],
      Apartamento:['',Validators.required],
      cliente:['',Validators.required],

    })
  }

  ngOnInit(): void {
    this.getPost()
    this.getcliente()
   
  }


  getPost(){
    this.postServ.getPost().subscribe(
      data=>{
        this.listApartamentos = data.data
      },error=>{
        console.log(error);
      }
    )
    
  }


  
  getcliente(){
    this.postServ.getclientes().subscribe(
      data=>{
        this.listCliente = data
      },error=>{
        console.log(error);
      }
    )

    }




    addPost(){
      if(this.postForm.invalid){
         swal.fire({
          icon: 'error',
          title: 'los campos son obligatorios',
        
        })
      }else{

        const fechaInicio = new Date(this.postForm.get('fechaInicio')?.value).toISOString().split('T')[0];
        const fechaFin = new Date(this.postForm.get('fechaFin')?.value).toISOString().split('T')[0];
        const post :ReservaAdd = {
          fecha_inicio :  fechaInicio,// this.postForm.get('fechaInicio')?.value,
          fecha_fin : fechaFin,//this.postForm.get('fechaFin')?.value,
          apartamento : this.postForm.get('Apartamento')?.value,
          cliente : this.postForm.get('cliente')?.value,
          
        }
      
          this.postServ.addPost(post).subscribe(
            data=>{
              swal.fire({
                position: 'center',
                icon: 'success',
                title: 'reserva creado correctamente',
                showConfirmButton: false,
                timer: 1500
              })
              this.router.navigate(['/home/reservas']);
    
    
            },error=>{
              swal.fire({
                icon: 'error',
                title: error.message,
              
              })
            }


          )
        }
    }

  }
 



