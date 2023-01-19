
# Como debemos estructurar la base de datos para la API RestFull

### 1. Las tablas deben estar escritas en plural y el nombre de las columnas deben terminar con el nombre de la tabla en singular (_sufijo)*.
Tabla: **Categories**

**Columnas:**
* id_**category**
* name_**category**
* date_created_**category**
* date_updated_**category**

- Recomendación: Usar idioma Inglés para acortar palabras y unir palabras con guión de piso.

 --------------------------------------

### 2. La primera columna debe ser el ID (auto incrementable) y las dos últimas columnas deben ser la fecha de creación y la fecha de actualización.
Tabla: **Categories**

**Columnas:**
* id_**category**
... Se agregan las columnas necesarias ...
* date_created_**category**
* date_updated_**category**

--------------------------------------

### 3. Para relacionar tablas , el número del ID de la Tabla Relacionada debe estar en una columna de la Tabla Principal, y dicha columna debe tener el siguiente orden de palabras id_(Tabla Relacionada en singular)_(Tabla Principal en Singular)

- Tabla Principal: **products**
- Tabla Relacioanda: **categories**   | Columna: id_category_**products**
- Tabla Relacionada: **stores**       | Columna: id_store_**products**

--------------------------------------

### 4. Para realizar autenticaciones con la API RESTFull, es indispensable que la tabla de autenticacón tenga siempre estas 4 columnas.

- email_**sufijo**
- pasword_**sufijo**
- token_**sufijo**
- token_exp_**sufijo**

--------------------------------------

## Estructura de la API RESTFULL
Para mantener las buenas prácticas debemos trabajar con la estructura **Modelo Vista Controlador** y hacer peticiones a la base de datos a travéz de métodos HTTP:
- GET
- POST
- PUT 
- DELETE

Estructura de carpetas:
- Rutas (**routes**)
- Controladores (**controllers**)
- Modelos (**models**)
- Base de datos (**database**)

--------------------------------------

### Configurar archivo .htaccess
El archivo .htaccess (HyperText Access o acceso de hipertexto) es un archivo de configuración del software de servidor Apache, que contiene las directivas que definen el comportamiento de Apache. El archivo.htaccess indica en todo momento qué puede hacer y qué no el usuario que visita tu web, así como configurar el comportamiento del servidor ante errores de conexión u optimizar la carga de las páginas

Es un archivo que se usa para los proyectos que usan servidores apache
Estructura del archivo .htaccess:
```
Options All -Indexes
Options -MultiViews

RewriteEngine On

RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^ index.php [QSA,L]
```