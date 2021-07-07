# MLD

**TEST** (<ins>idTest</ins>, designation, description, image, type, test_link, created_at, updated_at,_idCours_)  
**RESULTAT** (<ins>idResultat</ins>, score, created_at, updated_at,_idStagiaire_,_idTest_)  
**ROLE** (<ins>idRole</ins>, type, created_at, updated_at)  
**COURS** (<ins>idCours</ins>, designation, content, video, time, order, created_at, updated_at,_idCursus_)  
**STAGIAIRE** (<ins>idStagiaire</ins>, created_at, updated_at,_idUser_,_idCours_,_idFormation_)  
**USER** (<ins>idUser</ins>, name, status_id, email, email_verified_at, password, preference, remember_token, created_at, updated_at,_idRole_)  
**DEMANDE** (<ins>_idFormation_</ins>, <ins>_idStagiaire_</ins>)  
**CURSUS** (<ins>idCursus</ins>, designation, description, number_of_hours, image, created_at, updated_at,_idFormation_)  
**FORMATION** (<ins>idFormation</ins>, libelé, description, reference, prix, user_ref, token, method, categorie, created_at, updated_at, _immatriculation_)  
**CENTRE** (<ins>immatriculation</ins>, created_at, updated_at, _idUser_)
