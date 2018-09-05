#!/bin/bash
# 05-09-2018
# alex
# dump.sh

BDUS="root"
BDBD="bdllibres"

mysqldump -u $BDUS -p $BDBD --add-drop-database --add-drop-table > ../sql/tot.sql
