<?php
namespace Cmrweb\AddressBundle\Trait;

use Cmrweb\AddressBundle\Service\ApiAddressService;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

trait SearchAddressTrait
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
        } else {
            $this->autocompletions = null;
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
}