<?php

namespace App\Controller;

use App\Entity\Actor;
use App\Entity\Language;
use App\Entity\Movie;
use App\Form\ActorType;
use App\Form\LanguageType;
use App\Form\MovieType;
use App\Traits\Map\Actor as ActorMap;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
     * Remove an actor
     *
     * @Route("/admin/actors/remove/{actorId}", name="admin.actors.remove", methods={"GET"})
     */
    public function actorsRemove(string $actorId)
    {
        return $this->forward('App\Controller\ActorController::remove', [
            'actorId'  => $actorId,
        ]);
    }

    /**
     * View languages page
     *
     * @Route("/admin/languages", name="admin.languages", methods={"GET"})
     */
    public function languages()
    {
        $languages = $this->getDoctrine()
            ->getRepository(Language::class)
            ->findAll();

        return $this->render('admin/languages/index.html.twig', [
            'title' => 'Languages list',
            'page' => 'languages',
            'languages' => $languages,
        ]);
    }

    /**
     * Create language page
     *
     * @Route("/admin/languages/create", name="admin.languages.create", methods={"GET"})
     */
    public function languagesCreate()
    {
        $lang = new Language();
        $form = $this->createForm(LanguageType::class, $lang, [
            'action' => $this->generateUrl('admin.languages.actions.create'),
        ]);

        return $this->render('admin/languages/create.html.twig', [
            'title' => 'Add a language',
            'page' => 'languages',
            'form' => $form->createView(),
        ]);
    }

    /**
     * Edit language page
     *
     * @Route("/admin/languages/edit/{langId}", name="admin.languages.edit", methods={"GET"})
     */
    public function languagesEdit(string $langId)
    {
        $lang = $this->getDoctrine()
            ->getRepository(Language::class)
            ->find($langId);

        $form = $this->createForm(LanguageType::class, $lang, [
            'action' => $this->generateUrl('admin.languages.actions.edit', [
                'langId' => $langId,
            ]),
            'isEdit' => true,
        ]);

        return $this->render('admin/languages/edit.html.twig', [
            'title' => 'Edit a language',
            'page' => 'languages',
            'form' => $form->createView(),
        ]);
    }

    /**
     * Remove a language
     *
     * @Route("/admin/languages/remove/{langId}", name="admin.languages.remove", methods={"GET"})
     */
    public function languagesRemove(string $langId)
    {
        return $this->forward('App\Controller\LanguageController::remove', [
            'langId'  => $langId,
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
