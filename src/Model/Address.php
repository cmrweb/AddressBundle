<?php
namespace Cmrweb\AddressBundle\Model;

class Address
{
    public string $label;
    public string $numero;
    public string $libelle;
    public string $codePostal;
    public string $ville;
    public string $region;
    public float $lat;
    public float $lon;

    public function getLabel(): string { return $this->label; }
    public function getNumero(): string { return $this->numero; }
    public function getLibelle(): string { return $this->libelle; }
    public function getCodePostal(): string { return $this->codePostal; }
    public function getVille(): string { return $this->ville; }
    public function getRegion(): string { return $this->region; }
    public function getLat(): float { return $this->lat; }
    public function getLon(): float { return $this->lon; } 

    public static function fromArray(array $data): self
    {
        $address = new self();

        $address->label      = $data['label']      ?? '';
        $address->numero     = $data['numero']     ?? '';
        $address->libelle    = $data['libelle']    ?? '';
        $address->codePostal = $data['codePostal'] ?? '';
        $address->ville      = $data['ville']      ?? '';
        $address->region     = $data['region']     ?? '';
        $address->lat        = $data['position']['lat'] ?? 0.0;
        $address->lon        = $data['position']['lon'] ?? 0.0;

        return $address;
    }

    public function toArray(): array
    {
        return [
            'label' => $this->label,
            'numero' => $this->numero,
            'libelle' => $this->libelle,
            'codePostal' => $this->codePostal,
            'ville' => $this->ville,
            'region' => $this->region,
            'position' => [
                'lat' => $this->lat,
                'lon' => $this->lon,
            ],
        ];
    }
}