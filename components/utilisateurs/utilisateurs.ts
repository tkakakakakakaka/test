import { Component, OnInit, signal, inject, computed } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ApiService } from '../../services/api';
import { Utilisateur } from '../../models/utilisateur';
import { RouterLink } from '@angular/router';

@Component({
  selector: 'app-utilisateurs',
  standalone: true,
  imports: [CommonModule, RouterLink],
  templateUrl: './utilisateurs.html',
  styleUrl: './utilisateurs.css'
})
export class UtilisateursComponent implements OnInit {
  private api = inject(ApiService);

  utilisateurs = signal<Utilisateur[]>([]);


  currentPage = signal(0);
  itemsPerPage = signal(10); 

  totalUsers = computed(() => this.utilisateurs().length);
  totalPages = computed(() => Math.ceil(this.totalUsers() / this.itemsPerPage()));
  
  paginatedUsers = computed(() => {
    const start = this.currentPage() * this.itemsPerPage();
    return this.utilisateurs().slice(start, start + this.itemsPerPage());
  });

  pageNumbers = computed(() => Array.from({length: this.totalPages()}, (_, i) => i));

  ngOnInit(): void {
    this.api.getUtilisateurs().subscribe({
      next: (data) => this.utilisateurs.set(data),
      error: (err) => console.error('Erreur utilisateurs:', err)
    });
  }
  supprimerUtilisateur(u: Utilisateur): void {
  if (confirm(`Supprimer l'utilisateur ${u.nom} ${u.prenom} ?`)) {
    this.api.deleteUtilisateur('utilisateurs', u.id).subscribe({
      next: () => {
        this.utilisateurs.update(list => list.filter(user => user.id !== u.id));
      },
      error: (err) => {
        console.error('Erreur lors de la suppression backend:', err);
        alert('Erreur : Impossible de supprimer cet utilisateur en base de données.');
      }
    });
  }
}

  changerRole(u: Utilisateur, event: Event): void {
    const select = event.target as HTMLSelectElement;
    const roleAAjouter = select.value;
    if (!roleAAjouter || u.roles?.includes(roleAAjouter)) return;

    const nouveauxRoles = [...(u.roles ?? []), roleAAjouter];
    this.updateUserRoles(u.id, nouveauxRoles);
    select.value = '';
  }

  retirerRole(u: Utilisateur, role: string): void {
    const nouveauxRoles = (u.roles ?? []).filter(r => r !== role);
    this.updateUserRoles(u.id, nouveauxRoles);
  }

  private updateUserRoles(userId: number, roles: string[]): void {
    this.utilisateurs.update(users =>
      users.map(user => user.id === userId ? { ...user, roles } : user)
    );
  }
  goToPage(page: number) { this.currentPage.set(page); }
  nextPage() { if (this.currentPage() < this.totalPages() - 1) this.currentPage.update(p => p + 1); }
  prevPage() { if (this.currentPage() > 0) this.currentPage.update(p => p - 1); }
  setItemsPerPage(size: number) { this.itemsPerPage.set(size); this.currentPage.set(0); }
}