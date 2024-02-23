<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final class UserDto
{
    #[Assert\Email]
    #[Assert\Length(
        max: 255
    )]
    #[Assert\NotBlank]
    public ?string $email = null;

    #[Assert\NotBlank]
    #[Assert\Length(
        max: 255
    )]
    public ?string $first_name = null;

    #[Assert\Length(
        max: 255
    )]
    public ?string $last_name = null;

    #[Assert\Length(
        max: 255
    )]
    public ?string $phone = null;
}
