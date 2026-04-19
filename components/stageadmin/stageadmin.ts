import { Component, OnInit, inject, signal } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ApiService } from '../../services/api';
import { Stage } from '../../models/stage';
import { RouterLink } from '@angular/router';

@Component({
  selector: 'app-admin-stages',
  standalone: true,
  imports: [CommonModule, RouterLink],
  templateUrl: './stageadmin.html',
  styleUrl: './stageadmin.css'
})
export class AdminStagesComponent implements OnInit {
  private api = inject(ApiService);
  
  stages = signal<Stage[]>([]);

  ngOnInit(): void {
    this.api.getStages().subscribe({
      next: (data) => this.stages.set(data),
      error: (err) => console.error('Erreur chargement stages admin:', err)
    });
  }
  supprimerStage(id: number): void {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce stage ?')) {
      this.api.deleteStage(id).subscribe({
        next: () => {
          this.stages.update(list => list.filter(s => s.id !== id));
        },
        error: (err) => {
          console.error('Erreur lors de la suppression:', err);
          alert('Impossible de supprimer ce stage.');
        }
      });
    }
  }

  modifierStatut(stageId: number, event: Event): void {
    const nouveauStatut = (event.target as HTMLSelectElement).value;
    
    this.stages.update(list => 
      list.map(s => s.id === stageId ? { ...s, statutValidation: nouveauStatut } : s)
    );

  }
}