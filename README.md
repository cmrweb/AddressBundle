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
<div {{attributes}}> 
    <input type="text" {{ live_action('setAddressLabel', event:'input') }} data-model="addressLabel" placeholder="address">
    <ul>
        {% for key, completion in autocompletions %}
        <li value="{{key}}"> 
            <button type="button" {{live_action('selectCompletion', {key: key})}}>
                {{completion.fulltext}}
            </button> 
        </li>
        {% endfor %}
    </ul> 
</div>
```

Reponse is return with AddressFormTrait

```php
    // ...
    use DefaultActionTrait;
    use AddressFormTrait;
    // ...
    # return Address to array
    dd($this->getAddress(), $this->currentAddress);
```

