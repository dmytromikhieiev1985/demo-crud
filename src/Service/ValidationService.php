<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\UserDto;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidationService
{
    public function __construct(protected readonly ValidatorInterface $validator)
    {
    }

    public function validateUserInput(\stdClass $data): UserDto
    {
        $userDTO = new UserDto();

        $userDTO->email = $data->email ?? null;
        $userDTO->first_name = $data->first_name ?? null;
        $userDTO->last_name = $data->last_name ?? null;
        $userDTO->phone = $data->phone ?? null;

        $errors = $this->validator->validate($userDTO);

        if (count($errors) > 0) {
            throw new ValidationFailedException('Validation failed', $errors);
        }

        return $userDTO;
    }
}
