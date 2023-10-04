<?php
// src/Service/CircularReferenceHandler.php
namespace App\Service;

class CircularReferenceHandler 
{
    public function __invoke($object)
    {
        return $object->getId(); // Return a unique identifier for the object
    }
}

