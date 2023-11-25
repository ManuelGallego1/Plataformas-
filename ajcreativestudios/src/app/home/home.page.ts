import { Component, OnInit } from '@angular/core';
import { UserService } from '../user.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-home',
  templateUrl: 'home.page.html',
  styleUrls: ['home.page.scss'],
})
export class HomePage implements OnInit {
  user: string = '';
  pass: string = '';
  message: string = '';
  users: any[] = [];

  constructor(private userService: UserService, private router: Router) {}

  ngOnInit() {
    this.userService.getUsers().subscribe((data: any) => {
      this.users = data;
    });
  }

  login() {
    const user = this.users.find((u) => u.user === this.user && u.pass === this.pass);

    if (user) {
      // Credenciales válidas, redirigir a la página de dashboard
      if(this.user === 'admin' && this.pass === '12345'){
        this.router.navigate(['/dashboard']);
      }else{
        this.router.navigate(['/user-view']);
      }
     
      
    } else {
      // Credenciales inválidas, puedes mostrar un mensaje de error o realizar otra acción
      this.message = 'Credenciales incorrectas, intente nuevamente.'
    }
  }
}