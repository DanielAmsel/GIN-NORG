#     Make the script executab
# chmod +x db_import.sh

#     Copy the script to the container:
# docker cp db_import.sh projekte_mariadb_1:/tmp/db_import.sh

#     Run the script inside the container:
# docker exec -i projekte_mariadb_1 bash -c "/tmp/db_import.sh"


# Replace the placeholders with your actual values
USERNAME="your_username"
PASSWORD="your_password"
DATABASE_NAME="your_database_name"
DATE="[date]"
EXPORT_BASE_PATH="/dumps"
EXPORT_PATH="$EXPORT_BASE_PATH/NorgDBdump$DATE"

# make sure the tables are truncated or empty before importing the data to avoid conflicts or duplicate entries
# either from SQL Dump import or from the CSV files 

# Import from SQL Dump
mysql --user root bitnami_myapp < public/sqldumps/NorgDBdump$DATE/NorgSQLdump$DATE.sql

# Import fomr CSV files
# Import data back to table roles
mysql -u $USERNAME -p$PASSWORD $DATABASE_NAME -e "SET FOREIGN_KEY_CHECKS = 0; LOAD DATA INFILE '$EXPORT_PATH/roles$DATE.csv' INTO TABLE roles FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\r\n'; SET FOREIGN_KEY_CHECKS = 1;"

# Import data back to table users
mysql -u $USERNAME -p$PASSWORD $DATABASE_NAME -e "SET FOREIGN_KEY_CHECKS = 0; LOAD DATA INFILE '$EXPORT_PATH/users$DATE.csv' INTO TABLE users FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\r\n' (id, name, email, email_verified_at, password, role, @remember_token, @created_at, @updated_at) SET remember_token = NULLIF(@remember_token, '\N'), created_at = NULLIF(@created_at, '\N'), updated_at = NULLIF(@updated_at, '\N'); SET FOREIGN_KEY_CHECKS = 1;"

# Import data back to table tank_model
mysql -u $USERNAME -p$PASSWORD $DATABASE_NAME -e "SET FOREIGN_KEY_CHECKS = 0; LOAD DATA INFILE '$EXPORT_PATH/tank_model$DATE.csv' INTO TABLE tank_model FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\r\n'; SET FOREIGN_KEY_CHECKS = 1;"

# Import data back to table storage_tank
mysql -u $USERNAME -p$PASSWORD $DATABASE_NAME -e "SET FOREIGN_KEY_CHECKS = 0; LOAD DATA INFILE '$EXPORT_PATH/storage_tank$DATE.csv' INTO TABLE storage_tank FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\r\n'; SET FOREIGN_KEY_CHECKS = 1;"

# Import data back to table material_types
mysql -u $USERNAME -p$PASSWORD $DATABASE_NAME -e "SET FOREIGN_KEY_CHECKS = 0; LOAD DATA INFILE '$EXPORT_PATH/material_types$DATE.csv' INTO TABLE material_types FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\r\n'; SET FOREIGN_KEY_CHECKS = 1;"

# Import data back to table sample
mysql -u $USERNAME -p$PASSWORD $DATABASE_NAME -e "SET FOREIGN_KEY_CHECKS = 0; LOAD DATA INFILE '$EXPORT_PATH/sample$DATE.csv' INTO TABLE sample FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\r\n' (id, identifier, pos_tank_nr, pos_insert, pos_tube, pos_smpl, responsible_person, type_of_material, @commentary, storage_date, shipping_date, removal_date) SET commentary = NULLIF(@commentary, '\N'); SET FOREIGN_KEY_CHECKS = 1;"

# Import data back to table shipped_sample
mysql -u $USERNAME -p$PASSWORD $DATABASE_NAME -e "SET FOREIGN_KEY_CHECKS = 0; LOAD DATA INFILE '$EXPORT_PATH/shipped_sample$DATE.csv' INTO TABLE shipped_sample FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\r\n' (id, identifier, responsible_person, type_of_material, storage_date, shipping_date, shipped_to, @created_at, @updated_at) SET created_at = NULLIF(@created_at, '\N'), updated_at = NULLIF(@updated_at, '\N'); SET FOREIGN_KEY_CHECKS = 1;"

# Import data back to table removed_sample
mysql -u $USERNAME -p$PASSWORD $DATABASE_NAME -e "SET FOREIGN_KEY_CHECKS = 0; LOAD DATA INFILE '$EXPORT_PATH/removed_sample$DATE.csv' INTO TABLE removed_sample FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\r\n' (id, identifier, responsible_person, type_of_material, storage_date, removal_date, @created_at, @updated_at) SET created_at = NULLIF(@created_at, '\N'), updated_at = NULLIF(@updated_at, '\N'); SET FOREIGN_KEY_CHECKS = 1;"
