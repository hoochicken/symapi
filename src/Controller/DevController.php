<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;

class DevController extends ApiController
{
    public function indexAction(Request $request)
    {
        return $this->respond(['status' => 1, 'status_messasge' => 'Yes, we made it. Well done!']);
    }

    public function healthAction(Request $request)
    {
        return $this->respond(['r' => 1, 'status_messasge' => 'Yes, we made it. Well done!']);
    }
}
