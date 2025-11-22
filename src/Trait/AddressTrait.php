<?php

namespace Cmrweb\AddressBundle\Trait;

use Cmrweb\AddressBundle\Model\Address;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

trait AddressTrait
{
    #[LiveProp(writable: true)]
    public ?Address $address = null;
    #[LiveProp(writable: true)]
    public ?array $addressArray = null;

    #[LiveListener('setCurrentAddress')]
    public function setCurrentAddress(#[LiveArg('address')] ?array $address): void
    {
        if(null !== $address) {
            $this->addressArray = $address;
            $this->address = Address::fromArray($address);
        }
    } 

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function getAddressArray(): ?array
    {
        return $this->addressArray;
    }

    private function flashAddressError(): void
    {
        $this->addFlash('danger', 'Veuillez reseigner une adresse!'); 
    }
}
