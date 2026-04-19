import { Component, OnInit, inject, signal } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ApiService } from '../../services/api';
import { RouterModule } from '@angular/router'; 
import { RouterLink } from '@angular/router';

@Component({
  selector: 'app-comptes-rendus',
  standalone: true,
  imports: [CommonModule, RouterModule,RouterLink],
  templateUrl: './comptesrendus.html',
  styleUrl: './comptesrendus.css'
})
export class ComptesRendusComponent implements OnInit {
  private api = inject(ApiService);
  visites = signal<any[]>([]);

  ngOnInit(): void {
    this.api.getVisites().subscribe({
      next: (data) => this.visites.set(data),
      error: (err) => console.error('Erreur chargement visites:', err)
    });
  }
}