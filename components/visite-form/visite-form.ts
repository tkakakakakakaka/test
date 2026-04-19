import { Component, inject, OnInit } from '@angular/core';
import { ApiService } from '../../services/api';
import { Router } from '@angular/router';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { AuthService } from '../../services/auth';

@Component({
  selector: 'app-visite-form',
  imports: [CommonModule,FormsModule],
  templateUrl: './visite-form.html',
  styleUrl: './visite-form.css',
})
export class VisiteFormComponent implements OnInit {
  private api = inject(ApiService);
  private router = inject(Router);
  public auth = inject(AuthService);

 
  etudiants: any[] = [];
  enseignants: any[] = [];
  tuteurs: any[] = [];
  stages: any[] = [];
  creneaux: any[] = [];

  formData = {
    dateVisite: '',
    stage: '',       
    etudiant: '',    
    enseignant: '',  
    tuteurPro: '',  
    creneau: '',     
    compteRendu: '', 
    listePresence: '' 
  };

  ngOnInit() {
    this.api.getEtudiants().subscribe(data => this.etudiants = data);
    this.api.getEnseignants().subscribe(data => this.enseignants = data);
    this.api.getTuteursPro().subscribe(data => this.tuteurs = data);
    this.api.getStages().subscribe(data => this.stages = data);
    this.api.getCreneaux().subscribe(data => this.creneaux = data);
  }

  creerVisite() {
    const payload = {
      ...this.formData,
      dateVisite: new Date(this.formData.dateVisite).toISOString().split('T')[0] 
    };

    this.api.createVisite(payload).subscribe({
    next: () => {
      let redirectPath = '/dashboard';

      if (this.auth.isAdmin()) {
        redirectPath = '/admin/visites';
      } else if (this.auth.isEnseignant()) {
        redirectPath = '/enseignant/visites';
      }
      this.router.navigate([redirectPath]);
    },
    error: (err) => {
      console.error('Erreur creation visite:', err);
      alert("Erreur lors de la création : " + (err.error?.detail || "Action impossible"));
      }
    });
  }
}