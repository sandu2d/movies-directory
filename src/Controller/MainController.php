<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Movie;
use App\Entity\Genre;

class MainController extends AbstractController
{
    /**
     * Show main page
     * 
     * @Route("/", name="index", methods={"GET"})
     */
    public function indexPage()
    {
        $movies = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->findAll();

        $genres = $this->getDoctrine()
            ->getRepository(Genre::class)
            ->findAll();

        return $this->render('website/index.html.twig', [
            'controller_name' => 'MainController',
            'movies' => $movies,
            'genres' => $genres,
            'page' => 'home',
            'title' => 'Home page',
        ]);
    }

    /**
     * Get movies based on genre
     *
     * @Route("/genre/{genreId}", name="genre.page", methods={"GET"})
     */
    public function genrePage(string $genreId)
    {
        $genres = $this->getDoctrine()
            ->getRepository(Genre::class)
            ->findAll();

        $genreSearched = $this->getDoctrine()
            ->getRepository(Genre::class)
            ->find($genreId);

        return $this->render('website/index.html.twig', [
            'controller_name' => 'MainController',
            'genres' => $genres,
            'movies' => $genreSearched->getMovies(),
            'page' => 'genre',
            'title' => 'Genre page',
        ]);
    }
}
