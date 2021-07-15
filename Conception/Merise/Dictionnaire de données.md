# Dictionnaire de données

## Utilisateur

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| ID | Identifiant de l'utilisateur | BigInt | Clé primaire |
| Nom| Nom de l'utilisateur | Char |  |
| Prenom| Prenom de l'utilisateur | Char |  |
| Email| Email de l'utilisateur | Char |  |
| Telephone| Telephone de l'utilisateur | Char |  |
| Mot_De_Passe| Mot de passe de l'utilisateur | Char |  |
| Image| Lien de la photo de profil de l'utilisateur | Char | Champ non obligatoire |
| ID_Role| Role de l'utilisateur | BigInt | Clé étrangère |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |

## Role

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| ID | Identifiant du role | BigInt | Clé primaire |
| Type| Type du role | Char |  |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |


## Stagiaire

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| ID | Identifiant du stagiaire | BigInt | Clé primaire |
| Etat| Stagiaire activé ou désactivé | Boolean | Désactivé si l'inscription du stagiaire n'est pas encore validé |
| ID_Type_Inscription| Type d'inscription du stagiaire | BigInt |Clé étrangère  |
| ID_Organisation| Organisation à laquelle le stagiaire appartient| BigInt |Clé étrangère,champ non obligatoire(Stagiaire indépendant)   |
| ID_Formateur| Coach du stagiaire| BigInt |Clé étrangère,champ non obligatoire(Stagiaire sans coach)   |
| ID_Utilisateur| Identifiant de l'utilisateur| BigInt |Clé étrangère   |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |

## Type_Inscription

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| ID | Identifiant du type d'inscription | BigInt | Clé primaire |
| Type| Type d'inscription du stagiaire | Char |  |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |


## Organisation

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| ID | Identifiant de l'organisation | BigInt | Clé primaire |
| Designation| Nom de l'organisation | Char |  |
| ID_Utilisateur| Identifiant de l'utilisateur| BigInt |Clé étrangère   |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |

## Formateur

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| ID | Identifiant du formateur | BigInt | Clé primaire |
| Parcours| Description du parcours du formateur | Char |  |
| CV| Lien du CV du formateur | Char |  |
| ID_Utilisateur| Identifiant de l'utilisateur| BigInt |Clé étrangère   |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |


## Cursus

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| ID | Identifiant du cursus | BigInt | Clé primaire |
| Designation| Titre du cursus | Char |  |
| Description| Description du cursus  | Char |  |
| Image| Lien de l'image du cursus  | Char | Champ non obligatoire |
| Volume_Horaire| Le volume horaire du cursus  | Int |  |
| Effectif| Le nombre de stagiaire accepté pour le cursus  | Int |  |
| Nombre_Cours_Total| Le nombre de cours que contient le cursus  | Int | Modifié à chaque ajout de cours pour le cursus |
| Nombre_Chapitres_Total| Le nombre total de chapitres que contient le cursus  | Int | Modifié à chaque ajout de chapitre pour le cursus |
| Prix| Prix du cursus  | Char |  |
| Etat| Cursus activé ou désactivé  | Boolean |Désactivé automatiquement s'il n'y a pas de formateur ou si aucun cours n'est actif, ne peut pas être désactivé si une session est en cours   |
| ID_Categorie| Identifiant de la catégorie du cursus| BigInt |Clé étrangère   |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |

## Categorie

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| ID | Identifiant de la catégorie | BigInt | Clé primaire |
| Designation| Le type de la catégorie | Char |  |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |

## Cours

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| ID | Identifiant du cours | BigInt | Clé primaire |
| Numero_Cours| Le numéro du cours  | Int | Clé primaire,modifié à chaque ajout de cours pour le cursus |
| Designation| Titre du cours | Char |  |
| Image| Lien de l'image du cours  | Char | Champ non obligatoire |
| Nombre_Chapitres| Le nombre de chapitres que contient le cours  | Int | Modifié à chaque ajout de chapitre pour le cours |
| Prix| Prix du cours  | Char |  |
| Etat| Cours activé ou désactivé  | Boolean | Désactivé automatiquement si aucun chapitre n'est actif |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |

## Cursus_Contenir_Cours

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| ID_Cursus | Identifiant du cursus auquel appartient le cours| BigInt | Clé primaire, clé étrangère |
| ID_Cours| Identifiant du cours| BigInt |Clé primaire, clé étrangère   |
| Numero_Cours| Le numéro du cours | Int |Clé primaire, clé étrangère   |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |

## Chapitre

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| ID | Identifiant du chapitre | BigInt | Clé primaire |
| Numero_Chapitre| Le numéro du chapitre  | Int | Clé primaire,modifié à chaque ajout de chapitre pour le cours |
| Designation| Titre du chapitre | Char |  |
| Image| Lien de l'image du chapitre  | Char | Champ non obligatoire |
| Video| Lien de la video du chapitre  | Char | |
| Etat| Chapitre activé ou désactivé  | Boolean |Désactivé automatiquement si aucun chapitre n'est actif  |
| ID_Cours| Identifiant du cours auquel appartient le chapitre| BigInt |Clé étrangère   |
| Numero_Cours| Le numéro du cours auquel appartient le chapitre| Int |Clé étrangère   |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |

## Section

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| ID | Identifiant de la section | BigInt | Clé primaire |
| Designation| Titre de la section | Char |  |
| Contenu| Le contenu de la section | Char |  |
| Image| Lien de l'image de la section  | Char | Champ non obligatoire |
| Etat| Section activée ou désactivée  | Boolean |  |
| ID_Chapitre| Identifiant du chapitre auquel appartient la section| BigInt |Clé étrangère   |
| Numero_Chapitre| Le numéro du chapitre auquel appartient la section| Int |Clé étrangère   |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |

## Exercice

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| ID | Identifiant de l'exercice | BigInt | Clé primaire |
| Enonce| L'énoncé de l'exercice | Char |  |
| Image| Lien de l'image de l'exercice  | Char | Champ non obligatoire |
| Etat| Exercice activé ou désactivé  | Boolean |  |
| ID_Chapitre| Identifiant du chapitre auquel appartient l'exercice| BigInt |Clé étrangère   |
| Numero_Chapitre| Le numéro du chapitre auquel appartient l'exercice| Int |Clé étrangère   |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |

## Question_Exercice

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| ID | Identifiant de la question de l'exercice | BigInt | Clé primaire |
| Question| La question de l'exercice | Char |  |
| Etat| Exercice activé ou désactivé  | Boolean |  Désactivé automatiquement si la correction n'est pas actif|
| ID_Exercice| Identifiant de l'exercice auquel appartient la question| BigInt |Clé étrangère   |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |

## Correction_Question

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| ID | Identifiant de la correction de la question de l'exercice | BigInt | Clé primaire |
| Reponse| La réponse de la question de l'exercice | Char |  |
| Image| Lien de l'image de la correction | Char | Champ non obligatoire |
| Etat| Correction activée ou désactivée  | Boolean |  |
| ID_Question_Exercice| Identifiant de la question l'exercice auquel appartient la correction| BigInt |Clé étrangère   |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |

## QCM

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| ID | Identifiant du QCM | BigInt | Clé primaire |
| Designation| Titre du QCM | Char | Désactivé automatiquement si aucune question n'est active |
| Etat| QCM activé ou désactivé  | Boolean |  |
| ID_Chapitre| Identifiant du chapitre auquel appartient le QCM| BigInt |Clé étrangère   |
| Numero_Chapitre| Le numéro du chapitre auquel appartient le QCM| Int |Clé étrangère   |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |

## Questions_QCM

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| ID | Identifiant de la question du QCM | BigInt | Clé primaire |
| Question| Question du QCM | Char |  |
| Explication| Explication de la réponse à la question  | Char | Champ non obligatoire |
| Etat| Question activé ou désactivé  | Boolean | Désactivé automatiquement si la réponse n'est pas active |
| ID_QCM| Identifiant du QCM auquel appartient la question| BigInt |Clé étrangère   |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |

## Reponse_Question_QCM

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| ID | Identifiant de la réponse de la question du QCM | BigInt | Clé primaire |
| Reponse| Réponse à la question du QCM | Char |  |
| Validation| Savoir si la réponse est juste  | Boolean |  |
| Etat| Réponse activé ou désactivé  | Boolean |  |
| ID_Question_QCM| Identifiant de la question du QCM auquel appartient la réponse| BigInt |Clé étrangère   |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |

## Score_QCM

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| ID | Identifiant du score du stagiaire | BigInt | Clé primaire |
| Résultat| Savoir si le stagiaire a réussi le QCM | Int | Pourcentage calculé à partir du nombre de réponses justes par rapport au nombre total de question  |
| ID_Stagiaire| Identifiant du stagiaire auquel appartient le score| BigInt |Clé étrangère   |
| ID_QCM| Identifiant du QCM auquel appartient le score| BigInt |Clé étrangère   |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |

## Projet

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| ID | Identifiant du projet | BigInt | Clé primaire |
| Description | Description du projet | Char | |
| Date_Debut| Date du début du projet | Date |Champ non obligatoire   |
| Date_Fin| Date de fin du projet | Date |Champ non obligatoire   |
| Etat| Projet activé ou désactivé  | Boolean |  |
| ID_Cours| Identifiant du cours auquel appartient le projet| BigInt |Clé étrangère , champ non obligatoire (Si le champ est indiqué le stagiaire ne peut pas passer au cours suivant tant qu'il n'a pas terminé le projet)|
| Numero_Cours| Numéro du cours auquel appartient le projet| BigInt |Clé étrangère , champ non obligatoire (Si le champ est indiqué le stagiaire ne peut pas passer au cours suivant tant qu'il n'a pas terminé le projet)|
| ID_Formateur| Identifiant du formateur qui a créé le projet| BigInt |Clé étrangère |
| ID_Statut| Identifiant du statut du projet| BigInt |Clé étrangère |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |

## Faire_Projet

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| ID_Projet | Identifiant du projet | BigInt | Clé primaire, clé étrangère |
| ID_Stagiaire | Identifiant du stagiaire | BigInt | Clé primaire, clé étrangère |
| Statut_Reussite| Savoir si le stagiaire a réussi le projet | Boolean | Champ non obligatoire ( rempli par le coach lorsque le projet est terminé) |
| Resultat_Description| Description du résultat du stagiaire  | Boolean | Champ non obligatoire ( rempli par le coach lorsque le projet est terminé) |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |

## Statut

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| ID | Identifiant du statut | BigInt | Clé primaire |
| Statut | Type du statut | Char | Non débuté(e), En cours, terminé(e) , Annulé(e) |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |

## Document

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| ID | Identifiant du document | BigInt | Clé primaire |
| Designation | Nom du document | Char |  |
| Lien| Lien du document | Char | |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |


## Contenir_Document_Projet

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| ID_Projet | Identifiant du projet | BigInt | Clé primaire, clé étrangère |
| ID_Document | Identifiant du document | BigInt | Clé primaire, clé étrangère |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |

## Contenir_Document_Chapitre

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| ID_Chapitre | Identifiant du chapitre | BigInt | Clé primaire, clé étrangère |
| Numero_Chapitre | Numéro du chapitre | Int | Clé primaire, clé étrangère |
| ID_Document | Identifiant du document | BigInt | Clé primaire, clé étrangère |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |

## Meeting_En_Ligne

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| ID | Identifiant de la réunion en ligne | BigInt | Clé primaire |
| Description | Description de la réunion en ligne | Char |  |
| Lien | Lien de la réunion en ligne | Char |  |
| Code | Code de la réunion en ligne | Char | Champ non obligatoire |
| Date_Meeting | Date de la réunion en ligne | Timestamp |  |
| Statut | Identifiant du statut de la réunion en ligne | BigInt | Clé étrangère |
| ID_Cours| Identifiant du cours | BigInt |Clé étrangère , champ non obligatoire (Si le champ est indiqué le stagiaire ne peut pas passer au cours suivant tant qu'il n'a pas assisté et validé la réunion en ligne)|
| Numero_Cours| Numéro du cours | Int |Clé étrangère , champ non obligatoire (Si le champ est indiqué le stagiaire ne peut pas passer au cours suivant tant qu'il n'a pas assisté et validé la réunion en ligne)|
|ID_Utilisateur|Identifiant du hôte de la réunion en ligne | BigInt |Clé étrangère |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |

## Participer_Meeting

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| ID_Utilisateur | Identifiant du participant à la réunion en ligne | BigInt | Clé primaire, clé étrangère  |
| ID_Meeting | Identifiant de la réunion en ligne | BigInt | Clé primaire, clé étrangère  |
| Validation | Savoir si le stagiaire a été validé après la réunion en ligne |Boolean|champ non obligatoire (champ rempli après la réunion,le stagiaire ne peut pas passer au cours suivant tant qu'il n'a pas été validé)  |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |

## Mot_Cle

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| ID | Identifiant du mot clé | BigInt | Clé primaire  |
| Designation | Designation du mot clé | Char |  |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |

## Avoir_Cursus_Mot_Cle

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| ID_Cursus| Identifiant du cursus auquel appartient le mot clé| BigInt |Clé primaire , clé étrangère   |
| ID_Mot_Cle | Identifiant du mot clé| BigInt |Clé primaire , clé étrangère   |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |


## Avoir_Cours_Mot_Cle

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| ID_Cours| Identifiant du cours auquel appartient le mot clé| BigInt |Clé primaire , clé étrangère   |
| ID_Mot_Cle | Identifiant du mot clé| BigInt |Clé primaire , clé étrangère   |
| Numero_Cours| Le numéro du cours auquel appartient le mot clé| Int | Clé primaire, clé étrangère   |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |

## Avoir_Preference

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| ID_Stagiaire| Identifiant du stagiaire| BigInt |Clé primaire , clé étrangère   |
| ID_Mot_Cle | Identifiant du mot clé| BigInt |Clé primaire , clé étrangère   |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |


## Suivre_Cursus

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| ID_Cursus| Identifiant du cursus que le stagiaire suit| BigInt |Clé primaire , clé étrangère   |
| ID_Stagiaire | Identifiant du stagiaire| BigInt |Clé primaire , clé étrangère   |
| ID_Cours| Identifiant du cours en cours de suivis par le stagiaire | BigInt |Clé étrangère ,passe automatiquement au cours suivant si le cours en cours a été désactivé  |
| ID_Chapitre| Identifiant du chapitre en cours de suivis par le stagiaire | BigInt |Clé étrangère   |
| Nombre_Chapitre_Lu| Le nombre de chapitres lus par le stagiaire | Int |Calculé à chaque avancement du stagiaire dans le cursus , passe automatiquement au chapitre suivant si le chapitre en cours a été désactivé  |
| Progression| Progression du stagiaire dans le cursus suivi | Int |Pourcentage calculé à partir du nombre de chapitres lus par le stagiaire par rapport au nombre total de chapitre du cursus   |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |


## Suivre_Cours

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| ID_Cours| Identifiant du cours que le stagiaire suit| BigInt |Clé primaire , clé étrangère   |
| Numero_Cours| Numero du cours que le stagiaire suit| Int |Clé primaire , clé étrangère   |
| ID_Stagiaire | Identifiant du stagiaire| BigInt |Clé primaire , clé étrangère   |
| ID_Chapitre| Identifiant du chapitre en cours de suivis par le stagiaire | BigInt |Clé étrangère,passe automatiquement au chapitre suivant si le chapitre en cours a été désactivé   |
| Nombre_Chapitre_Lu| Le nombre de chapitres lus par le stagiaire | Int |Calculé à chaque avancement du stagiaire dans le cours   |
| Progression| Progression du stagiaire dans le cours suivi | Int |Pourcentage calculé à partir du nombre de chapitres lus par le stagiaire par rapport au nombre total de chapitre du cours   |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |

## Session

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| ID | Identifiant de la session | BigInt | Clé primaire |
| Date_Debut| Date du début de la session | Date |  |
| Date_Fin| Date de fin de la session| Date |  |
| Etat| Session activé ou désactivé  | Boolean |  |
| ID_Formateur| Identifiant du formateur de la session| BigInt |Clé étrangère |
| ID_Cursus| Identifiant du cursus de la session| BigInt |Clé étrangère |
| ID_Statut| Identifiant du statut de la session| BigInt |Clé étrangère |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |

## Lier_Session_Stagiaire

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| ID_Stagiaire | Identifiant du stagiaire participant à la session| BigInt | Clé primaire, clé étrangère |
| ID_Session | Identifiant de la session| BigInt | Clé primaire, clé étrangère |
| Etat| Liaison activé ou désactivé  | Boolean |Désactiver automatiquement si la session est terminée|
| Validation| Savoir si le stagiaire a réussi la session | Boolean | Champ non obligatoire ( rempli par le formateur lorsque la session est terminé) |
| Resultat_Description| Description du résultat du stagiaire  | Boolean | Champ non obligatoire ( rempli par le formateur lorsque la session est terminé) |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |

## Titre

| Nom | Description | Type | Commentaire |
| :--------------- |:---------------:|:---------------:| -----:|
| ID | Identifiant du titre| BigInt | Clé primaire|
| Intitulé | Intitulé du titre| Char | |
| Date_Obtention| Date d'obtention du titre | Date |  |
| ID_Stagiaire| Identifiant du stagiaire qui a obtenu le titre  | BigInt |Clé étrangère  |
| created_at | Date de création | Timestamp |   |
| updated_at | Date de modification | Timestamp |   |
