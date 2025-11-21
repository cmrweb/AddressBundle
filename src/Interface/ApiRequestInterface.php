<?php
namespace Cmrweb\AddressBundle\Interface; 

interface ApiRequestInterface
{
    public function get(string $request, array $context): array;
}