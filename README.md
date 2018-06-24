# llibresPHP
A web application for manage your own library

## Install
Go to your www folder and write:
```
git clone https://github.com/cosmogat/llibres
cd llibres/js
wget https://code.jquery.com/jquery-3.3.1.min.js -O jquery.min.js
cd ..
wget https://github.com/twbs/bootstrap/releases/download/v3.3.7/bootstrap-3.3.7-dist.zip -O bs.zip
unzip bs.zip
rm bs.zip
mv bootstrap-3.3.7-dist bs
cd bs
mv css/* ../css/
mv js/* ../js/
mv fonts/* ../fonts/
cd ..
rm -rf bs

cd ../sql
mysql -u USER -pPASS < bdrosquilletes.sql
mysql -u USER -pPASS bdrosquilletes < insert.sql
cd -
```
Change USER and PASS by your own user and password of MySQL server.

## References
* [jquery](https://github.com/jquery/jquery) - jQuery JavaScript Library.
* [openclipart](https://openclipart.org/) - Open Clipart.
## Autors
* **Cosmo Cat**  [cosmogat](https://github.com/cosmogat)
## License
See the [LICENSE](LICENSE)
