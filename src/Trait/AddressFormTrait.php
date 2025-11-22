<?php

namespace Cmrweb\AddressBundle\Trait;

use Cmrweb\AddressBundle\Model\Address;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

trait AddressFormTrait
{
    #[LiveProp(writable: true)]
    public ?Address $currentAddress = null;

    #[LiveListener('setCurrentAddress')]
    public function setCurrentAddress(#[LiveArg('address')] ?Address $address): void
    {
        $this->currentAddress = $address;
    } 

    public function getAddress(): ?Address
    {
        return $this->currentAddress;
    }

    public function getAddressArray(): array
    {
        return $this->currentAddress?->toArray();
    }

    private function flashAddressError(): void
    {
        $this->addFlash('danger', 'Veuillez reseigner une adresse!'); 
    }
}
