# SRUUUA ROUTING

Sruuua routing system

## Utilisation :

```php
# src/Controller/SomeController.php

<?php

namespace App\Controller\SomeController;

use Sruuua\Routing\Route;
use Sruuua\Routing\Interface\ControllerInterface;

class SomeController implements ControllerInterface{

    #[Route('/index')]
    public function index(){
        return 'index';
    }

    // Pass variable in url with
    #[Route('/article/{id}')]
    public function viewArticle(int $id)
    {
        return $id;
    }
}
```
