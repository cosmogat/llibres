#!/bin/bash
# 24-06-2018
# cosmogat
# ins_dep.sh

JQUERY_VER="3.3.1"
BOOTST_VER="3.3.7"

cd ..
cd js
wget "https://code.jquery.com/jquery-$JQUERY_VER.min.js" -O jquery.min.js
cd ..
wget "https://github.com/twbs/bootstrap/releases/download/v$BOOTST_VER/bootstrap-$BOOTST_VER-dist.zip" -O bs.zip
unzip bs.zip
rm bs.zip
mv "bootstrap-$BOOTST_VER-dist" bs
cd bs
mv css/* ../css/
mv js/* ../js/
mv fonts/* ../fonts/
cd ..
rm -rf bs
wget https://github.com/lokesh/lightbox2/archive/master.zip
unzip master.zip
rm master.zip
cd lightbox2-master/src
cp css/lightbox.css ../../css/
cp js/lightbox.js ../../js/
cp -r images ../../
cd ../..
rm -rf lightbox2-master
