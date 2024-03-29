<?php

namespace App\Controller\Action\User;

use App\Entity\User;
use App\Service\Request\RequestService;
use App\Service\User\UserRegisterService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class Register
{
    private UserRegisterService $userRegisterService;

    public function __construct(UserRegisterService $userRegisterService)
    {
        $this->userRegisterService = $userRegisterService;
    }

    public function __invoke(Request $request): User
    {
        return $this->userRegisterService->create(
            RequestService::getField($request, 'name'),
            RequestService::getField($request, 'email'),
            RequestService::getField($request, 'password')
        );
    }
}