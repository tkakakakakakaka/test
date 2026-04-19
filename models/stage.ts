import { Etudiant, Enseignant, TuteurPro } from './utilisateur';

export interface Stage {
  id: number;
  titre: string;
  sujet?: string;
  dateDeb?: string;
  dateFin?: string;
  remuneration?: string;
  nomRh?: string;
  contactRh?: string;
  statutValidation: string;
  anneeStage?: number;
  estOptionnel: boolean;
  etudiant?: Etudiant;
  enseignant?: Enseignant;
  tuteurPro?: TuteurPro;
}

export interface ApiCollection<T> {
  'member': T[];
  'hydra:member': T[];
  totalItems: number;
}
