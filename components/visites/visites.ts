import { Component, OnInit, inject, signal } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ApiService } from '../../services/api';
import { AuthService } from '../../services/auth'; 
import { RouterLink } from '@angular/router';

@Component({
  selector: 'app-visites',
  standalone: true,
  imports: [CommonModule, RouterLink],
  templateUrl: './visites.html',
  styleUrl: './visites.css'
})
export class VisitesComponent implements OnInit {
  private api = inject(ApiService);
  public auth = inject(AuthService); 

  visites = signal<any[]>([]);

  ngOnInit(): void {
    if (this.auth.isEtudiant()) {
      this.api.getVisites().subscribe(data => {
        this.visites.set(data); 
      });
    } else {
      this.api.getVisites().subscribe(data => {
        this.visites.set(data);
      });
    }
  }

  supprimerVisite(id: number | undefined): void {
    if (!id) return;

  
    if (confirm('Êtes-vous sûr de vouloir supprimer cette visite ?')) {
      this.api.deleteVisite(id).subscribe({
        next: () => {
          this.visites.set(this.visites().filter(v => v.id !== id));
        },
        error: (err) => {
          console.error('Erreur lors de la suppression:', err);
          alert('Impossible de supprimer cette visite.');
        }
      });
    } 
  }
}