# APR test


### Instriccuones: 

1. Contenedores Docker
   - Construir el contenedor Docker
    ```bash
    make build
    ```
   
   - iniciar los contenedores Docker:
    ```bash
    make start
    ```

2. Cree el archivo .env en el directorio raiz y copie en el la instruccion para conectarse a la BD que se encuentra en el archivo .env.test

3. instale las dependencias con el comando
    ```bash
    make prepare
    ```

4. Iniciar los servicios del contenedor en un servidor de symfony:

    se puede hacer desde dentro del contenedor, pero tambien se puede realizar desde fuera con ayuda del comando
    ```bash
    make run
    ```
   
5. Ingrese al contenedor de Symfony 
   ```bash
    make run
    ```
   Y ejecute la Migracion inicial, esto crear las tablas y los usuarios para poder interactuar.
   ```bash
   sf doctrine:m:execute DoctrineMigrations\\Version20250301220538
   ```

6. Posteriormente se procede a probar si se ha ejecutado correctamente hiendo a la ruta ***http://localhost:1000/***

### estructura de carpetas para que funcione la inyeccion de dependencias
```
    src
       Event
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
