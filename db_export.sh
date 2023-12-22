#     Make the script executab
# chmod +x db_export.sh

#     Copy the script to the container:
# docker cp db_export.sh [mariadb container name]:/tmp/db_export.sh

#     Run the script inside the container:
# docker exec -i [mariadb container name] bash -c "/tmp/db_export.sh"

# Replace the placeholders with your actual values
USERNAME="your_username"
PASSWORD="your_password"
DATABASE_NAME="your_database_name"
EXPORT_BASE_PATH="/dumps"

# Create a new directory with the current date
EXPORT_PATH="$EXPORT_BASE_PATH/NorgDBdump$(date +%Y%m%d)"
mkdir -p "$EXPORT_PATH"

# Export data to SQL Dump
mysqldump -u $USERNAME -p$PASSWORD $DATABASE_NAME > $EXPORT_PATH/NorgSQLdump$(date +%Y%m%d).sql

# Export data to CSV files
# Export table roles
mysql -u $USERNAME -p$PASSWORD $DATABASE_NAME -e "SELECT * INTO OUTFILE '$EXPORT_PATH/roles$(date +%Y%m%d).csv' FIELDS TERMINATED BY ',' ENCLOSED BY '\"' ESCAPED BY '\"' LINES TERMINATED BY '\r\n' FROM roles;"

# Export table users
mysql -u $USERNAME -p$PASSWORD $DATABASE_NAME -e "SELECT id, name, email, email_verified_at, password, role, IFNULL(remember_token, 'N'), IFNULL(created_at, 'N'), IFNULL(updated_at, 'N') INTO OUTFILE '$EXPORT_PATH/users$(date +%Y%m%d).csv' FIELDS TERMINATED BY ',' ENCLOSED BY '\"' ESCAPED BY '\"' LINES TERMINATED BY '\r\n' FROM users;"

# Export table tank_model
mysql -u $USERNAME -p$PASSWORD $DATABASE_NAME -e "SELECT * INTO OUTFILE '$EXPORT_PATH/tank_model$(date +%Y%m%d).csv' FIELDS TERMINATED BY ',' ENCLOSED BY '\"' ESCAPED BY '\"' LINES TERMINATED BY '\r\n' FROM tank_model;"

# Export table storage_tank
mysql -u $USERNAME -p$PASSWORD $DATABASE_NAME -e "SELECT * INTO OUTFILE '$EXPORT_PATH/storage_tank$(date +%Y%m%d).csv' FIELDS TERMINATED BY ',' ENCLOSED BY '\"' ESCAPED BY '\"' LINES TERMINATED BY '\r\n' FROM storage_tank;"

# Export table material_types
mysql -u $USERNAME -p$PASSWORD $DATABASE_NAME -e "SELECT * INTO OUTFILE '$EXPORT_PATH/material_types$(date +%Y%m%d).csv' FIELDS TERMINATED BY ',' ENCLOSED BY '\"' ESCAPED BY '\"' LINES TERMINATED BY '\r\n' FROM material_types;"

# Export table sample
mysql -u $USERNAME -p$PASSWORD $DATABASE_NAME -e "SELECT id, identifier, pos_tank_nr, pos_insert, pos_tube, pos_smpl, responsible_person, type_of_material, IFNULL(commentary, 'N'), storage_date, shipping_date, removal_date INTO OUTFILE '$EXPORT_PATH/sample$(date +%Y%m%d).csv' FIELDS TERMINATED BY ',' ENCLOSED BY '\"' ESCAPED BY '\"' LINES TERMINATED BY '\r\n' FROM sample;"

# Export table shipped_sample
mysql -u $USERNAME -p$PASSWORD $DATABASE_NAME -e "SELECT id, identifier, responsible_person, type_of_material, storage_date, shipping_date, shipped_to, IFNULL(created_at, 'N'), IFNULL(updated_at, 'N') INTO OUTFILE '$EXPORT_PATH/shipped_sample$(date +%Y%m%d).csv' FIELDS TERMINATED BY ',' ENCLOSED BY '\"' ESCAPED BY '\"' LINES TERMINATED BY '\r\n' FROM shipped_sample;"

# Export table removed_sample
mysql -u $USERNAME -p$PASSWORD $DATABASE_NAME -e "SELECT id, identifier, responsible_person, type_of_material, storage_date, removal_date, IFNULL(created_at, 'N'), IFNULL(updated_at, 'N') INTO OUTFILE '$EXPORT_PATH/removed_sample$(date +%Y%m%d).csv' FIELDS TERMINATED BY ',' ENCLOSED BY '\"' ESCAPED BY '\"' LINES TERMINATED BY '\r\n' FROM removed_sample;"

# Export table migrations
mysql -u $USERNAME -p$PASSWORD $DATABASE_NAME -e "SELECT * INTO OUTFILE '$EXPORT_PATH/migrations$(date +%Y%m%d).csv' FIELDS TERMINATED BY ',' ENCLOSED BY '\"' ESCAPED BY '\"' LINES TERMINATED BY '\r\n' FROM migrations;"
