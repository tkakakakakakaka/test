import { Component } from '@angular/core';
import { FormBuilder, FormGroup, Validators, ReactiveFormsModule } from '@angular/forms';
import { AuthService } from '../../services/auth';
import { Router } from '@angular/router';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [ReactiveFormsModule, CommonModule],
  templateUrl: './login.html',
  styleUrl: './login.css'
})
export class LoginComponent {
  loginForm: FormGroup;
  errorMessage: string = '';

  constructor(
    private fb: FormBuilder,
    private authService: AuthService,
    private router: Router
  ) {
    this.loginForm = this.fb.group({
      email: ['', [Validators.required, Validators.email]],
      password: ['', Validators.required]
    });
  }

  onSubmit() {
    if (this.loginForm.valid) {
      // On extrait les valeurs individuellement du formulaire
      const { email, password } = this.loginForm.value;

      // On appelle login avec les deux arguments attendus par AuthService
      this.authService.login(email, password).subscribe({
        next: () => {
          // admin > enseignant > étudiant > tuteur
          if (this.authService.isAdmin()) {
            this.router.navigate(['/admin/dashboard']);
          } else if (this.authService.isEnseignant()) {
            this.router.navigate(['/enseignant/dashboard']);
          } else if (this.authService.isEtudiant()) {
            this.router.navigate(['/etudiant/dashboard']);
          } else if (this.authService.isTuteurPro()) {
            this.router.navigate(['/tuteur/dashboard']);
          } else {
            this.router.navigate(['/login']);
          }
        },
        error: () => {
          this.errorMessage = 'Email ou mot de passe incorrect.';
        }
      });
    }
  }
}
