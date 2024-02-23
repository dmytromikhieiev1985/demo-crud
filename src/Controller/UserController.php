<?php

namespace App\Controller;

use App\Service\UserSerivce;
use App\Service\ValidationService;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Exception\ValidationFailedException;

final class UserController extends AbstractController
{
    public function __construct(
        private readonly UserSerivce $userSerivce,
        private readonly ValidationService $validationService
    ) {
    }

    #[Route('/users', name: 'users', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json($this->userSerivce->getUsers());
    }

    #[Route('/users/{id}', name: 'user', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        try {
            return $this->json($this->userSerivce->getUser($id));
        } catch (EntityNotFoundException $e) {
            return $this->json(['message' => $e->getMessage()], 404);
        }
        
    }

    #[Route('/users', name: 'user_create', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent());
        if (!$data) {
            return $this->json(['message' => 'Invalid JSON'], 400);
        }
        try {
            $userDTO = $this->validationService->validateUserInput($data);
        } catch (ValidationFailedException $e) {
            return $this->json($e->getViolations(), 422);
        }
        $user = $this->userSerivce->createUser($userDTO);

        return $this->json($user, 201);
    }

    #[Route('/users/{id}', name: 'user_update', requirements: ['id' => '\d+'], methods: ['PUT'])]
    public function update(Request $request, int $id): Response
    {
        $data = json_decode($request->getContent());
        if (!$data) {
            return $this->json(['message' => 'Invalid JSON'], 400);
        }
        try {
            $userDTO = $this->validationService->validateUserInput($data);
        } catch (ValidationFailedException $e) {
            return $this->json($e->getViolations(), 422);
        }

        try {
            $user = $this->userSerivce->updateUser($userDTO, $id);
        } catch (EntityNotFoundException $e) {
            return $this->json(['message' => $e->getMessage()], 404);
        } catch (\Throwable $e) {
            return $this->json(['message' => $e->getMessage()], 500);
        }

        return $this->json($user);
    }

    #[Route('/users/{id}', name: 'user_delete', methods: ['DELETE'])]
    public function delete(int $id): Response
    {
        try {
            $this->userSerivce->deleteUser($id);
        } catch (EntityNotFoundException $e) {
            return $this->json(['message' => $e->getMessage()], 404);
        } catch (\Throwable $e) {
            return $this->json(['message' => $e->getMessage()], 500);
        }

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}
