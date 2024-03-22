## Instalação

1. depois de clonar o projeto, executar o seguinte passo em seu terminal abaixo
```shell
cp ./env.example ./.env
```
2. Após adicionar a chave de api do open weather no .env
```shell
OPEN_WEATHER_API_KEY=
```
3.Depois subir os containers do docker, existe um script que executa todos os comandos para subir a aplicação
```shell
docker-compose up --build
```
4. O comando abaixo serve para requisitar e salvar algumas cidades no banco de dados
```shell
docker-compose exec app php artisan app:get-weathers
```
a aplicação sera aberta na no navegador http://localhost:8000 e na API http://localhost:8000/api
