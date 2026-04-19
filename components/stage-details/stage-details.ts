import { Component, inject, OnInit, ChangeDetectorRef } from '@angular/core';
import { CommonModule, DatePipe } from '@angular/common';
import { ActivatedRoute } from '@angular/router';
import { ApiService } from '../../services/api';

@Component({
  selector: 'app-stage-details',
  standalone: true,
  imports: [CommonModule, DatePipe],
  templateUrl: './stage-details.html',
  styleUrl: './stage-details.css'
})
export class StageDetailsComponent implements OnInit {
  private route = inject(ActivatedRoute);
  private api = inject(ApiService);
  private cdr = inject(ChangeDetectorRef);

  stage: any = null;

  ngOnInit(): void {
    const id = this.route.snapshot.paramMap.get('id');
    if (id) {
      this.api.getStage(Number(id)).subscribe({
        next: (data) => {
          this.stage = data;
          this.cdr.detectChanges();
        },
        error: (err) => console.error('Erreur chargement stage:', err)
      });
    }
  }

  getStatusClass(statut: string | undefined): string {
    const s = statut?.toLowerCase();
    if (s === 'actif' || s === 'validé') return 'badge-actif';
    if (s === 'en attente') return 'badge-attente';
    return 'badge-refuse';
  }
}