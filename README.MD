# Prueba CRUD Symfony

### Instalación

Despues de clonado el repositorio, copiar el archivo .env y renombrar esta a .env.local y reemplazar la variable DATABASE_URL con los datos de acceso correspondientes.
```
DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7
```
Ejecutar los siguientes comandos

```sh
$ composer install
$ php bin/console doctrine:database:create
$ php bin/console doctrine:migrations:migrate 
```


### Ejecutar

Para correr, ejecutar el siguiente comando

```sh
php bin/console server:run
```

Verificar el funcionamiento en 

```sh
127.0.0.1:8000
```


### "toDOS:"

 - Notificaciones flash al usuario cuando una acción es exitosa o falla.
 - Test unitarios validaciones de las entidades.
 - Usar webpack para manejo y compilación de assets.



