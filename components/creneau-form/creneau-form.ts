import { Component, inject, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Router } from '@angular/router';
import { ApiService } from '../../services/api';
import { AuthService } from '../../services/auth';

@Component({
  selector: 'app-creneau-form',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './creneau-form.html',
  styleUrl: './creneau-form.css'
})
export class CreneauFormComponent implements OnInit {
  private api = inject(ApiService);
  private auth = inject(AuthService);
  private router = inject(Router);

  nouveauCreneau = {
    dateJour: '',
    heureDebut: '',
    heureFin: ''
  };

  ngOnInit(): void {
    if (!this.auth.isLoggedIn()) {
      this.router.navigate(['/login']);
    }
  }
  enregistrer(): void {
    const userToken = this.auth.currentUser();
    const username = (userToken as any)?.username;
    if (!username) {
      alert("Erreur : Impossible de récupérer votre identifiant de session.");
      return;
    }
    if (!this.nouveauCreneau.dateJour || !this.nouveauCreneau.heureDebut || !this.nouveauCreneau.heureFin) {
      alert("Veuillez remplir tous les champs.");
      return;
    }
    this.api.getUtilisateurs().subscribe({
      next: (utilisateurs) => {
        const me = utilisateurs.find(u => u.email === username);

        if (!me || !me.id) {
          alert("Erreur : Impossible de trouver votre compte dans la base de données.");
          return;
        }
        const dateStr = this.nouveauCreneau.dateJour;
        const payload = {
          dateJour: `${dateStr}T00:00:00Z`,
          heureDebut: `${dateStr}T${this.nouveauCreneau.heureDebut}:00Z`,
          heureFin: `${dateStr}T${this.nouveauCreneau.heureFin}:00Z`,
          utilisateur: `/api/utilisateurs/${me.id}`
        };
        this.api.createCreneau(payload).subscribe({
          next: () => {
            this.redirigerSelonRole();
          },
          error: (err) => {
            console.error("Erreur API:", err);
            const detail = err.error?.['hydra:description'] || "Données invalides";
            alert("Erreur lors de l'enregistrement : " + detail);
          }
        });
      },
      error: (err) => {
        console.error("Erreur récupération utilisateurs:", err);
        alert("Erreur de connexion au serveur.");
      }
    });
  }

  private redirigerSelonRole(): void {
    let path = '/';

    if (this.auth.isTuteurPro()) {
      path = '/tuteur/disponibilite';
    } else if (this.auth.isEtudiant()) {
      path = '/etudiant/disponibilite';
    } else if (this.auth.isEnseignant()) {
      path = '/enseignant/disponibilite';
    }

    this.router.navigate([path]);
  }
}