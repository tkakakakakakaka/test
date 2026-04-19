import { Component, OnInit, inject, ChangeDetectorRef } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { ActivatedRoute, Router, RouterModule } from '@angular/router';
import { ApiService } from '../../services/api';

@Component({
  selector: 'app-visite-edit',
  imports: [CommonModule, FormsModule, RouterModule],
  templateUrl: './visite-edit.html',
  styleUrl: './visite-edit.css',
})
export class VisiteEditComponent implements OnInit {
 private api = inject(ApiService);
  private route = inject(ActivatedRoute);
  private router = inject(Router);
  private cd = inject(ChangeDetectorRef);

  visite: any = null;
  compteRendu: string = '';
  participants: any[] = [];

  ngOnInit() {
    this.route.paramMap.subscribe(params => {
      const id = params.get('id');
      if (id) {
        this.chargerDonnees(+id);
      }
    });
  }

  chargerDonnees(id: number) {
    this.api.getVisite(id).subscribe({
      next: (data) => {
        this.visite = data;
        this.compteRendu = data.compteRendu || '';
        
        this.participants = [
          { id: 'etu', label: `Étudiant (${data.etudiant?.nom || 'Inconnu'})`, checked: false },
          { id: 'tut', label: `Tuteur (${data.tuteurPro?.nom || 'Inconnu'})`, checked: false },
          { id: 'ens', label: `Enseignant (${data.enseignant?.nom || 'Inconnu'})`, checked: false }
        ];

        if (data.listePresence) {
          this.participants.forEach(p => {
            if (data.listePresence.includes(p.label)) p.checked = true;
          });
        }

        this.cd.detectChanges();
      },
      error: () => {
        this.router.navigate(['/enseignant/visites']);
      }
    });
  }

  enregistrer() {
    const listeTexte = this.participants
      .filter(p => p.checked)
      .map(p => p.label)
      .join(', ');

    const payload = {
      compteRendu: this.compteRendu,
      listePresence: listeTexte
    };

    this.api.updateVisite(this.visite.id, payload).subscribe({
      next: () => {
        this.router.navigate(['/enseignant/visites']);
      }
    });
  }
}