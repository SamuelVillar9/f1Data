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