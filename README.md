F1DATA

F1Data es una aplicación web construida con Symfony diseñada para gestionar y visualizar datos estadísticos sobre las distintas temporadas de la Fórmula 1. La aplicación proporciona acceso público a información sobre escuderías, pilotos y circuitos, y un área de administración protegida para gestionar estos datos a través de un sistema de usuarios registrados y autenticados.

CARACTERÍSTICAS
- Interfaz pública: Muestra información sobre escuderías, pilotos y circuitos de la Fórmula 1 almacenada en la base de datos de la aplicación.

- Área de administración: Usando el bundle EasyAdminBundle (https://github.com/EasyCorp/EasyAdminBundle), la aplicación permite a los usuarios registrados y autenticados gestionar temporadas, escuderías, pilotos y circuitos.

- Gestión de temporadas: Los usuarios administradores pueden agregar temporadas de Fórmula 1, junto con los detalles correspondientes de escuderías, pilotos y circuitos.

- (EN DESARROLLO) Calendario de la temporada: La aplicación está diseñada para registrar y mostrar el calendario de cada temporada, incluidas las fechas de cada sesión (entrenamientos, clasificaciones, carreras al sprint, carreras, etc.).

- (EN DESARROLLO) Visualización de estadísticas: A medida que la aplicación crece, se integrarán más funcionalidades para mostrar estadísticas detalladas, como la puntuación por prueba, vueltas rápidas, posiciones finales, etc.

INSTALACIÓN
Requisitos previos:
- PHP: Asegúrate de tener PHP instalado en tu máquina. Se recomienda PHP 8.0 o superior.

- Composer: Necesitarás Composer para gestionar las dependencias del proyecto. Si no tienes Composer, puedes instalarlo desde aquí: https://getcomposer.org/

Pasos para instalar:
    1. Clonar el repositorio: Clona el proyecto desde GitHub usando el siguiente comando:

        git clone https://github.com/SamuelVillar9/f1data.git
        cd f1data

    2. Instalar las dependencias: Ejecuta el siguiente comando para instalar todas las dependencias de Symfony y el proyecto:

        composer install

    3. Configurar las variables de entorno: Asegúrate de tener un archivo .env.local en la raíz del proyecto. Si no lo tienes, copia el archivo .env y personaliza las variables de entorno, especialmente la configuración de la base de datos:

        cp .env .env.local

    Edita el archivo .env.local para establecer los valores correctos para la base de datos y otras configuraciones.

    4.Crear la base de datos: Ejecuta el siguiente comando para crear la base de datos:

        php bin/console doctrine:database:create

    5.Aplicar las migraciones: Si tienes migraciones de base de datos, aplícalas usando:

        php bin/console doctrine:migrations:migrate

    6. Iniciar el servidor de desarrollo: Una vez que todo esté configurado, puedes iniciar el servidor de desarrollo de Symfony con el siguiente comando:

        symfony server:start

        O, si no tienes el comando symfony disponible, puedes usar el servidor PHP:

        php -S 127.0.0.1:8000 -t public/
        Esto iniciará la aplicación y podrás acceder a ella desde tu navegador en http://127.0.0.1:8000.

COMANDO 'app:create-user'

- Descripción
    El comando app:create-user permite crear un usuario en la base de datos con una contraseña en texto claro que se hashiza antes de ser almacenada. Este comando se utiliza para generar un nuevo usuario con un correo electrónico y una contraseña segura (hasheada).

- Estructura y Funcionalidad
    Este comando está diseñado para ser ejecutado desde la línea de comandos en un entorno Symfony, y hace uso de los servicios de Symfony como el UserPasswordHasherInterface para manejar el hash de la contraseña y EntityManagerInterface para persistir el usuario en la base de datos.

- Flujo de ejecución
    1. Inyección de dependencias:

        - UserPasswordHasherInterface: Este servicio es utilizado para generar una versión segura (hasheada) de la contraseña proporcionada.
        - EntityManagerInterface: Se utiliza para manejar las operaciones de persistencia de datos en la base de datos (guardar el usuario creado).

    2. Configuración del comando: El comando se configura con:

        - Un nombre app:create-user, que será usado al ejecutar el comando en la terminal.
        - Una descripción que explica lo que hace el comando: "Crea un usuario con contraseña hasheada".

    3. Ejecución del comando:

        - Los datos del nuevo usuario se definen manualmente dentro del método execute(). En este caso, el email es 'usuario_prueba' y la contraseña es '00000000'.
        - Se crea una nueva instancia de la clase User, se asigna el correo electrónico y los roles (en este caso, el rol 'ROLE_USER').
        - La contraseña en texto claro se hashiza usando el UserPasswordHasherInterface.
        - El usuario con la contraseña hasheada se persiste en la base de datos utilizando el EntityManagerInterface.
        - Finalmente, el comando muestra un mensaje de éxito en la consola: "Usuario creado exitosamente."

- Ejecución del comando
    Una vez que hayas configurado todo correctamente, puedes ejecutar el comando en la terminal para crear un nuevo usuario con una contraseña hasheada:

        php bin/console app:create-user
    
    Esto creará el usuario con el email 'usuario_prueba' y la contraseña '00000000', hasheada antes de ser almacenada en la base de datos.

- Notas importantes
    Este comando está diseñado para ser utilizado principalmente en un entorno de desarrollo o prueba. No se recomienda utilizarlo en producción sin la validación y personalización adecuadas.
    La contraseña '00000000' y el correo 'usuario_prueba' se definen de manera estática en el código, pero podrían ser modificados para aceptar entradas dinámicas a través de la consola si se desea.

ESTRUCTURA DE LA APLICACIÓN
- Front-end (Interfaz pública): La interfaz pública de la aplicación es simple, con un navbar que proporciona enlaces a las siguientes secciones:
    Escuderías
    Pilotos
    Circuitos
    
    Cada una de estas secciones muestra los datos almacenados en la base de datos relacionados con las escuderías, pilotos y circuitos.

- Back-end (Administración): El panel de administración está gestionado a través de EasyAdminBundle y está protegido por un sistema de autenticación. Solo los usuarios registrados pueden acceder a este área y realizar las siguientes acciones:

    Agregar nuevas temporadas de F1
    Registrar escuderías por temporada
    Asignar pilotos a las escuderías
    Registrar circuitos
    Futuras funcionalidades: A medida que la aplicación evoluciona, se agregará más funcionalidad, como la gestión del calendario de cada temporada y la visualización de estadísticas avanzadas de las carreras.

CONTRIBUCIONES
Si deseas contribuir a este proyecto, por favor sigue estos pasos:

    Haz un fork del proyecto.
    Crea una nueva rama para tus cambios (git checkout -b feature/nueva-funcionalidad).
    Realiza tus cambios y haz commit de ellos (git commit -am 'Añadir nueva funcionalidad').
    Envía tus cambios al repositorio original a través de un pull request.

LICENCIA
Este proyecto está bajo la Licencia MIT.

CONTACTO
Si tienes preguntas o sugerencias, no dudes en contactarme a través de mi perfil de GitHub: Samuelvillar9 o a través de mi correo electrónico samuelvillar9@gmail.com.