# NORG – Nitrogen ORGanizer: A standalone database system for local preservation of cryomaterial 
<img align="right" width="200" height="200" src="norg.png">


## How to install 

For database Dump install Cron 
- sudo apt-get update
- sudo apt-get install cron
    - crontab -e
    Command: 59 23 * * *  docker exec -i projekte_mariadb_1 mysqldump -u root --password=  bitnami_myapp > /home/[Benutzer]/Projekte/GIN-NORG/public/sqldumps/NorgDBdump$(date +\%Y\%m\%d).sql

## How to use

For Database Dump import:
- docker exec -i projekte_mariadb_1 mysql --user root bitnami_myapp < public/sqldumps/NorgDBdump[date].sql


## How to cite
