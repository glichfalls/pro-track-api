<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TimeRecordController extends AbstractController
{
    /**
     * @Route("/time/record", name="time_record")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/TimeRecordController.php',
        ]);
    }
}
