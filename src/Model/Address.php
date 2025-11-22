<?php
namespace Cmrweb\AddressBundle\Model;

class Address
{
    private string $label;
    private string $numero;
    private string $libelle;
    private string $codePostal;
    private string $ville;
    private string $region;
    private float $lat;
    private float $lon;

    public function getLabel(): string { return $this->label; }
    public function getNumero(): string { return $this->numero; }
    public function getLibelle(): string { return $this->libelle; }
    public function getCodePostal(): string { return $this->codePostal; }
    public function getVille(): string { return $this->ville; }
    public function getRegion(): string { return $this->region; }
    public function getLat(): float { return $this->lat; }
    public function getLon(): float { return $this->lon; }
    public function getPosition(): string { return $this->lat . ',' .$this->lon; }

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