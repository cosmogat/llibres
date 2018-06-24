# llibresPHP
A web application for manage your own library

## Install
Go to your www folder and write:
```
git clone https://github.com/cosmogat/llibres
cd llibres/sh
./ins_dep.sh

cd ../sql
mysql -u USER -pPASS < creacio.sql
mysql -u USER -pPASS bdllibres < categories.sql
cd ..
```
Change USER and PASS by your own user and password of MySQL server.

## Configuration
You need to create a configuration file in *cnf* folder like *cnf/conf_0.inc.php.example*. You can do this:
```
cd cnf
cp conf_0.inc.php.example conf_0.inc.php
cd ..
```
Now you need to edit the configuration file to connect to database server. After this you can create other configuration files with the same syntax and the same pattern for the name, for example *conf_1.inc.php*, *conf_2.inc.php*, *conf_5.inc.php*, etc. The numbers 1,2 and 5 are the identifiers and you need to put the number, of the configuration that you want, in the *quinperfil.txt* file. For example if you want *conf_3.inc.php* configuration file you can do this:
```
cd cnf
echo "3" > quinperfil.txt
cd ..
```

## References
* [bootstrap](https://github.com/twbs/bootstrap) - Bootstrap
* [jquery](https://github.com/jquery/jquery) - jQuery JavaScript Library.
* [lightbox2](https://github.com/lokesh/lightbox2) - Lightbox script.
* [openclipart](https://openclipart.org/) - Open Clipart.
## Autors
* **Cosmo Cat**  [cosmogat](https://github.com/cosmogat)
## License
See the [LICENSE](LICENSE)
