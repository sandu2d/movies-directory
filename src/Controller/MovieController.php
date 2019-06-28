<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class MovieController extends AbstractController
{
    /**
     * Create a movie
     *
     * @param Request $request
     * 
     * @Route("/admin/movies/create", name="admin.movies.actions.create", methods={"POST"})
     */
    public function create(Request $request)
    {
        
    }
}
