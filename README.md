# Gaming Center

Aplicación web en PHP + MySQL para gestionar la ocupación de los módulos de un gaming center. Los *gamemasters* inician sesión, ven las salas con sus módulos, ocupan o liberan módulos y consultan el histórico de ocupaciones con filtros.

## Funcionalidades

- **Login / logout** de gamemasters (contraseñas con `password_hash` / `password_verify`, sesiones PHP).
- **Salas y módulos** (`vistas/salas.php`): estado de cada módulo (Libre / Ocupado por X con nº de jugadores) y resumen por sala.
- **Ocupar módulo**: indica el nº de jugadores (entre 1 y la capacidad del módulo). Solo si el módulo está libre.
- **Liberar módulo**: solo puede liberarlo el gamemaster que lo ocupó.
- **Histórico** (`vistas/historico.php`): todas las ocupaciones (en curso y finalizadas) con filtros por sala, módulo y gamemaster.
- **Validación** en cliente (JavaScript) y en servidor (PHP), consultas con PDO y sentencias preparadas, salida escapada con `htmlspecialchars`.

## Requisitos

- PHP 8 o superior con la extensión PDO MySQL
- MySQL / MariaDB
- Servidor web (probado con WampServer)

## Instalación

1. Copia la carpeta del proyecto en el directorio del servidor, por ejemplo `C:\wamp64\www\DAWN2\gaming_center`.
2. Importa `db_pj5_gamingCenter.sql` en phpMyAdmin (o con `mysql < db_pj5_gamingCenter.sql`). Crea la base de datos `gaming_center_app` con sus tablas y datos de ejemplo.
3. Revisa `config/conexion.php` y ajusta servidor, usuario y contraseña si es necesario (por defecto `localhost:3306`, `root`, sin contraseña).
4. Abre `http://localhost/DAWN2/gaming_center/` en el navegador.

### Usuarios de prueba

Usuarios: `gm.alba`, `gm.marcos`, `gm.sara`. Las contraseñas están guardadas como hash en el SQL. Si no las conoces, genera un hash nuevo para una contraseña de prueba:

```php
<?php echo password_hash('1234', PASSWORD_DEFAULT);
```

y actualízalo en phpMyAdmin:

```sql
UPDATE gamemasters SET password = '<hash generado>' WHERE username = 'gm.alba';
```

## Estructura del proyecto

```
gaming_center/
├── index.php                  # Redirige a salas (con sesión) o a login
├── db_pj5_gamingCenter.sql    # Base de datos y datos de ejemplo
├── config/conexion.php        # Conexión PDO
├── includes/
│   ├── proteger.php           # Exige sesión iniciada
│   └── funciones.php          # escapar() (htmlspecialchars)
├── validaciones/              # Validaciones de servidor
│   ├── validar_login.php
│   ├── validar_ocupacion.php
│   └── validar_filtros.php
├── procesos/                  # Acciones (POST) con redirección
│   ├── login.php
│   ├── logout.php
│   ├── ocupar.php
│   └── liberar.php
├── vistas/                    # Páginas que ve el usuario
│   ├── login.php
│   ├── salas.php
│   └── historico.php
├── css/estilos.css
└── js/                        # Validaciones de cliente
    ├── validar_login.js
    └── validar_ocupacion.js
```

## Base de datos (`gaming_center_app`)

| Tabla | Campos principales |
|---|---|
| `gamemasters` | `id`, `username`, `password`, `nom`, `cognom` |
| `sales` | `id`, `nom`, `tipus` (PC Standard, Simuladors/Consoles, VIP) |
| `moduls` | `id`, `sala_id`, `nom`, `tipus`, `capacitat` |
| `ocupacions` | `id`, `modul_id`, `gamemaster_id`, `num_jugadors`, `data_inici`, `data_fi` |

Una ocupación está **activa** mientras `data_fi` es `NULL`; al liberar el módulo se guarda `NOW()` en `data_fi`.

## Flujo de la aplicación

- Los procesos reciben el formulario por POST, validan, ejecutan la consulta y redirigen a la vista con un parámetro: `?ok=ocupado|liberado` o `?error=...` (`ocupado`, `permiso`, `datos`, `modulo`, `ocupacion`; en login `campos`, `credenciales`).
- Las vistas leen ese parámetro y muestran el mensaje correspondiente.
- Las páginas protegidas incluyen `includes/proteger.php`, que redirige al login si no hay sesión.
