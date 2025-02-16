<?php

declare(strict_types=1);


namespace App\DTOs;


final readonly class TravelDTO
{
    public function __construct(
        public bool $is_public,
        public string $name,
        public string $description,
        public int $number_of_days,
    ){}

    public static function fromArray(array $data): self 
    {
        return new self (
            is_public: $data['is_public'],
            name: $data['name'],
            description: $data['description'],
            number_of_days: $data['number_of_days']
        );
    }
    public function toArray(): array
    {
        return [
            'is_public' => $this->is_public,
            'name' => $this->name,
            'description' => $this->description,
            'number_of_days' => $this->number_of_days
        ];
    }
}