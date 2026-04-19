import { Component, OnInit, inject, signal } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ApiService } from '../../services/api';
import { AuthService } from '../../services/auth'; 
import { Stage } from '../../models/stage';
import { RouterLink } from '@angular/router';

@Component({
  selector: 'app-candidatures',
  standalone: true,
  imports: [CommonModule, RouterLink],
  templateUrl: './candidatures.html',
  styleUrl: './candidatures.css'
})
export class CandidaturesComponent implements OnInit {
  private api = inject(ApiService);
  public auth = inject(AuthService); 

  stages = signal<Stage[]>([]);

  ngOnInit(): void {
    this.api.getStages().subscribe({
      next: (data) => {
        this.stages.set(data);
      },
      error: (err) => console.error('Erreur de chargement:', err)
    });
  }
}