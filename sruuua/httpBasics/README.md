# HTTP BASIC

## Basic classes for sruuua framework

This library has 3 classes :  
Request -> a request object that containt globals variable  
Create with

```php
$request = Request::getRequest();
```

<br>
Response -> to create a basic response, you can set a code and a content

```php
(new Response(200, 'Hello world !'))();
```

Will return a 200 with 'Hello world !'

<br>
JsonReponse -> to create a reponse with json content pass the object to the content parameter

```php
(new JsonResponse(200, new Article('name', 'description')));
```

Will return a 200 with {"name":"name", "description":"description"}
