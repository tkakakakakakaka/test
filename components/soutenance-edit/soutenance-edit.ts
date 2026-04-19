import { Component, OnInit, inject, ChangeDetectorRef } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { ActivatedRoute, Router, RouterModule } from '@angular/router';
import { ApiService } from '../../services/api';
import { AuthService } from '../../services/auth';
import { Soutenance } from '../../models/soutenance';

@Component({
  selector: 'app-soutenance-edit',
  imports: [CommonModule, FormsModule, RouterModule],
  templateUrl: './soutenance-edit.html',
  styleUrl: './soutenance-edit.css',
})
export class SoutenanceEditComponent implements OnInit {
  private api = inject(ApiService);
  private route = inject(ActivatedRoute);
  private router = inject(Router);
  private cd = inject(ChangeDetectorRef);
  public auth = inject(AuthService);

  soutenance: Soutenance | null = null;

  ngOnInit(): void {
    this.route.paramMap.subscribe(params => {
      const id = params.get('id');
      if (id) {
        this.chargerSoutenance(+id);
      }
    });
  }

  chargerSoutenance(id: number): void {
    this.api.getSoutenance(id).subscribe({
      next: (data) => {
        this.soutenance = data;
        
        if (this.soutenance) {
          this.soutenance.noteEntreprise = this.soutenance.noteEntreprise ?? "0";
          this.soutenance.noteEnseignant = this.soutenance.noteEnseignant ?? "0";
          this.soutenance.commentaireJury = this.soutenance.commentaireJury ?? "";

          if (this.soutenance.dateHeure) {
            this.soutenance.dateHeure = this.soutenance.dateHeure.substring(0, 16);
          }
          this.cd.detectChanges(); 
        }
      },
      error: (err) => {
        console.error("Erreur API:", err);
        this.router.navigate(['/dashboard']);
      }
    });
  }

  enregistrer(): void {
    if (!this.soutenance) return;
    const payload: any = {};
    const s = this.soutenance; 

    if (this.auth.isAdmin()) {
      payload.dateHeure = s.dateHeure;
      payload.salleOuLien = s.salleOuLien;
      payload.noteEntreprise = s.noteEntreprise?.toString();
      payload.noteEnseignant = s.noteEnseignant?.toString();
      payload.commentaireJury = s.commentaireJury;
    } else if (this.auth.isTuteurPro()) {
      payload.noteEntreprise = s.noteEntreprise?.toString();
      payload.commentaireJury = s.commentaireJury;
    } else if (this.auth.isEnseignant()) {
      payload.noteEnseignant = s.noteEnseignant?.toString();
    }

    this.api.updateSoutenance(s.id!, payload).subscribe({
      next: () => {
        let redirectPath = '/dashboard'; 
        if (this.auth.isAdmin()) {
          redirectPath = '/admin/dashboard';
        } else if (this.auth.isEnseignant()) {
          redirectPath = '/enseignant/dashboard';
        } else if (this.auth.isTuteurPro()) {
          redirectPath = '/tuteur/dashboard';
        }
        this.router.navigate([redirectPath]);
      },
      error: (err) => alert("Erreur : " + (err.error?.detail || "Action impossible"))
    });
  }
}
