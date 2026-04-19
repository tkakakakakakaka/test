import { Component, inject, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { ApiService } from '../../services/api';
import { Router, RouterModule } from '@angular/router';
import { Etudiant, Enseignant, TuteurPro } from '../../models/utilisateur';

@Component({
  selector: 'app-soutenances-form',
  standalone: true,
  imports: [CommonModule, FormsModule, RouterModule],
  templateUrl: './soutenances-form.html',
  styleUrl: './soutenances-form.css'
})
export class SoutenanceFormComponent implements OnInit {
  private api = inject(ApiService);
  private router = inject(Router);

  etudiants: Etudiant[] = [];
  enseignants: Enseignant[] = [];
  tuteurs: TuteurPro[] = [];

  formData = {
    dateHeure: '',
    salleOuLien: '',
    etudiant: '',   
    enseignant: '',
    tuteurPro: '',
    commentaireJury: ''
  };

  ngOnInit() {
    this.api.getEtudiants().subscribe(res => this.etudiants = res);
    this.api.getEnseignants().subscribe(res => this.enseignants = res);
    this.api.getTuteursPro().subscribe(res => this.tuteurs = res);
  }

  creer() {
    if (!this.formData.dateHeure || !this.formData.etudiant || !this.formData.enseignant || !this.formData.tuteurPro) {
      alert("Veuillez remplir tous les champs obligatoires.");
      return;
    }

    try {
      const payload: any = {
        dateHeure: this.formData.dateHeure.replace('T', ' ') + ':00',
        salleOuLien: this.formData.salleOuLien || "À définir",
        etudiant: this.formData.etudiant,
        enseignant: this.formData.enseignant,
        tuteurPro: this.formData.tuteurPro,
        noteEntreprise: "0",
        noteEnseignant: "0",
        commentaireJury: "" 
      };

      this.api.createSoutenance(payload).subscribe({
        next: () => {
          this.router.navigate(['/admin/soutenances']);
        },
        error: (err) => {
          const detail = err.error?.detail || err.error['hydra:description'] || "Erreur lors de la création";
          alert("Erreur : " + detail);
        }
      });
    } catch (error) {
      alert("Le format de la date est invalide.");
    }
  }
}