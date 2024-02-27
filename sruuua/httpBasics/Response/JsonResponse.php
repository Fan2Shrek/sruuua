<?php

namespace Sruuua\HTTPBasics\Response;

class JsonResponse extends AbstractResponse
{
    public function __invoke()
    {
        header('Content-Type: application/json');
        $this->setContent(json_encode($this->getContent()));
        parent::__invoke();
    }
}
