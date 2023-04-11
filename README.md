# NORG – Nitrogen ORGanizer: A standalone database system for local preservation of cryomaterial 
<img align="right" width="200" height="200" src="norg.png">


## How to install 

For Database Dump:
- make db_export.sh script executable
-> chmod +x db_export.sh
- Copy the script to the container
-> docker exec -i projekte_mariadb_1 bash -c "/tmp/db_export.sh"
- Replace the placeholders with your actual values in the db_export.sh script:
    - USERNAME="your_username"
    - PASSWORD="your_password"
    - DATABASE_NAME="your_database_name"
    - EXPORT_BASE_PATH="/dumps"

For daily database Dump install Cron 
- sudo apt-get update
- sudo apt-get install cron
    - crontab -e
    Command: 59 23 * * * docker exec -i projekte_mariadb_1 bash -c "/tmp/db_export.sh
    
If you just want SQL-Dump: Command: 59 23 * * *  docker exec -i projekte_mariadb_1 mysqldump -u root --password=  bitnami_myapp > /home/[Benutzer]/Projekte/GIN-NORG/public/sqldumps/NorgDBdump$(date +\%Y\%m\%d).sql

## How to use

For Database Dump import:
with the import script:
- Make the script executable 
-> chmod +x db_import.sh
- Copy the script to the container:
-> docker cp db_import.sh projekte_mariadb_1:/tmp/db_import.sh
- Replace the placeholders with your actual values in the db_import.sh script:
    - USERNAME="your_username"
    - PASSWORD="your_password"
    - DATABASE_NAME="your_database_name"
    - DATE="[date]"
    - EXPORT_BASE_PATH="/dumps"
    - EXPORT_PATH="$EXPORT_BASE_PATH/NorgDBdump$DATE"
either from SQL Dump import or from the CSV files -> comment out one of the versions in the script ether the commands for the csv-import or the sql import

-> Run the import script:
-> docker exec -i projekte_mariadb_1 bash -c "/tmp/db_import.sh"

For the SQL import, if you have done the SQL-Dump command without the script:
- docker exec -i projekte_mariadb_1 mysql --user root bitnami_myapp < public/sqldumps/NorgDBdump[date].sql


## How to cite
