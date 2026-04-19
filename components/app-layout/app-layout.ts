import { Component } from '@angular/core';
import { RouterOutlet, RouterLink, RouterLinkActive } from '@angular/router';
import { CommonModule } from '@angular/common';
import { AuthService } from '../../services/auth';

@Component({
  selector: 'app-layout',
  standalone: true,
  imports: [RouterOutlet, RouterLink, RouterLinkActive, CommonModule],
  templateUrl: './app-layout.html',
  styleUrl: './app-layout.css'
})
export class AppLayoutComponent {

  sidebarOpen = false;

  constructor(public auth: AuthService) {}

  logout() {
    this.auth.logout();
  }
}
