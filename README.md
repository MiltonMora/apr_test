# APR test

#### Antes de crear asegurese que todas las referecnias, a los nombres de contenendores red y demas comfiguracion de docker en el **docker-compose.yml** y Makefile correspondan a los nombres que se desee poner a las aplicaciones 

### Proceso para crear un proyecto en symfony con docker php > 8 doctrine

1. Contenedores Docker
   - Construir el contenedor Docker
    ```bash
    make build
    ```
   
   - iniciar los contenedores Docker:
    ```bash
    make start
    ```

2. Cree el archivo .env en el directorio raiz

3. instale las dependencias con el comando
    ```bash
    make prepare
    ```
    o  ingresando al contenedor con el comando
    ```bash
    make ssh-be
    ```
    y ejecutando 
    ```bash
    composer-install
    ```

4. Iniciar los servicios del contenedor en un servidor de symfony:

    se puede hacer desde dentro del contenedor, pero tambien se puede realizar desde fuera con ayuda del comando
    ```bash
    make run
    ```

5. Posteriormente se procede a probar si se ha ejecutado correctamente hiendo a la ruta ***http://localhost:1000/***

6. Cambiamos la configuracion del ***.env*** para que haga la conexion con la BD

    La informacion de usuario contraseña y base de datos se encunentra en el archivo
    **docker-compose.yml** en dodne se definio el contenedor de mysql, la direccion a la  que debe apuntar no es local host dado que se estan ejecutando en la misma red
    ```yml
    container_name: symfony_skeleton-postgres
    POSTGRES_USER: user
    POSTGRES_PASSWORD: passwd
    POSTGRES_DB: symfony_skeleton
    ```
    
    ```bash
    DATABASE_URL="postgresql://user:passwd@symfony_skeleton-postgres:5432/symfony_skeleton?serverVersion=16&charset=utf8"
    ```

7. Se reinician los conntenedores para verificar la conexion y se crea la BD
    ```bash
    make restart
    ```

8. Autenticacion de usuario con jwt

    - verificar que en el .env se creen las variables de entorno necesarias para jwt
    ``` .dotenv
    JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem
    JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem
    JWT_PASSPHRASE=*************************
    ```

    - Generar las claves publicas y privadas con el comando
    ``` sf lexik:jwt:generate-keypair ```
    y verificar que se creen las llaves publica y privada en la correspondiente carpeta

### estructura de carpetas para que funcione la inyeccion de dependencias
```
    src
       User
          |---Application
          |    |---Command
          |    |   |---AlgoCommand.php
          |    |---AlgoHandler.php
          |---Command
          |    |---EjecutaAlgoCommand.php
          |---Controller
          |    |---RutaController.php
          |---Service
          |    |---AlgunService.php
          |    |---AlgunClient.php
          |---Repository
          |    |---AlgunRepository.php
          |---...
```
