create table cv(
id serial primary key,
file_name varchar(100),
file_path varchar(100)
);

create table langue(
id serial primary key,
name varchar(50)
);

insert into langue(name) values ('Anglais'),('Malagasy'),('Francais'),('Allemand'),('Espagnol'),('Mandarin'),('Arabe');

create table candidat(
id serial primary key,
nom varchar,
specialisation varchar,
genre varchar,
telephone varchar,
adresse varchar,
email varchar,
id_poste integer,
nationalite varchar,
date_postule date,
date_naissance date,
date_insertion date,
formation_diplome text,
competence text,
Experience_pro text,
qualite text,
centre_interet text,
id_statu integer,
id_cv_path integer

FOREIGN KEY (id_statu) REFERENCES statu(id),
FOREIGN KEY (id_cv_path) REFERENCES cv(id),
FOREIGN KEY (id_poste) REFERENCES poste(id),
);

create table candidat_langue(
    id serial primary key,
    id_candidat integer, 
    id_langue integer, 
    FOREIGN KEY (id_candidat) REFERENCES candidat(id),
    FOREIGN KEY (id_langue) REFERENCES langue(id)
);


create table statu(
  id serial primary key,
  nom varchar(30)
);

create table historique_statu(
  id serial primary key,
  id_user integer,
  id_candidat integer,
  id_statu_avant integer,
  id_statu_apres integer,
  created_at timestamp,
  updated_at timestamp,
  FOREIGN KEY (id_user) REFERENCES users(id),
  FOREIGN KEY (id_candidat) REFERENCES candidat(id),
  FOREIGN KEY (id_statu_avant) REFERENCES statu(id),
  FOREIGN KEY (id_statu_apres) REFERENCES statu(id)
);

create table suggestion_message(
  id serial primary key,
  nom varchar(255),
  message text
);

create table poste(
  id serial primary key,
  nom varchar(255),
);


create table questionnaire(
  id serial primary key,
  id_poste integer,
  question text,
  created_at timestamp,
  updated_at timestamp,
  FOREIGN KEY (id_poste) REFERENCES poste(id)
  ON DELETE CASCADE
);

create table reponse_questionnaire(
  id serial primary key,
  id_question integer,
  reponse text,
  note double precision,
  created_at timestamp,
  updated_at timestamp,
  FOREIGN KEY (id_question) REFERENCES questionnaire(id)
  ON DELETE CASCADE
);

create table mois(
  id serial primary key,
  nom varchar(50),
  numero int
);

create table user_question(
  id serial primary key,
  id_user integer,
  id_poste_question integer,
  FOREIGN KEY (id_poste_question) REFERENCES questionnaire(id),
  FOREIGN KEY (id_user) REFERENCES users(id)
  ON DELETE CASCADE
);

create table reponse_entretien(
  id serial primary key,
  id_user integer,
  id_question integer,
  id_reponse integer,
  reponse text,
  created_at timestamp,
  updated_at timestamp,
  FOREIGN KEY (id_question) REFERENCES questionnaire(id) ON DELETE CASCADE,
  FOREIGN KEY (id_reponse) REFERENCES reponse_questionnaire(id) ON DELETE CASCADE,
  FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE
);


create table classement (
  id serial primary key,
  id_user integer,
  id_poste integer,
  point double precision,
  created_at timestamp,
  updated_at timestamp,
  FOREIGN KEY (id_poste) REFERENCES poste(id) ON DELETE CASCADE,
  FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE

);

-- pour type = 0 notification de nouveau candidat, type = 1 notification de reponse entretien
create table notification (
  id serial primary key,
  id_user integer,
  type integer,
  created_at timestamp,
  updated_at timestamp,
  FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE
);

create table notification_recruteur(
  id serial primary key,
  id_notification integer not null,
  id_recruteur integer not null,
  is_read boolean default false,
  is_delete boolean default false,
  created_at timestamp,
  updated_at timestamp,
  FOREIGN KEY (id_notification) REFERENCES notification(id) ON DELETE CASCADE,
  FOREIGN KEY (id_recruteur) REFERENCES users(id) ON DELETE CASCADE
);

insert into poste(nom) values('Développeur Back-end'),('magasinier'),('comptable'),('agent de sécurité'),('Responsable ressource humaine');

insert into suggestion_message(nom,message) values('Demande entretien','Bonjour, Nous vous amenons a visiter notre site pour un entretient en ligne pour plus en savoir sur vous');
insert into suggestion_message(nom,message) values('Refuser','Bonjour, Nous somme sincerement desole de vous annoncer que nous ne somme pas interresse sur votre candidature');
insert into suggestion_message(nom,message) values('Mettre en attente','Bonjour, Nous somme heureux de recevoir votre candidature nous vous contacterons lorsque un poste sera disponible');

insert into statu(nom) values ('En cours'),('Embauche'),('non admis(e)');

INSERT INTO mois(nom, numero) 
VALUES 
('Janvier', 1),('Février', 2),('Mars', 3),('Avril', 4),('Mai', 5),('Juin', 6),('Juillet', 7),('Août', 8),('Septembre', 9),('Octobre', 10),('Novembre', 11),('Décembre', 12);


select * from candidat
JOIN statu 
ON candidat.id_statu = statu.id;

create view v_liste_candidat as
select c.id, c.nom, c.specialisation, c.genre, c.telephone, c.adresse, c.email, c.id_poste as id_poste, p.nom as poste_postule, c.nationalite, c.date_postule, c.date_naissance, c.date_insertion, 
c.formation_diplome, c.competence, c.experience_pro, c.qualite, c.centre_interet, c.created_at, c.updated_at, s.id as id_statu, s.nom as nom_statu from candidat c
JOIN statu s
ON c.id_statu = s.id
JOIN poste p
ON c.id_poste = p.id;

select*from v_liste_candidat where poste_postule = 'RH' and nom_statu = 'En cours'


create or replace view v_historique_statu as
select h.id, h.id_user, h.id_candidat, h.id_statu_avant, h.id_statu_apres, u.name as user_name, s.nom as statu_name_avant, s2.nom as statu_name_apres, DATE(h.updated_at) from historique_statu h 
join users u on u.id = h.id_user
join statu s on h.id_statu_avant = s.id
join statu s2 on h.id_statu_apres = s2.id;

create view v_langue as
select candidat_langue.id, candidat_langue.id_candidat, candidat_langue.id_langue, langue.name as langue from candidat_langue
JOIN langue on langue.id = candidat_langue.id_langue;

-- statistique par genre
create view v_stat_genre as
select count(candidat.id) as nombre, candidat.genre, EXTRACT(MONTH FROM date_postule) as numero_mois, mois.nom as mois, EXTRACT(YEAR FROM date_postule) as annee from candidat
join mois on
EXTRACT(MONTH FROM date_postule) = mois.numero 
group by EXTRACT(MONTH FROM date_postule), genre, mois.nom, EXTRACT(YEAR FROM date_postule) order by EXTRACT(MONTH FROM date_postule) ASC;

select count(*) from candidat where EXTRACT(YEAR FROM date_postule) = 2024;

select count(id), EXTRACT(MONTH FROM date_postule) as mois, genre from candidat where EXTRACT(YEAR FROM date_postule) = 2024 group by EXTRACT(MONTH FROM date_postule), genre;

select EXTRACT(MONTH FROM date_postule) as numero_mois, mois.nom from candidat
join mois on
EXTRACT(MONTH FROM date_postule) = mois.numero
group by EXTRACT(MONTH FROM date_postule), mois.nom;

-- statistique par poste generale par annee
create view v_stat_poste as
select count(*) as nombre, poste_postule, EXTRACT(YEAR FROM date_postule) as annee from v_liste_candidat group by id_poste, poste_postule, annee 

-- statistique par poste generale par annee par mois
create view v_stat_poste_mois as
select count(*) as nombre, poste_postule, EXTRACT(YEAR FROM date_postule) as annee, EXTRACT(MONTH FROM date_postule) as mois from v_liste_candidat group by id_poste, poste_postule, annee, mois

select v.nombre, v.poste_postule, v.annee, m.nom as mois, m.numero as numero_mois from v_stat_poste_mois v
join mois m on m.numero=v.mois


-- avoir le nombre de homme et femme totale en un an;
select sum(nombre) as nombre, genre, annee from v_stat_genre group by genre, annee;


-- statistique par statut
  create view v_stat_statut
  as
  select count(*) as nombre, id_statu, s.nom as statut, EXTRACT(YEAR FROM date_postule) from candidat v
  JOIN statut s
  ON s.id= v.id_statu
  group by v.id_statu, s.nom, annee;

-- statistique par statut par mois
  create view v_stat_statut_mois
  as
  select count(*) as nombre, id_statu, s.nom as statut, EXTRACT(YEAR FROM date_postule) as annee,EXTRACT(MONTH FROM date_postule) as numero_mois, m.nom as mois from candidat c
  JOIN statut s
  ON s.id= c.id_statu
  JOIN mois m
  ON m.numero= EXTRACT(MONTH FROM c.date_postule)
  group by c.id_statu, s.nom, annee, numero_mois, mois;


-- liste des candidats qui sont entree dans le site
  select*from users where level = 1;


  -- fiche d'entretien d'un candidat
  create view v_entretien as
  select r.id, r.id_user, q.id as id_question, q.question, r.id_reponse, r.reponse, rq.note, q.id_poste from reponse_entretien r
  JOIN questionnaire q on r.id_question = q.id
  LEFT JOIN reponse_questionnaire rq on r.id_reponse = rq.id
  ;

  select id_question, question from v_entretien group by id_question, question;
  select id_reponse, reponse, note from v_entretien where id_question=3;

  -- liste classement candidat
  create view v_classement as
  select users.name as nom, poste.nom as poste, poste.id as id_poste, classement.point, DATE(classement.created_at) as date from classement
  JOIN users on classement.id_user = users.id
  JOIN poste on classement.id_poste = poste.id;


-- liste de question entretien pour un candidat
create view v_liste_entretien as
select u.id, id_user, u.id_poste_question, p.nom as poste from user_question u
JOIN poste p on u.id_poste_question = p.id;

-- liste de reponse entretien
create view v_liste_reponse_poste as
select p.nom as poste, p.id as id_poste, r.id_user, DATE(r.created_at)as date_reponse from reponse_entretien r
JOIN questionnaire q on r.id_question = q.id
JOIN poste p on q.id_poste= p.id
group by p.nom, p.id, r.id_user, r.created_at

-- afficher les questionnaire disponibles dans la page envoyer pour envoyer question
create view v_questionnaire_dispo as
select p.id as id_poste, p.nom as poste from questionnaire q
JOIN poste p on p.id= q.id_poste
GROUP BY p.id, p.nom

-- verifier si reponse est classe ou non
create or replace view v_verification_classement as
select c.id_user as user_classe, p.nom as poste, p.id as id_poste, r.id_user, DATE(r.created_at)as date_reponse from reponse_entretien r
JOIN questionnaire q on r.id_question = q.id
JOIN poste p on q.id_poste= p.id
LEFT JOIN classement c on c.id_user = r.id_user
group by c.id_user, p.nom, p.id, r.id_user, r.created_at

-- affichage de notication avec jointure notification et user
crete view v_notification as
select u.name,u.id as id_candidat, n.type, n.created_at,n.id as id_notification, nr.id_recruteur,nr.is_read,nr.is_delete from notification_recruteur nr 
JOIN notification n
ON
n.id = nr.id_notification
JOIN users u 
ON
n.id_user = u.id