#PJ1 Gaming Center

**Proyecto:** Desarrollo de una aplicación web para la gestión de un Gaming Center.  
**Grupo:** [Grupo X]  
**Curso:** DAW2 
**Módulo:** 0616 proyecto intermodular

---

## 1. Descripción del proyecto

Este proyecto consiste en desarrollar una aplicación web para gestionar los recursos de un local Gaming Center.

La aplicación permite al personal del establecimiento (gamemasters) consultar las salas y sus módulos, controlar su disponibilidad, registrar ocupaciones y liberaciones, y consultar un histórico de utilización.

El objetivo es disponer de una herramienta que permita gestionar los recursos del local de forma sencilla y eficiente.

## 2. Tecnologías utilizadas

- **Frontend:** HTML5, CSS3 y JavaScript.
- **Backend:** PHP.
- **Base de datos:** MySQL.
- **Acceso a datos:** PDO.
- **Control de versiones:** Git y GitHub.

## 3. Funcionalidades de la aplicación

La aplicación dispone de las siguientes funcionalidades:

- Inicio de sesión y cierre de sesión de gamemasters.
- Visualización de las salas del establecimiento.
- Visualización de los módulos de cada sala.
- Consulta del estado de los módulos (libre u ocupado).
- Ocupación de módulos según su capacidad.
- Liberación de módulos por parte del gamemaster responsable.
- Consulta del histórico de ocupaciones.
- Filtrado del histórico por sala y módulo.

## 4. Requisitos e instalación

### 4.1 Requisitos previos

Para ejecutar el proyecto se necesita:

- PHP.
- MySQL.
- Apache o servidor web equivalente.
- Navegador web actualizado.

### 4.2 Instalación

1. Clonar el repositorio:

   ```bash
   git clone [https://github.com/ivan-grandee/Grup1_DAW2_PJ5_A01_GamingCenter.git]
   ```

2. Copiar el proyecto en el directorio del servidor web.

3. Crear la base de datos e importar el archivo:

   `sql/db_pj1_gamingCenter.sql`

4. Configurar los datos de conexión a MySQL en el archivo [conf/conexion.php].

5. Iniciar Apache y MySQL.

6. Acceder desde el navegador:

   `http://localhost/[Grup1_DAW2_PJ5_A01_GamingCenter]/`

## 5. Base de datos

La base de datos utilizada se llama **[nombre de la base de datos]**.

### Tablas principales

| Tabla | Descripción |
|---|---|
| gamemasters | Usuarios que gestionan el establecimiento. |
| sales | Salas disponibles en el Gaming Center. |
| moduls | Módulos de juego pertenecientes a cada sala. |
| ocupacions | Registro de las ocupaciones y liberaciones. |

### Datos de prueba

El proyecto incluye datos de prueba para comprobar el funcionamiento de la aplicación:

- [3] gamemasters.
- [9] salas.
- [37] módulos.
- [4] ocupaciones históricas.

El archivo SQL completo se encuentra en `sql/db_pj1_gamingCenter.sql`.

## 6. Usuarios de prueba

Para acceder a la aplicación se pueden utilizar los siguientes usuarios:

| Usuario | Contraseña | Observaciones |
|---|---|---|
| [gm.alba] | [qweQWE123] | [Game Master] |
| [gm.marcos] | [qweQWE123] | [Game Master] |

*Estas credenciales son únicamente para realizar pruebas del proyecto.*

