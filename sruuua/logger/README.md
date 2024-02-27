# LOGGER

## Easy logger [PSR 3](https://www.php-fig.org/psr/psr-3/) friendly

Default logs file in logs/logs.log

```php

use Sruuua\logger\Logger;

$logger = new Logger();
$logger->alert('My message says {content}', ['content' => 'hello']);
```