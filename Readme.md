# Chargeports App

### Running application locally
`docker-compose up -d`

This command will start the docker containers. And you can access the application on http://localhost:80

### Running commands 

`docker exec -it chargeports_app bash`

This will start a shell session into the php container where you can do composer related commands. And access the php bin/console commands from symfony
