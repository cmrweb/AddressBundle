<?php
namespace Cmrweb\AddressBundle\Interface;

use Symfony\Contracts\HttpClient\ResponseInterface;

interface ApiRequestInterface
{
    public function get(string $request, array $context): ResponseInterface;
    public function getCurl(string $route, array $context, ?array $authBasic = null): ResponseInterface;
}