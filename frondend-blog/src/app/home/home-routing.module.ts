import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Routes } from '@angular/router';
import { HomeComponent } from './home/home.component';
import { PostDetailComponent } from './post-detail/post-detail.component';
import { PostsComponent } from './posts/posts.component';
import { ReservasComponent } from './reservas/reservas.component';
import { cliente } from '../models/cliente';
import { ClientesComponent } from './clientes/clientes.component';

const routes : Routes=[
  {path:'home',component:HomeComponent,
  children:[
    {path:'apartamentos',component:PostsComponent},
    {path:'reservas',component:ReservasComponent},
    {path:'clientes',component:ClientesComponent},

  ]
}
  
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
export class HomeRoutingModule { }
