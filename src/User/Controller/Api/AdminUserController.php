<?php

namespace App\User\Controller\Api;

use App\AbstractGeneralController;
use App\User\Application\Command\UserChangeData;
use App\User\Application\Command\UserChangePassword;
use App\User\Application\Command\UserChangeStatus;
use App\User\Application\Command\UserCreate;
use App\User\Application\Command\UserGetById;
use App\User\Application\Command\UserList;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/user')]
class AdminUserController extends AbstractGeneralController
{
    #[Route('/create', name: 'app_user_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        try {
            $this->commandBus->handle(
                new UserCreate(
                    $this->getContentValue('name'),
                    $this->getContentValue('surname'),
                    $this->getContentValue('password'),
                    $this->getContentValue('email'))
            );

            return $this->json([], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
