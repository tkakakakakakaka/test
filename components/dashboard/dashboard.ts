import { Component, OnInit, signal, inject, computed } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterLink } from '@angular/router';
import { AuthService } from '../../services/auth';
import { ApiService } from '../../services/api';
import { Stage } from '../../models/stage';
import { Soutenance } from '../../models/soutenance';
import { Creneau } from '../../models/creneau';
import { Utilisateur } from '../../models/utilisateur';


@Component({
  selector: 'app-dashboard',
  standalone: true,
  imports: [CommonModule, RouterLink],
  templateUrl: './dashboard.html',
  styleUrl: './dashboard.css'
})
export class DashboardComponent implements OnInit {
  public auth  = inject(AuthService);
  private api  = inject(ApiService);

  // Onglet actif - premier rôle par défaut
  activeTab = signal<string>(this.getDefaultTab());

  stages       = signal<Stage[]>([]);
  soutenances  = signal<Soutenance[]>([]);
  creneaux     = signal<Creneau[]>([]);
  utilisateurs = signal<Utilisateur[]>([]);

  // --- Overview ---
  totalEtudiants  = computed(() => this.stages().length);

  // Compte les stages validés/en cours (statut 'actif')
  totalStagesActifs = computed(() =>
    this.stages().filter(s => s.statutValidation === 'actif').length
  );

  // Logique d'actions requises
  actionsRequises = computed(() =>
    this.stages().filter(s =>
      s.statutValidation === 'propose' || s.statutValidation === 'valide_etudiant'
    ).length
  );

  ngOnInit(): void {
    if (this.auth.isEnseignant() || this.auth.isEtudiant() || this.auth.isTuteurPro() || this.auth.isAdmin()) {
      this.api.getStages().subscribe({
        next: (data) => this.stages.set(data),
        error: (err) => console.error('Erreur stages:', err)
      });
      this.api.getSoutenances().subscribe({
        next: (data) => this.soutenances.set(data),
        error: (err) => console.error('Erreur soutenances:', err)
      });
    }

    if (this.auth.isEtudiant() || this.auth.isTuteurPro()) {
      this.api.getCreneaux().subscribe({
        next: (data) => this.creneaux.set(data),
        error: (err) => console.error('Erreur créneaux:', err)
      });
    }

    if (this.auth.isAdmin()) {
      this.api.getUtilisateurs().subscribe({
        next: (data) => this.utilisateurs.set(data),
        error: (err) => console.error('Erreur utilisateurs:', err)
      });
    }
  }

    // Détermine le premier rôle disponible
    private getDefaultTab(): string {
      // Utilisation directe du service injecté au niveau de la classe
      if (this.auth.isAdmin())       return 'admin';
      if (this.auth.isEnseignant())  return 'enseignant';
      if (this.auth.isEtudiant())    return 'etudiant';
      if (this.auth.isTuteurPro())   return 'tuteur';
      return 'admin';
    }

    // Rôles que l'utilisateur possède (pour les onglets)
    get tabs(): { key: string; label: string; icon: string }[] {
      const tabs = [];
      if (this.auth.isAdmin())      tabs.push({ key: 'admin',      label: 'Admin',      icon: 'shield' });
      if (this.auth.isEnseignant()) tabs.push({ key: 'enseignant', label: 'Enseignant', icon: 'person_book' });
      if (this.auth.isEtudiant())   tabs.push({ key: 'etudiant',   label: 'Étudiant',   icon: 'school' });
      if (this.auth.isTuteurPro())  tabs.push({ key: 'tuteur',     label: 'Employé',    icon: 'business' });
      return tabs;
    }

  // --- Méthodes d'actions ---

  supprimerCreneau(id: number): void {
    if (confirm('Voulez-vous vraiment supprimer ce créneau ?')) {
      this.api.deleteCreneau(id).subscribe({
        next: () => {
          this.creneaux.update(list => list.filter(c => c.id !== id));
          console.log('Créneau supprimé avec succès');
        }
      });
    }
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
    if (!roleAAjouter) return;

    const rolesActuels = u.roles ?? [];
    if (rolesActuels.includes(roleAAjouter)) return;

    const nouveauxRoles = [...rolesActuels, roleAAjouter];

    this.utilisateurs.update(users =>
      users.map(user =>
        user.id === u.id ? { ...user, roles: nouveauxRoles } : user
      )
    );

    select.value = '';
    // TODO: appel API PATCH
  }

  retirerRole(u: Utilisateur, role: string): void {
    const nouveauxRoles = (u.roles ?? []).filter(r => r !== role);

    this.utilisateurs.update(users =>
      users.map(user =>
        user.id === u.id ? { ...user, roles: nouveauxRoles } : user
      )
    );
    // TODO: appel API PATCH
  }

  // Pagination utilisateurs
  currentPage = signal(0);
  itemsPerPage = signal(5);

  totalUsers = computed(() => this.utilisateurs().length);
paginatedUsers = computed(() => {
    const start = this.currentPage() * this.itemsPerPage();
    return this.utilisateurs().slice(start, start + this.itemsPerPage());
});

  totalPages = computed(() => Math.ceil(this.totalUsers() / this.itemsPerPage()));
  pageNumbers = computed(() => {
    const pages = [];
    for (let i = 0; i < this.totalPages(); i++) {
      pages.push(i);
    }
    return pages;
  });

  goToPage(page: number): void {
    if (page >= 0 && page < this.totalPages()) {
      this.currentPage.set(page);
    }
  }

  nextPage(): void {
    if (this.currentPage() < this.totalPages() - 1) {
      this.currentPage.update(p => p + 1);
  }
}

  prevPage(): void {
    if (this.currentPage() > 0) {
      this.currentPage.update(p => p - 1);
  }
}

  setItemsPerPage(size: number) {
    this.itemsPerPage.set(size);
    this.currentPage.set(0); // reset page
}
}

