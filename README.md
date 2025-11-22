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

### Config

.env

```env
###> cmrweb/address-bundle ###
API_ADDRESS="https://data.geopf.fr/"
###< cmrweb/address-bundle ###
```

config/services.yaml

```yaml
parameters:
    # ...
    cmrweb.api.address: '%env(API_ADDRESS)%'
services:
    # ...
    Cmrweb\AddressBundle\Service\ApiAddressService:
            arguments:
                $url: '%cmrweb.api.address%'
```

### Usage 

## Display autocompletion input

Make Symfony live-component

```console
symfony console make:twig-component --live
```

Use SearchAddressTrait in your component

```php 
// ...
use DefaultActionTrait;
use SearchAddressTrait;
```

Edit your component.html.twig

```html
<!-- without css -->
<div {{attributes}}> 
    <input type="text" placeholder="address" autocomplete="false" spellcheck="false"
    {{ live_action('setAddressLabel', event:'input') }} data-model="addressLabel">
    <ul>
        {% for key, completion in autocompletions %}
        <li> 
            <button type="button" {{live_action('selectCompletion', {key: key})}}>
                {{completion.fulltext}}
            </button> 
        </li>
        {% endfor %}
    </ul> 
</div>
<!-- bootstrap -->
<div {{attributes}} class="input-goup">
    <input type="text" placeholder="address" class="form-control" autocomplete="false" spellcheck="false"
        {{ live_action('setAddressLabel', {event:'input', debounce: 1000}) }} data-model="addressLabel">

    <ul class="list-group">
        {% for key, completion in autocompletions %}
        <li class="list-group-item">
            <button type="button" {{live_action('selectCompletion', {key: key})}} class="btn border-0 w-100 text-start">
                {{completion.fulltext}}
            </button>
        </li>
        {% endfor %}
    </ul>
</div>
```

## Get Address

Return Address Model with AddressFormTrait in same or other component.

```php
// ...
use AddressFormTrait;
// ...

# return Address Model
$this->getAddress()

# return Address array
$this->getAddressArray()
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
# return string "lat,lon"
public function getPosition(): string;
```

