<?= "<?php\n" ?>

namespace <?= $namespace; ?>;

use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Cmrweb\AddressBundle\Trait\SearchAddressTrait;

#[AsLiveComponent]
final class <?= $class_name."\n" ?>
{
    use DefaultActionTrait;
    use SearchAddressTrait;
}
