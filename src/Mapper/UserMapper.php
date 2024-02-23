<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Dto\UserDto;
use App\Entity\User;

class UserMapper
{
    public function mapDtoToEntity(UserDto $dto, ?User $entity = null): User
    {
        $result = $entity ?: new User();
        if ($dto->email !== null) {
            $result->setEmail($dto->email);
        }
        if ($dto->first_name !== null) {
            $result->setFirstName($dto->first_name);
        }
        if ($dto->last_name !== null) {
            $result->setLastName($dto->last_name);
        }
        if ($dto->phone !== null) {
            $result->setPhone($dto->phone);
        }

        return $result;
    }

    public function mapEntityToDto(User $entity): UserDto
    {
        $result = new UserDto();
        $result->email = $entity->getEmail();
        $result->first_name = $entity->getFirstName();
        $result->last_name = $entity->getLastName();
        $result->phone = $entity->getPhone();
        
        return $result;
    }
}
