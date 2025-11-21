<?php

namespace Cmrweb\AddressBundle\Components;

use Cmrweb\AddressBundle\Service\ApiAddressService;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent()]
final class AddressComponent
{
    use DefaultActionTrait;
    use ComponentToolsTrait;

    #[LiveProp(writable: true)]
    public string $addressLabel = '';
    #[LiveProp(writable: true)]
    public ?array $autocompletions = null;


    public function __construct(
        private readonly ApiAddressService $apiAddressService
    ) {}


    #[LiveAction]
    public function setAddressLabel()
    {
        if (strlen($this->addressLabel) > 7) {
            $this->autocompletions = $this->apiAddressService->autocomplete($this->addressLabel);
        }
    }

    #[LiveAction]
    public function selectCompletion(#[LiveArg('key')] int $key)
    {
        $this->addressLabel = $this->autocompletions[$key]['fulltext'];
        $this->autocompletions = null;
        $currentAddress = $this->apiAddressService->search($this->addressLabel);
         
        $this->emit('setCurrentAddress', [
            'address' => $currentAddress
        ]); 
    }

    #[LiveListener('setAddressFromEntreprise')]
    public function setAddressFromEntreprise(#[LiveArg('address')]?string $address)
    { 
        $this->addressLabel = $address;
        $currentAddress = $this->apiAddressService->search($address);
        $this->emit('setCurrentAddress', [
            'address' => $currentAddress 
        ]); 
    }
}
