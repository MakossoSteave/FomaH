# Dictionnaire de données

# Dictionnaire de données

## Formateur

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| id_formateur | Identifiant du formateur | BigInt | Clé primaire |
| curriculumVitae | cv du formateur | Varchar(20) | pdf? photo? |
| nom| nom du formateur | Varchar(20) |  |
| prenom| prenom du formateur | Varchar(20) |  |
| departement | residence du formateur | SmallInt |  |
| Mot_De_Passe| Mot de passe de l'utilisateur | Varchar(50) |  |
| email| email du formateur | Varchar(30) |  |
| telephone| telephone du formateur | Varchar(20) |  |
| competence | competence du formateur | BigInt | Clé étrangère |
| cursusPositionner | cursus vise par le formateur | BigInt | Clé étrangère |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |


## Competence

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| id_competence | Identifiant de la competence | BigInt | Clé primaire |
| id_matiere | Identifiant de la matiere | BigInt | Clé étrangère |
| id_sous_matiere | Identifiant de la sous_matiere | BigInt | Clé étrangère |
| id_niveau_scolaire | Id du niveau scolaire correspondant | BigInt | Clé étrangère |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |


## Cours_executes_historique

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| id_cours_executes | Id du cours executes | BigInt | Clé primaire |
| id_cours | Identifiant du coure | BigInt | Clé étrangère |
| date_debut | debut du cours | Date |  |
| date_fin | fin du cours | Date |  |
| appreciation_cours | fait par les stagiaires | Varchar(100) |  |
| pourcentage_reussite | pourcentage de reçu | SmallInt |  |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |
