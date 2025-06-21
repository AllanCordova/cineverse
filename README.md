# movie-catalog

# Para rodar esse sistema: 
certifique se de ter instalado docker e docker compose em sua maquina.


## clone o repositorio do git.
git clone https://github.com/AllanCordova/cineverse.git

## na raiz do projeto rode 
docker rm -f mysql-db php-apache || true 
para remover casa exista container com esse nome já, cuidado pode remover algum container que você criou em sua maquina
docker compose up -d

docker-compose up -d

## confira o funcionamento dos container
docker ps

## teste a aplicação
http://ipdesuamaquinaouvm:8080

pronto você tera acesso a aplicação virtualmente <3.
