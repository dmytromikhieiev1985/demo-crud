<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\UserDto;
use App\Mapper\UserMapper;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityNotFoundException;

class UserSerivce
{
    public function __construct(
        private readonly UserMapper $userMapper,
        private readonly UserRepository $userRepository
    ) {
    }

    public function createUser(UserDto $userDto): UserDto
    {
        $entity = $this->userMapper->mapDtoToEntity($userDto);
        $this->userRepository->save($entity);

        return $userDto;
    }

    public function updateUser(UserDto $userDto, int $id): UserDto
    {
        $entity = $this->userRepository->find($id);
        if ($entity === null) {
            throw new EntityNotFoundException('User not found');
        }
        $entity = $this->userMapper->mapDtoToEntity($userDto, $entity);
        $this->userRepository->save($entity);

        return $userDto;
    }

    public function deleteUser(int $id): void
    {
        $entity = $this->userRepository->find($id);
        
        if ($entity === null) {
            throw new EntityNotFoundException('User not found');
        }
        
        $this->userRepository->remove($entity);
    }

    public function getUsers(): array
    {
        return $this->userRepository->findAll();
    }

    public function getUser(int $id): object
    {
        $entity = $this->userRepository->find($id);
        
        if ($entity === null) {
            throw new EntityNotFoundException('User not found');
        }
        
        return $entity;
    }
}
