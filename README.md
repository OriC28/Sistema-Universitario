# Sistema Universitario
Proyecto de lenguaje de programación III (ayúdennos)
## El Sistema
El sistema ha sido creado empleando el patrón **MVC (Model-View-Controller)** para una organización más clara del proyecto y una mejor distribución de las responsabilidades entre el equipo de desarrollo.
Asimismo, el sistema maneja dos roles, docente y estudiante, y para cada uno existen funcionalidades específicas. Por otro lado, cuenta con un sistema básico de autenticación independiente para cada rol, además de un registro y la recuperación de la contraseña exclusivamente por parte del estudiante mediante unas preguntas de seguridad que son establecidas previamente durante el registro en el sistema.

## Apartado del Docente

Modulos disponibles:
* **Mostrar Estudiantes:** En la vista principal del docente *mainTeacher.php* muestra todos los estudiantes registrados en una tabla que cuenta con los campos: cédula, apellidos, nombres, correo electrónico y opciones. La lógica que lleva a cabo esto se encuentra en el modelo *TableModel* que se encarga de obtener todos los estudiantes en la base de datos. Este modelo lo emplea el controlador *TableController*.
* **Agregar Notas:** El docente al presionar el botón "Agregar" ubicado dentro de la tabla será redirigido a la vista *addNotes.php* la cual emplea el modelo *NoteModel* en los controladores *NoteController* y *StudentDataController*.

* **Modificar Notas:** En caso de algún error, el docente podrá actualizar una o varias notas de un estudiante determinado. Para ello se encuentra el botón "Editar" que redirigirá al docente a un formulario que contendrá las notas ya anteriormente registradas del estudiante en cuestión dando la oportunidad de modificar cualquiera de estas.

## Apartado del Estudiante

El estudiante tendrá la facilidad de navegar entre distintas opciones mediante un menú ubicado al lado izquierdo que se divide en:
1. Perfil.
2. Agregar datos de contacto.
3. Ver calificaciones.

* **Perfil:** Una vez iniciada la sesión en el sistema, el estudiante es redirigido a su perfil de usuario. Esta vista mostrará el nombre completo del estudiante, su cédula de identidad y su información de contacto en caso de tenerla.

* **Agregar Datos de Contacto:** El estudiante tendrá la opción de agregar su información de contacto más relevante, en este caso el número de teléfono y el correo electrónico el cual se reflejará en la vista de Perfil.

* **Ver Calificaciones:** Por último, el módulo más indispensable. El estudiante podrá ver las notas de cada momento y la nota definitiva de la única materia con la que trabaja el sistema.

## Apartado de Detalles Técnico

>**NOTA:** ESTO ES UNA DESCRIPCIÓN Y EXPLICACIÓN BÁSICA PRELIMINAR DEL SISTEMA, SE CONTINUARÁ.