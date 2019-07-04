<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Movie;
use App\Form\MovieType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Service\PosterUploader;
use App\Entity\MovieAward;

class MovieController extends AbstractController
{
    /**
     * Create a movie
     * 
     * @Route("/admin/movies/create", name="admin.movies.actions.create", methods={"POST"})
     */
    public function create(Request $request, PosterUploader $posterUploader)
    {
        $movie = new Movie();
        $form = $this->createForm(MovieType::class, $movie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $poster = $form['poster']->getData();
            $movie = $form->getData();

            $movie->setPoster(
                $posterUploader->upload($poster)
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($movie);
            $entityManager->flush();
        } else {
            return $this->forward('App\Controller\AdminController::moviesCreate', [
                'form' => $form,
            ]);
        }

        return $this->redirectToRoute('admin.movies');
    }

    /**
     * Edit a movie
     *
     * @Route("/admin/movies/edit/{movieId}", name="admin.movies.actions.edit", methods={"POST"})
     */
    public function edit(Request $request, string $movieId, PosterUploader $posterUploader)
    {
        $movie = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->find($movieId);

        $posterUploader->remove($movie->getPoster());

        $form = $this->createForm(MovieType::class, $movie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $poster = $form['poster']->getData();
            $movie = $form->getData();

            $movie->setPoster(
                $posterUploader->upload($poster)
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($movie);
            $entityManager->flush();
        } else {
            return $this->forward('App\Controller\AdminController::moviesEdit', [
                'form' => $form,
            ]);
        }

        return $this->redirectToRoute('admin.movies');
    }

    /**
     * Remove a movie
     *
     * @param string $movieId
     *
     * @Route("/admin/movies/remove/{movieId}", name="admin.movies.actions.remove", methods={"POST"})
     */
    public function remove(string $movieId, PosterUploader $posterUploader)
    {
        $movie = $this->getDoctrine()
            ->getRepository(Movie::class)
            ->find($movieId);

        $posterUploader->remove($movie->getPoster());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($movie);
        $entityManager->flush();

        return $this->redirectToRoute('admin.movies');
    }
}
