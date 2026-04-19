import { Component, OnInit, inject, signal } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ApiService } from '../../services/api';
import { AuthService } from '../../services/auth'; 
import { Soutenance } from '../../models/soutenance';
import { RouterLink } from '@angular/router';

@Component({
  selector: 'app-soutenances',
  standalone: true,
  imports: [CommonModule, RouterLink],
  templateUrl: './soutenances.html',
  styleUrl: './soutenances.css'
})
export class SoutenancesComponent implements OnInit {
  private api = inject(ApiService);
  public auth = inject(AuthService); 

  soutenances = signal<Soutenance[]>([]);

  ngOnInit(): void {
    if (this.auth.isEtudiant()) {

      this.api.getSoutenances().subscribe(data => {
        this.soutenances.set(data); 
      });
    } else {
      this.api.getSoutenances().subscribe(data => this.soutenances.set(data));
    }
  }
  supprimerSoutenance(id: number | undefined): void {
  if (!id) return;
  if (confirm('Êtes-vous sûr de vouloir supprimer cette soutenance ?')) {
    this.api.deleteSoutenance(id).subscribe({
      next: () => {
        this.soutenances.set(this.soutenances().filter(s => s.id !== id));
      },
      error: (err) => {
        console.error('Erreur lors de la suppression:', err);
        alert('Impossible de supprimer cette soutenance.');
        }
      });
    } 
  }
}