<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\GenreType;
use App\Entity\Genre;

class GenreController extends AbstractController
{
    /**
     * Create a genre
     *
     * @param Request $request
     *
     * @Route("/admin/genres/create", name="admin.genres.actions.create", methods={"POST"})
     */
    public function create(Request $request)
    {
        $genre = new Genre();
        $form = $this->createForm(GenreType::class, $genre);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $genre = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($genre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.genres');
    }

    /**
     * Edit a genre
     *
     * @Route("/admin/genres/edit/{genreId}", name="admin.genres.actions.edit", methods={"POST"})
     */
    public function edit(Request $request, string $genreId)
    {
        $genre = $this->getDoctrine()
            ->getRepository(Genre::class)
            ->find($genreId);

        $form = $this->createForm(GenreType::class, $genre);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $genre = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($genre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.genres');
    }

    /**
     * Remove a genre
     *
     * @param string $genreId
     *
     * @Route("/admin/genres/remove/{genreId}", name="admin.genres.actions.remove", methods={"POST"})
     */
    public function remove(string $genreId)
    {
        $genre = $this->getDoctrine()
            ->getRepository(Genre::class)
            ->find($genreId);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($genre);
        $entityManager->flush();

        return $this->redirectToRoute('admin.genres');
    }
}
