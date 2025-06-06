
Go to folder
#### cd Pizza

Renaming .env  
#### make env

Start application:
#### make up
(or  
chmod 644 ./docker/volume/init.sql  
docker compose up -d  
)

After 3-5 minutes. Migrating both DBs and seeding them.
#### make db

Testing (after previous about 3 min)
#### make test
