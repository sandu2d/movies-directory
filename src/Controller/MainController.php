<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Movie;
use App\Entity\Genre;
use App\Entity\Actor;
use App\Entity\Director;

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

        $actors = $this->getDoctrine()
            ->getRepository(Actor::class)
            ->findAll();

        $directors = $this->getDoctrine()
            ->getRepository(Director::class)
            ->findAll();

        return $this->render('website/index.html.twig', [
            'controller_name' => 'MainController',
            'movies' => $movies,
            'genres' => $genres,
            'actors' => $actors,
            'directors' => $directors,
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

        $actors = $this->getDoctrine()
            ->getRepository(Actor::class)
            ->findAll();

        $directors = $this->getDoctrine()
            ->getRepository(Director::class)
            ->findAll();

        return $this->render('website/genre.html.twig', [
            'genres' => $genres,
            'actors' => $actors,
            'directors' => $directors,
            'genre' => $genreSearched,
            'movies' => $genreSearched->getMovies(),
            'page' => 'genres',
            'title' => 'Genre page',
        ]);
    }

    /**
     * View movie details
     *
     * @Route("/movie/{movieId}", name="movie.page", methods={"GET"})
     */
    public function moviePage(string $movieId)
    {
        $genres = $this->getDoctrine()
            ->getRepository(Genre::class)
            ->findAll();

        $movie = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->find($movieId);

        $actors = $this->getDoctrine()
            ->getRepository(Actor::class)
            ->findAll();

        $directors = $this->getDoctrine()
            ->getRepository(Director::class)
            ->findAll();

        return $this->render('website/movie.html.twig', [
            'genres' => $genres,
            'actors' => $actors,
            'directors' => $directors,
            'movie' => $movie,
            'page' => 'movie',
            'title' => $movie->getName(),
        ]);
    }

    /**
     * View actor details
     *
     * @param string $actorId
     * 
     * @Route("/actors/{actorId}", name="actor.page", methods={"GET"})
     */
    public function actorPage(string $actorId)
    {

    }

    /**
     * View director details
     *
     * @param string $directorId
     * 
     * @Route("/actors/{directorId}", name="director.page", methods={"GET"})
     */
    public function directorPage(string $directorId)
    {

    }
}
