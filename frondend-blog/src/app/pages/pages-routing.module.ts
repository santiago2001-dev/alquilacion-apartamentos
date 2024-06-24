import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Router, RouterModule, Routes } from '@angular/router';
import { PagesComponent } from './pages.component';
import { PostComponent } from './post/post.component';
import { AddPostComponent } from './add-post/add-post.component';
import { AddAutorComponent } from './add-autor/add-autor.component';
import { AutorComponent } from './autor/autor.component';
import { LoginGuard } from '../guards/login.guard';

const routes : Routes =[
  {path :'dashboard',component: PagesComponent,
  children:[
    {path:'crear-reserva',component:AddPostComponent},
    {path:'update-post/:id',component:AddPostComponent},

    {path:'add-autor',component:AddAutorComponent},
    {path:'autor',component:AutorComponent},


  ]},
  
  
]

@NgModule({
  declarations: [],
  imports: [
    CommonModule,
    RouterModule.forChild(routes)
  ],
  exports:[
    RouterModule
  ]
})
export class PagesRoutingModule { }
