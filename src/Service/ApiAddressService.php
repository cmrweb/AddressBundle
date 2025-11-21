<?php
namespace Cmrweb\AddressBundle\Service;
 
use Cmrweb\AddressBundle\Abstract\AbstractApiRequest;

class ApiAddressService extends AbstractApiRequest
{ 
    private const string AUTOCOMPLETE = 'autocomplete';
    private const string SEARCH = 'search';

    private const array ROUTES = [
        self::AUTOCOMPLETE => 'geocodage/completion/',
        self::SEARCH => '/geocodage/search'
    ]; 
    
    public function autocomplete(string $term): ?array
    {
        $request = $this->request(self::AUTOCOMPLETE, [
            'text' => $term,
            'type' => 'StreetAddress'
        ]);
        return $request['results'] ?? null;
    }

    public function search(string $fulltext): ?array
    {
        $request = $this->request(self::SEARCH, [
            'q' => $fulltext,
            'limit' => 1
        ]);
        if(!isset($request['features'])) {
            return null;
        }
        return $this->formatFeaturesAddress(reset($request['features']));
    }

    private function formatFeaturesAddress(array $features): array
    {
        $prop =  $features['properties'];
        return [ 
            'label' => $prop['label'],
            'numero' => $prop['housenumber'] ?? null,
            'libelle' => $prop['street'] ?? null,
            'codePostal' => $prop['postcode'] ?? null,
            'ville' => $prop['city'] ?? null,
            'region' => $prop['context'] ?? null,
            'position' => [
                'lat' => $features['geometry']['coordinates'][1] ?? null,
                'lon' => $features['geometry']['coordinates'][0] ?? null,
            ],
        ]; 
    }

    private function request(string $request, array $context): array
    {
        return $this->get(self::ROUTES[$request], $context);
    }
 
}