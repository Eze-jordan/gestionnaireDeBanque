<?php
namespace App\Dto;
class ClientDto
{
    public function __construct(
        public string $nom,
        public string $email,
        public ?string $telephone = null
    ) {}
}
