
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

