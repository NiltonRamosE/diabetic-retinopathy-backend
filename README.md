<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>


# Conexión de Laravel con SQL Server

## 1. Crear un usuario en SQL Server

1. Abre SQL Server Management Studio.
2. Dirígete a `Security > Login`.
3. Haz clic derecho en `Login` y selecciona `New Login`.
4. En `Login name` coloca el nombre de usuario deseado.
5. Establece una contraseña para el usuario.
6. Asegúrate de que el tipo de autenticación sea `SQL Server Authentication`.
7. Haz clic en `OK` para crear el usuario.

## 2. Acceder como SQL Server Authentication

Usa el nombre de usuario y contraseña que acabas de crear para iniciar sesión en SQL Server con el modo de autenticación de SQL Server.

## 3. Crear la base de datos en SQL Server

1. Crea una nueva base de datos llamada `RetinopatiaDB` en SQL Server.

## 4. Instalación de las extensiones PDO para SQL Server

Para conectar Laravel con SQL Server, debes instalar las extensiones de PDO para SQL Server. Puedes obtenerlas desde el siguiente enlace:

[Instalar controladores PDO para SQL Server](https://learn.microsoft.com/en-us/sql/connect/php/download-drivers-php-sql-server?view=sql-server-ver16)

### Extensiones necesarias:

- **php_pdo_sqlsrv_83_ts_x64.dll** (si estás usando PHP 8.3)
- **php_sqlsrv_83_ts_x64.dll** (si estás usando PHP 8.3)

### Pasos para la instalación:

1. Descarga las extensiones correspondientes a tu versión de PHP desde el enlace anterior.
2. Coloca los archivos `.dll` descargados en la carpeta `C:\laragon\bin\php\php-8.3.10-Win32-vs16-x64\ext` o en la ubicación donde se encuentren las extensiones de tu PHP.

## 5. Configurar PHP para habilitar las extensiones

1. Abre el archivo `php.ini` de tu instalación de PHP (usualmente se encuentra en `C:\laragon\bin\php\php-8.3.10-Win32-vs16-x64`).
2. Agrega las siguientes líneas al archivo `php.ini`:

```ini
extension=php_pdo_sqlsrv_83_ts_x64.dll
extension=php_sqlsrv_83_ts_x64.dll
```

3. Guarda los cambios y reinicia el servidor de Laravel (o el servidor web que estés utilizando) para que las extensiones se carguen correctamente.

## 6. Configuración en el archivo `.env` de Laravel

Abre el archivo `.env` en la raíz de tu proyecto Laravel y configura los siguientes parámetros:

```env
DB_CONNECTION=sqlsrv
DB_HOST=127.0.0.1
DB_PORT=1433
DB_DATABASE=RetinopatiaDB
DB_USERNAME=dba
DB_PASSWORD=sql
```

Asegúrate de reemplazar `dba` y `sql` con el nombre de usuario y la contraseña que hayas configurado en SQL Server.

## 7. Verificación de la conexión a la base de datos

1. Ejecuta el siguiente comando en la terminal para verificar si la conexión a la base de datos se ha establecido correctamente:

```bash
php artisan migrate
```

Este comando intentará realizar las migraciones de la base de datos y, si no hay errores, confirmará que la conexión está funcionando correctamente.

## 8. Solución de problemas: Habilitar TCP/IP para SQL Server

Si experimentas problemas de conexión, puede ser que el puerto TCP no esté habilitado en tu instalación de SQL Server. Sigue estos pasos para habilitarlo:

### Habilitar TCP/IP en SQL Server:

1. Presiona `Windows + R` y ejecuta el comando correspondiente según tu versión de SQL Server:
   - **SQL Server 2022**: `SQLServerManager16.msc`
   - **SQL Server 2017**: `SQLServerManager14.msc`
   - **SQL Server 2014**: `SQLServerManager12.msc`

2. En la ventana de **SQL Server Configuration Manager**, ve a `SQL Server Network Configuration > Protocols for <NOMBRE DE TU SQL>`.
3. Habilita `TCP/IP` y luego haz clic en propiedades.
4. En la sección `IP Addresses`, bajo `IPAll`, establece el **TCP Port** en `1433`.
5. Asegúrate de que `SQL Server Browser` esté habilitado en **SQL Server Services**.
6. Cambia el **Start Mode** de `SQL Server Browser` a `Automatic` y haz clic en `Start` para iniciar el servicio.

### Crear una regla de firewall para permitir el puerto 1433:

1. Abre `Firewall de Windows Defender` y selecciona `Configuración avanzada`.
2. En `Reglas de entrada`, crea una nueva regla:
   - Tipo de regla: **Puerto**
   - Protocolo y puertos: **TCP**, Puertos locales específicos: `1433`
   - Acción: **Permitir la conexión**
   - Perfil: Marca todas las opciones (Dominio, Privado, Público)
   - Nombre: `[W11 EPV] SQL TCP 1433`

Con estos pasos, deberías poder habilitar correctamente el puerto 1433 para la conexión de SQL Server.

## Recursos adicionales

- [Documentación de SQL Server para PHP](https://learn.microsoft.com/en-us/sql/connect/php/?view=sql-server-ver16)
- [Video tutorial sobre habilitar TCP/IP para SQL Server](https://www.youtube.com/watch?v=wVNPjDeZOhA)

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
