<?php

namespace App\Controller;

use App\Entity\Actor;
use App\Entity\Movie;
use App\Form\MovieType;
use App\Form\ActorType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Traits\Map\Actor as ActorMap;

class AdminController extends AbstractController
{
    use ActorMap;

    /**
     * @Route("/admin", name="admin", methods={"GET"})
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'title' => 'Dashboard',
            'page' => 'dashboard',
        ]);
    }

    /**
     * View list of movies
     *
     * @Route("/admin/movies", name="admin.movies", methods={"GET"})
     */
    public function movies()
    {
        $movies = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->findAll();

        return $this->render('admin/movies/movies.html.twig', [
            'title' => 'Movies list',
            'page' => 'movies',
            'movies' => $movies,
        ]);
    }

    /**
     * Create a movie
     *
     * @Route("/admin/movies/create", name="admin.movies.create", methods={"GET"})
     */
    public function moviesCreate()
    {
        $movie = new Movie();
        $form = $this->createForm(MovieType::class, $movie, [
            'action' => $this->generateUrl('admin.movies.actions.create'),
        ]);

        return $this->render('admin/movies/create.html.twig', [
            'title' => 'Add a movie',
            'page' => 'movies',
            'form' => $form->createView(),
        ]);
    }

    /**
     * View list of actors
     *
     * @Route("/admin/actors", name="admin.actors", methods={"GET"})
     */
    public function actors()
    {
        $actors = $this->getDoctrine()
            ->getRepository(Actor::class)
            ->findAll();

        return $this->render('admin/actors/actors.html.twig', [
            'title' => 'Actors list',
            'page' => 'actors',
            'actors' => $this->mapCollectionActor($actors),
        ]);
    }

    /**
     * Create an actor
     *
     * @Route("/admin/actors/create", name="admin.actors.create", methods={"GET"})
     */
    public function actorsCreate()
    {
        $actor = new Actor();
        $form = $this->createForm(ActorType::class, $actor, [
            'action' => $this->generateUrl('admin.actors.actions.create'),
        ]);

        return $this->render('admin/actors/create.html.twig', [
            'title' => 'Add an actor',
            'page' => 'actors',
            'form' => $form->createView(),
        ]);
    }

    /**
     * Edit an actor
     *
     * @Route("/admin/actors/edit/{actorId}", name="admin.actors.edit", methods={"GET"})
     */
    public function actorsEdit(string $actorId)
    {
        $actor = $this->getDoctrine()
            ->getRepository(Actor::class)
            ->find($actorId);
        
        $form = $this->createForm(ActorType::class, $actor, [
            'action' => $this->generateUrl('admin.actors.actions.edit', [
                'actorId' => $actorId,
            ]),
            'isEdit' => true,
        ]);

        return $this->render('admin/actors/edit.html.twig', [
            'title' => 'Edit an actor',
            'page' => 'actors',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/login-page", name="admin.login.page", methods={"GET"})
     */
    public function login()
    {
        return $this->render('admin/login.html.twig', [
            'title' => 'Login',
        ]);
    }
}
