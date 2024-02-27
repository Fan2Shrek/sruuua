<?php

namespace Sruuua\Database\Result\Interface;

interface ResultInterface
{
    public function fetchAssociative();

    public function fetchNumeric();

    public function fetchAllAssociative();

    public function fetchAllNumeric();
}
