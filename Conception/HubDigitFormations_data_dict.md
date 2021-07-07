# Dictionnaire de données

## USER

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| id | Identifiant de l'utilisateur | Int | Clé primaire |
| name | Nom de l'utilisateur | Char |   |
| password | Mot de passe de l'utilisateur | Char |   |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |
| idRole | Identifiant du role | int | Clé étrangère |

## RESULTAT

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| idResultat | Identifiant du resultat | Int | Clé primaire |
| score | Note obtenue | Int | |
| idStagiaire | Identifiant du stagiaire | int | Clé étrangère |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |
| idTest | Identifiant du test | int | Clé étrangère |

## ROLE

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| idRole | Identifiant du role | Int | Clé primaire |
| type | Libellé du role | Char |   |
| Like | Nombre de like | Int |   |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |

## DEMANDE

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| idFormation | Identifiant de la formation | Int | Clé primaire/étrangère |
| idStagiaire | Identifiant du stagiaire | Int | Clé primaire/étrangère |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |

## STAGIAIRE

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| idStagiaire | Identifiant du stagiaire | Int | Clé primaire |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |
| idUser | Identifiant de l'utilisateur | Int | Clé étrangère |
| idFormation | Identifiant de la formation | Int | Clé étrangère |
| idCours | Identifiant du cours (valide) | Int | Clé étrangère |

## TEST

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| idTest | Identifiant du test | Int | Clé primaire |
| designation | Titre du test | Int |  |
| description | Description du test | Int |  |
| image | Image du test | Int |  |
| type | type du test (QCM ou Projet) | Int |  |
| test_link | Lien du test | Int |  |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |
| idCours | Identifiant du cours | Int | Clé étrangère |

## CENTRE

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| immatriculation | Immatriculation du centre | Int | Clé primaire |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |
| idUser | Identifiant de l'utilisateur | Int | Clé étrangère |

## FORMATION

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| idFormation | Identifiant de la formation | Int | Clé primaire |
| libelé | Titre de la formation | Char |  |
| description | Description de la formation | Char |  |
| prix | prix de la formation | Int |   |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |
| immatriculation | Identifiant du centre | Int | Clé étrangère |

## CURSUS

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| idCursus | Identifiant du cursus | Int | Clé primaire |
| designation | Titre du cursus | Char |  |
| description | Description du cursus | Char |  |
| number_of_hours | Nombre d'heure | Int |  |
| image | Chemin de l'image | Char |  |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |
| idFormation | Identifiant de la formation | Int | Clé étrangère |

## COURS

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| idCours | Identifiant du cours | Int | Clé primaire |
| designation | Titre du cours | Char |  |
| content | Contenu du cours (HTML) | Char |  |
| video | Chemin de la video | Char |   |
| time | Nombre d'heures ou de minutes | Int |  |
| order | ordre dans le cursus | Int |   |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |
| idCursus | Identifiant du cursus | Int | Clé étrangère |
