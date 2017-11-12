CREATE TABLE livres (
    num integer NOT NULL,
    titre text NOT NULL,
    editeur text,
    annee smallint
);



--
-- Data for Name: auteurs-livres; Type: TABLE DATA; 
--

COPY "auteurs-livres" (livre, auteur) FROM stdin;
1       J. Vromans
2       Stephane Robin
2       Francois Rodolphe
2       Sophie Schbath
3       Griffith
3       Miller
3       Suzuki
3       Lewontin
3       Gelbart
4       A. Michard
\.


--
-- Data for Name: livres; Type: TABLE DATA; 
--

COPY livres (num, titre, editeur, annee) FROM stdin;
1       Perl precis et concis   \N      2003
4       XML langage et applications     \N      2002
3       Introduction a l analyse genetique      De Boeck-Universite     2000
2       ADN, mots et modèles    Editions Belin  2003
\.


--
-- Name: auteurs-livres_pkey; Type: CONSTRAINT;
--

ALTER TABLE ONLY "auteurs-livres"
    ADD CONSTRAINT "auteurs-livres_pkey" PRIMARY KEY (livre, auteur);


--
-- Name: livres_pkey; Type: CONSTRAINT; 
--

ALTER TABLE ONLY livres
    ADD CONSTRAINT livres_pkey PRIMARY KEY (num);


--
-- Name: auteurs-livres_livre_fkey; Type: FK CONSTRAINT;
--

ALTER TABLE ONLY "auteurs-livres"
    ADD CONSTRAINT "auteurs-livres_livre_fkey" FOREIGN KEY (livre) REFERENCES livres(num);
