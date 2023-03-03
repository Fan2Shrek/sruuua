# SRUUUA ROUTING

Personnal routing system

## Utilisation

```
# src/controller

<?php

namespace App\Controller\SomeController

use Sruuua\Routing\Route

class SomeController{

    #[Route('/index')]
    public function index(){
        return 'index';
    }
    
}
```