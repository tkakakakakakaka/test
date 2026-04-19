import { Etudiant, Enseignant, TuteurPro } from './utilisateur';

export interface Soutenance {
  id: number;
  dateHeure: string;
  salleOuLien?: string;
  noteEntreprise?: string;
  noteEnseignant?: string;
  commentaireJury?: string;
  etudiant: Etudiant | string; 
  enseignant: Enseignant | string;
  tuteurPro?: TuteurPro;
}
