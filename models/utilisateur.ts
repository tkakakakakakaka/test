export interface Utilisateur {
  '@id': string;
  id: number;
  nom: string;
  prenom: string;
  email: string;
  estAdmin: boolean;
  estSecretaire: boolean;
  compteBloque: boolean;
  roles?: string[];
}

export interface Etudiant extends Utilisateur {
  numEtudiant?: string;
}

export interface Enseignant extends Utilisateur {
  matricule?: string;
}

export interface TuteurPro extends Utilisateur {
  telephone: string;
  fonction?: string;
  entreprise?: Entreprise;
}

export interface Entreprise {
  id: number;
  raisonSociale: string;
  adresse?: string;
  ville: string;
  secteurActivite: string;
}
