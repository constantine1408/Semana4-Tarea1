# Semana 4, Tarea 1: Biblioteca UNIANDES, gestión de préstamos (Laravel + MySQL)

Sistema web para gestionar los préstamos de una biblioteca, hecho para la asignatura Aplicaciones Web de [Uniandes, Universidad Regional Autónoma de los Andes](https://www.uniandes.edu.ec/). Parte del ejercicio de clase (sistema de biblioteca de la Semana 4) y usa scaffolding de Laravel, con entidades y atributos propios.

> "En base al ejercicio trabajado en clase, tómelo como ejemplo, usted debe generar en la creación de un sistema en donde se contemple en uso de scaffolding. Uno de lo requerimientos es que la base de datos debe tener un máximo de 5 entidades y cada entidad con 5 atributos. Deben tener en cuenta que las entidades deben estar relacionadas entre si."

| Requisito | Cómo se cumple |
| --- | --- |
| Uso de scaffolding | Modelos, migraciones, factories, controladores *resource* y Form Requests con la estructura de `php artisan make:*` |
| Máximo 5 entidades | `autores`, `generos`, `libros`, `socios`, `prestamos` |
| 5 atributos por entidad | `id` + 5 atributos de negocio en cada tabla |
| Entidades relacionadas | 4 claves foráneas con `restrictOnDelete` y relaciones Eloquent en ambos sentidos |

## Modelo de datos

```
 autores 1 ──< N libros N >── 1 generos
                  1
                  │
                  N
 socios  1 ──< N prestamos
```

| Entidad | Atributos (además de `id`) | Relaciones |
| --- | --- | --- |
| `autores` | `nombres`, `nacionalidad`, `fecha_nacimiento`, `correo`, `activo` | 1‑N con `libros` |
| `generos` | `nombre`, `codigo`, `descripcion`, `edad_minima`, `activo` | 1‑N con `libros` |
| `libros` | `titulo`, `isbn`, `paginas`, `autor_id`, `genero_id` | N‑1 con `autores` y `generos`; 1‑N con `prestamos` |
| `socios` | `nombres`, `cedula`, `correo`, `telefono`, `fecha_afiliacion` | 1‑N con `prestamos` |
| `prestamos` | `fecha_prestamo`, `fecha_limite`, `estado`, `socio_id`, `libro_id` | N‑1 con `socios` y `libros` |

Las tablas no tienen `created_at` ni `updated_at`, para no pasar de 5 atributos; por eso los modelos declaran `$timestamps = false`.

### Reglas de validación

- Autor: nombres y nacionalidad son obligatorios, la fecha de nacimiento debe ser anterior a hoy y el correo es opcional pero no se puede repetir.
- Género: el nombre es único y el código tiene 3 letras, también único. Se guarda en mayúsculas, así que `nov` queda como `NOV`. La edad mínima va de 0 a 18.
- Libro: ISBN de 13 dígitos sin repetir, entre 1 y 5000 páginas, y un autor y un género que existan.
- Socio: cédula de 10 dígitos y correo, ambos únicos, y teléfono de 7 a 15 dígitos.
- Préstamo: la fecha límite no puede ser anterior a la del préstamo, el estado es `prestado`, `devuelto` o `vencido`, y el socio y el libro deben existir.

MySQL impide borrar un autor o un género que tenga libros, y un socio o un libro que tenga préstamos. En esos casos la aplicación muestra un mensaje de error en lugar de fallar.

## Interfaz

La portada muestra la estantería: cada libro aparece como un lomo cuyo color es el de su género y cuya altura depende del número de páginas. Al hacer clic en un lomo se abre la ficha del libro. Debajo están los préstamos sin devolver, ordenados por fecha límite y con los días que faltan.

El color de cada género sale de su `id`, así que no hace falta una sexta columna. Ese color se repite en los lomos, en la franja de cada fila de libros y préstamos, y en la etiqueta con el código del género.

La situación de un préstamo se calcula a partir del estado guardado y de la fecha límite. Un préstamo `prestado` cuya fecha ya pasó se muestra como vencido, y uno al que le quedan 3 días o menos aparece como «vence pronto».

Otras funciones:

- búsqueda de libros por título o ISBN, y de socios por nombre o cédula;
- filtro de préstamos por estado, con el número de préstamos en cada uno;
- botones para prestar un libro desde su ficha o desde la ficha del socio, con el formulario ya rellenado;
- mensajes de error junto a cada campo del formulario;
- diseño adaptado a escritorio y celular, con contraste WCAG AA.

La barra lateral usa el verde UNIANDES (`#00794a`). Los títulos de los lomos usan la fuente Archivo Narrow (licencia SIL OFL), que va incluida en `public/fonts/`.

## Comandos de scaffolding

Los archivos de cada entidad siguen la estructura que generan estos comandos de artisan:

```bash
php artisan make:model Autor    -mf     # modelo + migración + factory
php artisan make:model Genero   -mf
php artisan make:model Libro    -mf
php artisan make:model Socio    -mf
php artisan make:model Prestamo -mf

php artisan make:controller AutorController    --resource --model=Autor --requests
php artisan make:controller GeneroController   --resource --model=Genero --requests
php artisan make:controller LibroController    --resource --model=Libro --requests
php artisan make:controller SocioController    --resource --model=Socio --requests
php artisan make:controller PrestamoController --resource --model=Prestamo --requests
```

Sobre esa base se completaron las migraciones (columnas y claves foráneas), los modelos (`$fillable`, `casts()` y relaciones), las reglas de los Form Requests, las vistas Blade y las rutas `Route::resource`.

## Estructura

| Carpeta | Contenido |
| --- | --- |
| `app/Models/` | `Autor`, `Genero`, `Libro`, `Socio` y `Prestamo`, con relaciones `hasMany` y `belongsTo` |
| `database/migrations/` | Las 5 tablas con claves foráneas `restrictOnDelete` |
| `database/factories/` y `database/seeders/` | Datos de ejemplo: 5 autores y 10 libros reales (Huasipungo de Jorge Icaza, Cumandá de Juan León Mera, Pedro Páramo de Juan Rulfo, entre otros), 4 géneros, 6 socios inventados y 8 préstamos, uno de ellos vencido. Los ISBN son de ejemplo. La siembra no duplica datos si se ejecuta otra vez |
| `app/Http/Controllers/` | 5 controladores *resource* (index, create, store, show, edit, update, destroy) y `InicioController` para la portada |
| `app/Http/Requests/` | 10 Form Requests (`Store*` y `Update*`) con las validaciones |
| `resources/views/` | Layout, portada, vistas `index`, `create`, `edit`, `show` y `_form` por entidad, y parciales comunes en `partials/` |
| `public/css/biblioteca.css` | Estilos de toda la interfaz |
| `routes/web.php` | Portada y `Route::resource` de las 5 entidades |
| `tests/Feature/` | Pruebas de estructura, relaciones y CRUD contra MySQL |

## Ejecutar

Se necesita Docker Desktop. No hace falta instalar PHP ni Composer.

```bash
cd semana4-tarea
docker compose up -d --build
```

El primer arranque instala las dependencias, aplica las migraciones, siembra los datos y levanta el servidor. En Windows puede tardar varios minutos.

| Servicio | Dirección |
| --- | --- |
| Aplicación | <http://127.0.0.1:8083> |
| MySQL 8.4 | `127.0.0.1:3309` (base `biblioteca`, usuario `biblioteca`, contraseña `biblioteca_dev`) |

Usa puertos distintos a los del ejemplo de clase (8082 y 3308), así que los dos proyectos pueden correr a la vez.

```bash
docker compose down        # detiene y conserva los datos
docker compose down -v     # detiene y borra la base de datos
```

## Pruebas

```bash
bash tests/run-tests.sh
```

El script crea la base `biblioteca_test` y ejecuta PHPUnit dentro del contenedor. Las pruebas revisan:



1. La estructura: existen exactamente las 5 entidades, cada una con `id` + 5 atributos, y las 4 claves foráneas.
2. Las relaciones: cada una funciona en ambos sentidos y no se pueden borrar registros que tienen dependientes.
3. El CRUD por HTTP: listar, crear, ver, editar y eliminar en las 5 entidades, incluido el rechazo de datos inválidos.

Resultado actual: 24 pruebas y 117 aserciones correctas.

## CAPTURAS

<img width="1935" height="1024" alt="ACTUALIZACION" src="https://github.com/user-attachments/assets/1152347d-2b5a-4c6f-86e1-2be9ffa10127" />
<img width="1921" height="1022" alt="REGISTRO" src="https://github.com/user-attachments/assets/7a104559-6ae1-4c3e-b83b-2ed091b25da9" />
<img width="1922" height="979" alt="LIBRO NUEVO" src="https://github.com/user-attachments/assets/24903ba6-7c46-4b3d-b74e-62a91b1079f5" />

## Uso de inteligencia artificial

En este proyecto usé un asistente de IA (Claude Code, de Anthropic) como apoyo. Los commits en los que intervino llevan la línea `Co-Authored-By: Claude`.

Trabajo propio (Edwin Sanchez): definí los requisitos a partir del enunciado y del ejercicio de clase, elegí mantener el dominio de biblioteca y aprobé las cinco entidades con sus atributos. También probé el sistema en el navegador, tomé las capturas de esta página, corregí el nombre de la universidad y revisé el resultado antes de entregarlo.

Con ayuda de IA:

- Adaptación del ejercicio de clase: a partir del proyecto de la Semana 4, la IA escribió los modelos, las migraciones, las factories, el seeder, los controladores, los Form Requests, las rutas y las 24 pruebas para las entidades autores, géneros, libros, socios y préstamos.
- Diseño de la interfaz: el rediseño visual con estilo de tela de encuadernación de biblioteca (`public/css/biblioteca.css`, las vistas de `resources/views/`, los parciales de `resources/views/partials/`, el controlador `InicioController` de la portada, los métodos `tela()` de `Genero` y `situacion()` de `Prestamo`, y la fuente de `public/fonts/`). Se hizo con la skill Impeccable, que también generó `PRODUCT.md`, `DESIGN.md` y la carpeta `.impeccable/`; esos archivos de trabajo no se subieron al repositorio. La dirección visual la elegí yo entre varias propuestas.
- Imágenes y bocetos: los bocetos de diseño (archivos HTML) los generó la IA y no se usan en la aplicación. Las capturas de esta página son mías.
- Redacción: la IA redactó este README y lo revisé con la skill Humanizer.

