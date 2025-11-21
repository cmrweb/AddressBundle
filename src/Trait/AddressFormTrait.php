<?php

namespace Cmrweb\AddressBundle\Trait;

use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

trait AddressFormTrait
{
    #[LiveProp(writable: true)]
    public ?array $currentAddress = null;

    #[LiveListener('setCurrentAddress')]
    public function setCurrentAddress(#[LiveArg('address')] ?array $address): void
    {
        $this->currentAddress = $address;
    } 

    private function flashAddressError(): void
    {
        $this->addFlash('danger', 'Veuillez reseigner une adresse!'); 
    }
}
