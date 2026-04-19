import { Component, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Router } from '@angular/router';
import { ApiService } from '../../services/api';

@Component({
  selector: 'app-userform',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './userform.html',
  styleUrl: './userform.css'
})
export class UtilisateurFormComponent {
  private api = inject(ApiService);
  private router = inject(Router);

  typeUtilisateur = 'etudiants'; 
  
  userData = {
    nom: '',
    prenom: '',
    email: '',
    mdp: '', 
    estAdmin: false,
    estSecretaire: false,
    compteBloque: false
  };

 enregistrer() {
  this.api.createUtilisateur(this.typeUtilisateur, this.userData).subscribe({
    next: () => {
      this.router.navigate(['/admin/utilisateurs']);
    },
    error: (err) => {
      console.error('Erreur API:', err);
    }
  });
  }
}