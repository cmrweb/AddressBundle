<?php
namespace Cmrweb\AddressBundle\Tests\Components;

use Cmrweb\AddressBundle\Components\AddressComponent;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AddressComponentTest extends KernelTestCase
{
    public function testComponentCompletion(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $component = $container->get(AddressComponent::class);
        $component->autocompletions = [
            ['fulltext' => '10 rue de Paris, 80000 Amiens']
        ];

        $component->selectCompletion(0);

        $this->assertSame('10 rue de Paris, 80000 Amiens', $component->addressLabel);
        $this->assertNull($component->autocompletions);
        
        restore_exception_handler();
    }
    
}