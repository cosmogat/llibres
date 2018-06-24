-- Usuari
INSERT INTO bdllibres.Usuaris (idusuari, nom, codi, contrassenya, permisos) VALUES (1, "lila", "li", "pass_in_sha1", 0);
INSERT INTO bdllibres.Usuaris (idusuari, nom, codi, contrassenya, permisos) VALUES (2, "cosmo", "co", "pass_in_sha1", 2);
-- For generate the passwords use:
-- echo -n "write_pass_in_plain_text" | sha1sum -
