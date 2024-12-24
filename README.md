# Sistema-Universitario
Proyecto de lenguaje de programación III (ayúdennos)
## Funcionamiento del sistema
El sistema ha sido creado empleando el patrón **MVC (Model-View-Controller)** para una organización más clara del proyecto y una mejor distribución de las responsabilidades entre el equipo de desarrollo.
Asimismo, el sistema maneja dos roles, docente y estudiante, y para cada uno existen funcionalidades específicas. Por otro lado, cuenta con un sistema básico de autenticación independiente para cada rol, además de un registro y la recuperación de la contraseña exclusivamente por parte del estudiante mediante unas preguntas de seguridad que son establecidad previamente durante el registro en el sistema.

## Apartado del docente

Modulos disponibles:
* **Mostrar Estudiantes:** En la vista principal del docente *mainTeacher.php* muestra todos los estudiantes registrados en una tabla que cuenta con los campos: cédula, apellidos, nombres, correo electrónico y opciones. La lógica que lleva a cabo esto se encuentra en el modelo *TableModel* que se encarga de obtener todos los estudiantes en la base de datos. Este modelo lo emplea el controlador *TableController*.
* **Agregar Notas:** El docente al presionar el botón "Agregar" ubicado dentro de la tabla será redirigido a la vista *addNotes.php* la cual emplea el modelo *NoteModel* en los controladores *NoteController* y *StudentDataController*.

* **Modificar Notas:** 

>**NOTA:** ESTO ES UNA DESCRIPCIÓN Y EXPLICACIÓN BÁSICA PRELIMINAR DEL SISTEMA, SE CONTINUARÁ.