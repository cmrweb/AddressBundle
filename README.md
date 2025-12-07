
![AddressBundle](https://github.com/user-attachments/assets/5a6fc6a9-f5e2-45dc-ade9-636b32be6063)

Installation
============

Make sure Composer is installed globally, as explained in the
[installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Applications that use Symfony Flex
----------------------------------

Open a command console, enter your project directory and execute:

```console
composer require cmrweb/address-bundle
```

Applications that don't use Symfony Flex
----------------------------------------

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
composer require cmrweb/address-bundle
```

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php  
return [ 
    Cmrweb\AddressBundle\AddressBundle::class => ['all' => true],
];
```

### Usage 

## Display autocompletion input

Make search address component

```console
// without css
symfony console make:address

// bootstrap 5 classes
symfony console make:address -b
```

```html
<twig:SearchAddress />
```
 
## Get Address

Return Address Model with AddressTrait in same or other component.

```php
// ...
use AddressTrait;
// ...

# return Address Model
$this->getAddress()

# return Address array
$this->getAddressArray()
```

Twig

```html
{{ dump(address) }}
{{ dump(addressArray) }}
```

Address Model

```php
string $label;
string $numero;
string $libelle;
string $codePostal;
string $ville;
string $region;
float $lat;
float $lon;

public function getLabel(): string;
public function getNumero(): string;
public function getLibelle(): string;
public function getCodePostal(): string;
public function getVille(): string;
public function getRegion(): string;
public function getLat(): float;
public function getLon(): float; 
```

