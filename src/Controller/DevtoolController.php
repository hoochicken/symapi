<?php

namespace App\Controller;

use App\Repository\DevtoolRepository;
use App\Repository\PasswordRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DevtoolController extends ApiController
{
    public function indexAction(Request $request)
    {
        return $this->respond(['password' => 'asda']);
    }

    public function passwordAction(Request $request, PasswordRepository $devtoolRepository)
    {
        $length = (int) $request->get('length', 10);
        $count = (int) $request->get('length', 3);
        $password = $devtoolRepository->generatePasswords($length, $count);
        return $this->respond(['password' => $password]);
    }

    public function passwordsAction(Request $request, PasswordRepository $devtoolRepository)
    {
        $length = (int) $request->get('length', 10);
        $count = (int) $request->get('length', 3);
        $password = $devtoolRepository->generatePasswords($length, $count);
        return $this->respond(['passwords' => $password]);
    }
}
