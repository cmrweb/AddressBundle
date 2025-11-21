<?php
namespace Cmrweb\AddressBundle\Tests\Service;

use Cmrweb\AddressBundle\Service\ApiAddressService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ApiAddressTest extends KernelTestCase
{ 
    public function testSearchAddress(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $apiAddress = $container->get(ApiAddressService::class);

        $response = $apiAddress->autocomplete("10 rue de paris");
        $this->assertIsArray($response);
        $address = $apiAddress->search($response[0]['fulltext']);
        $this->assertIsArray($address); 
        $this->assertNotEmpty($address);

        restore_exception_handler();
    }
}