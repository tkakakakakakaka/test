import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';
import { environment } from '../../environments/environment';
import { Stage } from '../models/stage';
import { Soutenance } from '../models/soutenance';
import { Creneau } from '../models/creneau';
import { Utilisateur, Etudiant, Enseignant, TuteurPro } from '../models/utilisateur';

@Injectable({ providedIn: 'root' })
export class ApiService {
  private readonly baseUrl = environment.apiUrl;

  private readonly httpOptions = {
    headers: new HttpHeaders({
      'Content-Type': 'application/ld+json',
      'Accept': 'application/ld+json'
    })
  };

  private readonly patchOptions = {
    headers: new HttpHeaders({
      'Content-Type': 'application/merge-patch+json',
      'Accept': 'application/ld+json'
    })
  };
  constructor(private http: HttpClient) {}

  // --- GESTION DES STAGES ---

  /**
   * Récupère la collection des stages.
   */
  getStages(): Observable<Stage[]> {
    return this.http.get<any>(`${this.baseUrl}/stages`, this.httpOptions).pipe(
      map(r => r['member'] || r['hydra:member'] || [])
    );
  }

  getStage(id: number): Observable<Stage> {
    return this.http.get<Stage>(`${this.baseUrl}/stages/${id}`, this.httpOptions);
  }

  /**
   * Création de stage
   */
  createStage(stage: Partial<Stage>): Observable<Stage> {
    return this.http.post<Stage>(`${this.baseUrl}/stages`, stage, this.httpOptions);
  }

  updateStage(id: number, stage: Partial<Stage>): Observable<Stage> {
    return this.http.patch<Stage>(`${this.baseUrl}/stages/${id}`, stage, this.httpOptions);
  }

  deleteStage(id: number): Observable<void> {
    return this.http.delete<void>(`${this.baseUrl}/stages/${id}`, this.httpOptions);
  }

  // --- WORKFLOW ---
  validerProf(id: number): Observable<any> {
    return this.http.post(`${this.baseUrl}/stages/${id}/valider-prof`, {}, this.httpOptions);
  }
  refuserProf(id: number): Observable<any> {
    return this.http.post(`${this.baseUrl}/stages/${id}/refuser-prof`, {}, this.httpOptions);
  }
  validerEtudiant(id: number): Observable<any> {
    return this.http.post(`${this.baseUrl}/stages/${id}/valider-etudiant`, {}, this.httpOptions);
  }
  refuserEtudiant(id: number): Observable<any> {
    return this.http.post(`${this.baseUrl}/stages/${id}/refuser-etudiant`, {}, this.httpOptions);
  }
  activerStage(id: number): Observable<any> {
    return this.http.post(`${this.baseUrl}/stages/${id}/activer`, {}, this.httpOptions);
  }

  // --- SOUTENANCES & CRÉNEAUX ---

  getSoutenances(): Observable<Soutenance[]> {
    return this.http.get<any>(`${this.baseUrl}/soutenances`, this.httpOptions)
      .pipe(map(r => r['member'] || r['hydra:member'] || []));
  }

  getSoutenance(id: number): Observable<Soutenance> {
    return this.http.get<Soutenance>(`${this.baseUrl}/soutenances/${id}`, this.httpOptions);
  }

  createSoutenance(soutenance: Partial<Soutenance>): Observable<Soutenance> {
    return this.http.post<Soutenance>(`${this.baseUrl}/soutenances`, soutenance, this.httpOptions);
  }

  updateSoutenance(id: number, data: Partial<Soutenance>): Observable<Soutenance> {
    return this.http.patch<Soutenance>(
      `${this.baseUrl}/soutenances/${id}`,
      data,
      this.patchOptions
    );
  }

   deleteSoutenance(id: number): Observable<void> {
    return this.http.delete<void>(`${this.baseUrl}/soutenances/${id}`, this.httpOptions);
  }

  // --- CRÉNEAUX ---
  getCreneaux(): Observable<Creneau[]> {
    return this.http.get<any>(`${this.baseUrl}/creneaux`, this.httpOptions)
      .pipe(map(r => r['member'] || r['hydra:member'] || []));
  }

  createCreneau(creneau: Partial<Creneau>): Observable<Creneau> {
    return this.http.post<Creneau>(`${this.baseUrl}/creneaux`, creneau, this.httpOptions);
  }

  deleteCreneau(id: number): Observable<void> {
    return this.http.delete<void>(`${this.baseUrl}/creneaux/${id}`, this.httpOptions);
  }

  getCreneauxCommuns(stageId: number): Observable<any> {
    return this.http.get(`${this.baseUrl}/stages/${stageId}/creneaux-communs`, this.httpOptions);
  }

   updateCreneau(id: number, data: Partial<Creneau>): Observable<Creneau> {
    return this.http.patch<Creneau>(`${this.baseUrl}/creneaux/${id}`, data, this.patchOptions);
  }

  // --- PDF ---
  getConventionPdf(stageId: number): Observable<Blob> {
    return this.http.get(`${this.baseUrl}/stages/${stageId}/convention`, { responseType: 'blob' });
  }

  getCompteRenduPdf(visiteId: number): Observable<Blob> {
    return this.http.get(`${this.baseUrl}/visites/${visiteId}/compte-rendu`, { responseType: 'blob' });
  }

  // --- UTILISATEURS ---
  getUtilisateurs(): Observable<Utilisateur[]> {
    return this.http.get<any>(`${this.baseUrl}/utilisateurs`, this.httpOptions).pipe(
      map(r => r['member'] || r['hydra:member'] || [])
    );
  }

  getUtilisateur(type: string, id: number): Observable<any> {
  const endpoint = this.getEndpointForType(type);
  
  // On tape sur /api/etudiants/5 au lieu de /api/utilisateurs/5
  return this.http.get<any>(`${this.baseUrl}/${endpoint}/${id}`, this.httpOptions);
}

 createUtilisateur(type: string, data: any): Observable<any> {
  const endpoint = this.getEndpointForType(type);
  return this.http.post(`${this.baseUrl}/${endpoint}`, data, this.httpOptions);
}
  updateUtilisateur(type: string, id: number, data: any): Observable<any> {
  const endpoint = this.getEndpointForType(type);
  
  const patchOptions = {
    headers: new HttpHeaders({
      'Content-Type': 'application/merge-patch+json'
    })
  };

  return this.http.patch(`${this.baseUrl}/${endpoint}/${id}`, data, patchOptions);
}

  deleteUtilisateur(type: string, id: number): Observable<void> {
  // Si tu n'as pas de dictionnaire de mapping, utilise directement le type
  // ou remplace par `${this.baseUrl}/utilisateurs/${id}` si l'API est globale
  return this.http.delete<void>(`${this.baseUrl}/${type}/${id}`, this.httpOptions);
}

  bloquerTousLesComptes(): Observable<any> {
    return this.http.post(`${this.baseUrl}/admin/bloquer-tous`, {}, this.httpOptions);
  }

  debloquerTousLesComptes(): Observable<any> {
    return this.http.post(`${this.baseUrl}/admin/debloquer-tous`, {}, this.httpOptions);
  }

  toggleBloquerCompte(id: number, bloquer: boolean): Observable<Utilisateur> {
    return this.http.patch<Utilisateur>(
      `${this.baseUrl}/utilisateurs/${id}`,
      { compteBloque: bloquer },
      this.httpOptions
    );
  }

  // --- ÉTUDIANTS ---
  getEtudiants(): Observable<Etudiant[]> {
    return this.http.get<any>(`${this.baseUrl}/etudiants`, this.httpOptions).pipe(
      map(r => r['member'] || r['hydra:member'] || [])
    );
  }

  getEtudiant(id: number): Observable<Etudiant> {
    return this.http.get<Etudiant>(`${this.baseUrl}/etudiants/${id}`, this.httpOptions);
  }

  // --- ENSEIGNANTS ---
  getEnseignants(): Observable<Enseignant[]> {
    return this.http.get<any>(`${this.baseUrl}/enseignants`, this.httpOptions).pipe(
      map(r => r['member'] || r['hydra:member'] || [])
    );
  }

  // --- TUTEURS PRO ---
  getTuteursPro(): Observable<TuteurPro[]> {
    return this.http.get<any>(`${this.baseUrl}/tuteur_pros`, this.httpOptions).pipe(
      map(r => r['member'] || r['hydra:member'] || [])
    );
  }

  // --- VISITES ---
  getVisites(): Observable<any[]> {
    return this.http.get<any>(`${this.baseUrl}/visites`, this.httpOptions).pipe(
      map(r => r['member'] || r['hydra:member'] || [])
    );
  }
  getVisite(id: number): Observable<any> {
  return this.http.get<any>(`${this.baseUrl}/visites/${id}`, this.httpOptions);
}

  createVisite(visite: any): Observable<any> {
    return this.http.post<any>(`${this.baseUrl}/visites`, visite, this.httpOptions);
  }

 updateVisite(id: number, data: any): Observable<any> {
  const headers = new HttpHeaders({
    'Content-Type': 'application/merge-patch+json', 
    'Accept': 'application/ld+json'
  });
 return this.http.patch<any>(`${this.baseUrl}/visites/${id}`, data, { headers });
}

deleteVisite(id: number): Observable<void> {
    return this.http.delete<void>(`${this.baseUrl}/visites/${id}`, this.httpOptions);
  }

  createCompteRendu(compteRendu: any): Observable<any> {
    return this.http.post<any>(`${this.baseUrl}/comptes_rendus`, compteRendu, this.httpOptions);
  }

  updateCompteRendu(id: number, data: any): Observable<any> {
    return this.http.patch<any>(`${this.baseUrl}/comptes_rendus/${id}`, data, this.patchOptions);
  }

 private getEndpointForType(type: string): string {
  const mapping: { [key: string]: string } = {
    'etudiants': 'etudiants',
    'enseignants': 'enseignants',
    'tuteur_pros': 'tuteur_pros',
    'directeurs': 'directeurs'
  };
  return mapping[type] || 'utilisateurs';
}
}
