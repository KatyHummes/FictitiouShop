
### Technical information:

- Backend:
Neste projeto foram utilizados php, Laravel e Inertia para desenvolvimento Backend
e para o banco de dados usei MySQL.

- Front-end:
Desenvolvi uma interface simples usando Vue.js, Tailwind CSS
e também primevue para os componentes.

# Como usar:
- A versão do PHP utilizada no Projeto é PHP 8.2.11
- A versão do Laravel utilizada é a 11.10.0
- clique no botão verde acima (<> código) e copie o link: https://github.com/KatyHummes/Protocols.git
- configure o banco de dados com .env
- Copie o arquivo **.env.example** para **.env**(crie a .env) e configure as variáveis de ambiente relacionadas ao banco de dados

- execute os comandos:
```
composer install
```
```
npm install
```
```
php artisan key:generate
```
- abra o servidor:
```
php artisan serve
```
- deixe o npm em execução:
```
npm run dev
```
- execute as migrações:
```
php artisan migrate 
```
e finalmente execute este comando:
```
php artisan storage:link
```
- access the URL: http://127.0.0.1:8000/

## Links das Bibliotecas e outros usados no Projeto:

https://jetstream.laravel.com/ para a autenticação e configurações iniciais,
https://primevue.org/ para alguns componentes e estruturas do front-end, https://undraw.co/illustrations para os svgs
https://pinia.vuejs.org/getting-started.html para gerenciamento de estado entre componentes/páginas
