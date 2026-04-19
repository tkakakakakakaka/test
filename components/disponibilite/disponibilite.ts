import { Component, OnInit, inject, signal } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ApiService } from '../../services/api';
import { AuthService } from '../../services/auth';
import { Creneau } from '../../models/creneau';
import { RouterLink } from '@angular/router';

@Component({
  selector: 'app-disponibilite',
  standalone: true,
  imports: [CommonModule, RouterLink],
  templateUrl: './disponibilite.html',
  styleUrl: './disponibilite.css'
})
export class DisponibiliteComponent implements OnInit {
  private api = inject(ApiService);
  private auth = inject(AuthService);

  creneaux = signal<Creneau[]>([]);

  ngOnInit(): void {
    if (this.auth.isEtudiant() || this.auth.isTuteurPro() || this.auth.isEnseignant()) {
      this.api.getCreneaux().subscribe({
        next: (data) => this.creneaux.set(data),
        error: (err) => console.error('Erreur créneaux:', err)
      });
    }
  }
  supprimerCreneau(id: number): void {
    if (confirm('Voulez-vous vraiment supprimer ce créneau ?')) {
      this.api.deleteCreneau(id).subscribe({
        next: () => {
          this.creneaux.update(list => list.filter(c => c.id !== id));
          console.log('Créneau supprimé avec succès');
        }
      });
    }
  }
}