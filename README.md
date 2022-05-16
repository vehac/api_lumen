# Lumen (8.3.4)
Docker - Lumen (PHP 7.4) - Swagger - MariaDB

## Inicio
- Si no existe, crear la carpeta `storage/logs` y darle permisos de lectura y escritura.
- Por consola ir a la carpeta `public` y crear la carpeta `upload` y darle permisos de lectura y escritura, se puede usar los siguientes comandos:
```bash
mkdir upload
sudo chmod 775 -R upload
sudo chown www-data:www-data upload
```
- Sacar una copia del archivo `.env.example` como `.env` en la raíz (/) de la aplicación.
- En la ruta `docker/php` se encuentra el archivo `init.sh` donde se asigna permisos a las carpetas `logs` y `upload` cuando se levante el contendor.
- Luego de iniciar el contenedor con php, ingresar al contenedor y ejecutar los migrations con el siguiente comando:
```bash
php artisan migrate
```

## Docker
- Para la primera vez que se levanta el proyecto con docker o se cambie los archivos de docker ejecutar:
```bash
sudo docker-compose up --build -d
```
- En las siguientes oportunidades ejecutar:

Para levantar:
```bash
sudo docker-compose start
```
Para detener:
```bash
sudo docker-compose stop
```
- Para ingresar al contenedor con php ejecutar:
```bash
sudo docker-compose exec webserver bash
```
- Instalar las dependencias con composer, para ello, dentro del contenedor con php ejecutar:
```bash
composer install
```
- Para ver el proyecto desde un navegador:

Sin virtualhost:
```bash
http://localhost:8482
```
Con virtualhost:

Si se usa Linux, agregar en /etc/hosts de la pc host la siguiente linea:
```bash
12.23.22.19    local.apilumen.com
```
## MariaDB
- Para loguearse al contenedor con MariaDB:
```bash
mysql -u root -p -h 12.23.22.18
3*DB6lumen9
```
- En el caso no se desee ejecutar el migration desde lumen, luego de loguearse al contenedor con MariaDB, se puede importar el script `my_db.sql` con SOURCE <ruta_de_my_db.sql>, ejemplo:
```bash
SOURCE /var/www/html/api_lumen/docker/my_db.sql
```
## [Swagger](https://swagger.io/tools/swagger-ui) - [github swagger-ui](https://github.com/swagger-api/swagger-ui) - [github swagger-php](https://github.com/zircote/swagger-php)
- Se generó documentación para el api con swagger, para poder verla, ingresar a la siguiente url:
```bash
http://localhost:8482/api/v1/doc
```
## Endpoints
```bash
POST    /api/v1/generate-token
POST    /api/v1/verify-token
GET     /api/v1/clients
GET     /api/v1/clients/{clientId}
POST    /api/v1/clients
POST    /api/v1/clients/{clientId}
DELETE  /api/v1/clients/{clientId}
```