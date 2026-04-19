import { Injectable, signal, inject } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Router } from '@angular/router';
import { Observable, tap } from 'rxjs';
import { environment } from '../../environments/environment';
import { jwtDecode } from 'jwt-decode';

export interface TokenPayload {
  email: string;
  roles: string[];
  exp: number;
}

@Injectable({ providedIn: 'root' })
export class AuthService {
  private http = inject(HttpClient);
  private router = inject(Router);

  currentUser = signal<TokenPayload | null>(null);

  constructor() {
    this.restoreSession();
  }

  private restoreSession() {
    const token = localStorage.getItem('jwt_token');
    if (token) {
      try {
        const decoded = jwtDecode<TokenPayload>(token);
        if (decoded.exp > Math.floor(Date.now() / 1000)) {
          this.currentUser.set(decoded);
        } else {
          this.logout();
        }
      } catch {
        this.logout();
      }
    }
  }

  /**
   * @param email L'email saisi
   * @param password Le mot de passe saisi
   */
  login(email: string, password: string): Observable<{token: string}> {
    const body = {
      email: email,
      mdp: password
    };

    return this.http.post<{token: string}>(`${environment.apiUrl}/login`, body).pipe(
      tap(response => {
        localStorage.setItem('jwt_token', response.token);
        this.currentUser.set(jwtDecode<TokenPayload>(response.token));
      })
    );
  }

  logout(): void {
    localStorage.removeItem('jwt_token');
    this.currentUser.set(null);
    this.router.navigate(['/login']);
  }

  isLoggedIn = () => !!this.currentUser();
  hasRole = (role: string) => this.currentUser()?.roles.includes(role) ?? false;

  isAdmin = () => this.hasRole('ROLE_ADMIN');
  isEnseignant = () => this.hasRole('ROLE_ENSEIGNANT');
  isEtudiant = () => this.hasRole('ROLE_ETUDIANT');
  isTuteurPro = () => this.hasRole('ROLE_TUTEUR_PRO');
}
