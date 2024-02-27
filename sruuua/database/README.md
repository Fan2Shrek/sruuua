# Sruuua connection

Basic PDO connection

<br>

## Example :  

<br>

```php
class ExampleProvider extends AbstractProvider{

    public function __construct(Connection $connection, CachePool $cachePool, Hydrator $hydrator)
    {
        parent::__construct(Example::class, $cachePool, $connection, $hydrator);
    }
}
```