# Bolsa de trabajo Empleabilidad

Explicacion del Proyecto.

## Caracteristicas

- Simple y fácil de entender.
- URLs amigables (básico).
- PDO para acceso a la base de datos.
- Código PHP nativo, por lo que las personas no tienen que aprender un framework.
- Intenta seguir las pautas de codificación de PSR.
- Utiliza el autocargador PSR-4.

## Seguridad

El script utiliza mod_rewrite y bloquea todo el acceso a todo lo que esté fuera de la carpeta `/public`. Para las solicitudes a la base de datos se utiliza PDO para evitar inyección SQL.

## PSR-4

```
{
    "psr-4":
    {
        "Core\\" : "Core/",
        "App\\" : "App/"
    }
}
```

## Inicio rapido

#### Mostrando una vista

Veamos el método `example()` en el controlador `Home` (`App/Controller/Home.php`). Esto simplemente muestra el encabezado, el pie y la página `example.php` (`App/Views/home/example.php`).

```php
public function example()
{
    $views = ['home/example'];
    $args  = ['title' => 'Home | Example'];
    View::render($views, $args);
}
```  

#### Mostrando un json


```php
public function exampleOne()
{
    $data  = ['title' => 'Home | Example'];
    View::renderJson($data);
}
```  

#### Trabajando con datos

Veamos un ejemplo similar a exampleOne, pero aquí también solicitamos datos. De nuevo, todo es extremadamente reducido y simple: `$exampleModel->getAll()` simplemente llama al método `getAll()` en `App/Model/ExampleModel.php`.

```php
namespace App\Model;

use Core\Model;

class ExampleModel extends Model
{
    public function getAll()
    {
        $query = $this->db->prepare("SELECT id, full_name FROM table");
        $query->execute();
        return $query->fetchAll();
    }
}
```

```php
namespace App\Controller;

use App\Model\ExampleModel;

class Home
{
    public function exampleOne()
    {
        $exampleModel = new ExampleModel();
        $args  = [
            'title' => 'Home | Example',
            'rows' => $exampleModel->getAll()
        ];
        View::render(['home/example'], $args);
    }
}
```

El resultado, aquí `$rows`, se puede usar fácilmente dentro de las vistas en `App/Views`:

```php
<tbody>
<?php foreach ($rows as $row): ?>
    <tr>
        <td><?= $row->id ?></td>
        <td><?= $row->full_name ?></td>
    </tr>
<?php endforeach; ?>
</tbody>
```