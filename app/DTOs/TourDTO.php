<?php

declare(strict_types=1);


namespace App\DTOs;


final readonly class TourDTO
{
    public function __construct(
        public string $name,
        public string $starting_date,
        public string $ending_date,
        public float $price,
    ){}

    public static function fromArray(array $data): self 
    {
        return new self (
            name: $data['name'],
            starting_date: $data['starting_date'],
            ending_date: $data['ending_date'],
            price: $data['price']
        );
    }
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'starting_date' => $this->starting_date,
            'ending_date' => $this->ending_date,
            'price' => $this->price
        ];
    }
}