<?php

namespace Cmrweb\AddressBundle;
 
use Symfony\Component\HttpKernel\Bundle\Bundle; 

class AddressBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
     
}
