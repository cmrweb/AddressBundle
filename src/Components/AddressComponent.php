<?php
namespace Cmrweb\AddressBundle\Components;

use Cmrweb\AddressBundle\Trait\AddressTrait;
use Cmrweb\AddressBundle\Trait\SearchAddressTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent()]
class AddressComponent
{
    use DefaultActionTrait;
    use SearchAddressTrait;
}