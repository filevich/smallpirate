# SmallPirate

Se acuerdan de SmallPirate? El original, el del 2009? (que posteriormente sería renombrado a "Spirate"); bueno, me vino nostalgia y decidí dockerizarlo.

![Screenshot from 2023-10-28 20-31-23](https://i.imgur.com/8Rxryng.png)

## Instalación

### De forma automática usando `docker-compose`

Basicamente basta con correr `docker-compose up -d` y luego acceder a [http://localhost:8000/install.php](http://localhost:8000/install.php) para completar la instalación.

### De forma manual usando `docker`

1. Crear una network con `docker network create smallpirate-net`
2. Levantar un container de MySQL-**4** con `docker run --network smallpirate-net --network-alias mysql-smallpirate --rm --name mysql-smallpirate -p 33060:3306 -e MYSQL_ROOT_PASSWORD=root tommi2day/mysql4`
3. Opcional: Crear un usuario MySQL diferente de `root` y una DB diferente de `test` mediante `docker exec -it mysql-smallpirate bash`, `mysql -u root -p` & `CREATE DATABASE smallpirate CHARACTER SET utf8 COLLATE utf8_general_ci;`
4. Opcional: Bindear un directorio para persistir la DB agregando la flag `-v ${PWD}/db/v2:/db` al comando de (2)
5. Levantar el webserver con `docker run -v ./v2/:/home/ftper/html -p 8000:80 -p 2100:21 --network smallpirate-net --name smallpirate filevich/smallpirate:2.0`
6. Acceder a [http://localhost:8000/install.php](http://localhost:8000/install.php) para completar la instalación.

### Completar la instalación del script PHP

Para completar la instalación basta con rellenar los siguiente campos como se muestra a continuación:

```
Servidor: localhost
Nombre de usuario: ftper
Contraseña: ftper
Ruta de instalación: /html
```

![Screenshot from 2023-10-28 20-13-59](https://i.imgur.com/l67Yne4.png)

```
Servidor MySQL: mysql-smallpirate
Usuario MySQL: root
Password MySQL: root
Base de datos: test
```

(notar que difiere de la imagen de ejemplo el nombre de la DB; pueden crear una diferente como lo expliqué en el paso (3))

![Screenshot from 2023-10-28 20-14-27](https://i.imgur.com/jumfUJw.png)

## Notas

- Esta versión del script (la del 2009) es compatible solo con MySQL v4
 
- Quedan accesibles los puertos HTTP (`80` en el `8000`) y FTP (`21` en el `2100`); la DB quedó en el `33060`

- Para FTP pueden usar cualquier cliente (e.g., FileZilla) bajo el usuario `ftper@localhost`, contraseña `ftper` y puerto `2100`

- Disclaimer: el script es el original del 2009; está intacto (y todo bugueado).

- La imagen quedó disponible en [https://hub.docker.com/repository/docker/filevich/smallpirate/general](https://hub.docker.com/repository/docker/filevich/smallpirate/general)

## Capturas

![Screenshot from 2023-10-28 20-32-29](https://i.imgur.com/Ji9e99B.png)

![Screenshot from 2023-10-28 20-32-07](https://i.imgur.com/UDdBbSz.png)
