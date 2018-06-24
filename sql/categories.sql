-- Llengües
INSERT INTO bdllibres.Idiomes (idIdiomes, nom) VALUES (1, "Castellà");
INSERT INTO bdllibres.Idiomes (idIdiomes, nom) VALUES (2, "Català");
INSERT INTO bdllibres.Idiomes (idIdiomes, nom) VALUES (3, "Anglès");
INSERT INTO bdllibres.Idiomes (idIdiomes, nom) VALUES (4, "Francès");
INSERT INTO bdllibres.Idiomes (idIdiomes, nom) VALUES (5, "Occità");
-- Classificació
INSERT INTO bdllibres.Classificacio (idcla, nom, codi) VALUES (1, "Informació i obres en general", 0);
INSERT INTO bdllibres.Classificacio (idcla, nom, codi) VALUES (2, "Filosofia i Psicologia", 1);
INSERT INTO bdllibres.Classificacio (idcla, nom, codi) VALUES (3, "Religió", 2);
INSERT INTO bdllibres.Classificacio (idcla, nom, codi) VALUES (4, "Ciències Socials", 3);
INSERT INTO bdllibres.Classificacio (idcla, nom, codi) VALUES (5, "Llengua", 4);
INSERT INTO bdllibres.Classificacio (idcla, nom, codi) VALUES (6, "Ciència", 5);
INSERT INTO bdllibres.Classificacio (idcla, nom, codi) VALUES (7, "Tecnologia", 6);
INSERT INTO bdllibres.Classificacio (idcla, nom, codi) VALUES (8, "Arts i Lleure", 7);
INSERT INTO bdllibres.Classificacio (idcla, nom, codi) VALUES (9, "Literatura", 8);
INSERT INTO bdllibres.Classificacio (idcla, nom, codi) VALUES (10, "Història, Geografia i Biografia", 9);

INSERT INTO bdllibres.Subclassificacio (idsub, classi, nom, codi) VALUES (1, 6, "Matemàtiques", 1);
INSERT INTO bdllibres.Subclassificacio (idsub, classi, nom, codi) VALUES (2, 6, "Física", 2);
INSERT INTO bdllibres.Subclassificacio (idsub, classi, nom, codi) VALUES (3, 6, "Química", 3);
INSERT INTO bdllibres.Subclassificacio (idsub, classi, nom, codi) VALUES (4, 6, "Biologia", 4);
INSERT INTO bdllibres.Subclassificacio (idsub, classi, nom, codi) VALUES (5, 6, "Generalitats", 0);

INSERT INTO bdllibres.Subsubclassificacio (idsubsub, subclassi, nom, codi) VALUES (1, 1, "Matemàtiques General", 0);
INSERT INTO bdllibres.Subsubclassificacio (idsubsub, subclassi, nom, codi) VALUES (2, 1, "Àlgebra", 1);
INSERT INTO bdllibres.Subsubclassificacio (idsubsub, subclassi, nom, codi) VALUES (3, 1, "Càlcul", 2);
INSERT INTO bdllibres.Subsubclassificacio (idsubsub, subclassi, nom, codi) VALUES (4, 1, "Càlcul Computacional", 3);

INSERT INTO bdllibres.Subclassificacio (idsub, classi, nom, codi) VALUES (6, 9, "Novel·la", 1);
INSERT INTO bdllibres.Subsubclassificacio (idsubsub, subclassi, nom, codi) VALUES (5, 6, "Ciència Ficció", 1);

INSERT INTO bdllibres.Subclassificacio (idsub, classi, nom, codi) VALUES (7, 5, "Català", 1);
INSERT INTO bdllibres.Subsubclassificacio (idsubsub, subclassi, nom, codi) VALUES (6, 7, "Dialectologia", 5);

INSERT INTO bdllibres.Subclassificacio (idsub, classi, nom, codi) VALUES (8, 8, "Fotografia", 1);
INSERT INTO bdllibres.Subsubclassificacio (idsubsub, subclassi, nom, codi) VALUES (7, 8, "Fotografia General", 0);

INSERT INTO bdllibres.Subclassificacio (idsub, classi, nom, codi) VALUES (9, 4, "Política", 1);
INSERT INTO bdllibres.Subclassificacio (idsub, classi, nom, codi) VALUES (10, 4, "Educació", 2);
INSERT INTO bdllibres.Subsubclassificacio (idsubsub, subclassi, nom, codi) VALUES (8, 9, "Esquerra en general", 1);
INSERT INTO bdllibres.Subsubclassificacio (idsubsub, subclassi, nom, codi) VALUES (9, 9, "Anticapitalisme", 2);
INSERT INTO bdllibres.Subsubclassificacio (idsubsub, subclassi, nom, codi) VALUES (10, 9, "Marxisme", 3);
INSERT INTO bdllibres.Subsubclassificacio (idsubsub, subclassi, nom, codi) VALUES (11, 9, "Anarquisme", 4);
INSERT INTO bdllibres.Subsubclassificacio (idsubsub, subclassi, nom, codi) VALUES (12, 9, "Sindicalisme", 5);
INSERT INTO bdllibres.Subsubclassificacio (idsubsub, subclassi, nom, codi) VALUES (13, 9, "Republicanisme", 6);
INSERT INTO bdllibres.Subsubclassificacio (idsubsub, subclassi, nom, codi) VALUES (14, 9, "Nacionalisme", 7);
INSERT INTO bdllibres.Subsubclassificacio (idsubsub, subclassi, nom, codi) VALUES (15, 10, "Ciències", 1);
INSERT INTO bdllibres.Subsubclassificacio (idsubsub, subclassi, nom, codi) VALUES (16, 10, "Educació llibertària", 2);

INSERT INTO bdllibres.Subclassificacio (idsub, classi, nom, codi) VALUES (11, 10, "Contemporània", 1);
INSERT INTO bdllibres.Subsubclassificacio (idsubsub, subclassi, nom, codi) VALUES (17, 11, "Local", 1);
