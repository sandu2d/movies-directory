<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\MovieAward;
use App\Form\MovieAwardType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Award;
use App\Entity\AwardCategory;

class MovieAwardController extends AbstractController
{
    /**
     * Create an award for a movie
     *
     * @param Request $request
     *
     * @Route("/admin/movies/{movieId}/awards/create", name="admin.movies.awards.actions.create", methods={"POST"})
     */
    public function create(Request $request, string $movieId)
    {
        $movieAward = new MovieAward();
        $form = $this->createForm(MovieAwardType::class, $movieAward);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $movie = $this->getDoctrine()
                ->getRepository(Movie::class)
                ->find($movieId);

            $movieAward->setMovie($movie);

            $movieAward = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($movieAward);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.movies.awards', [
            'movieId' => $movieId,
        ]);
    }

    /**
     * Edit an award category
     *
     * @Route("/admin/movies/{movieId}/awards/edit/{awardId}", name="admin.movies.awards.actions.edit", methods={"POST"})
     */
    public function edit(Request $request, string $movieId, string $awardId)
    {
        $movieAward = $this->getDoctrine()
            ->getRepository(MovieAward::class)
            ->find($awardId);

        $form = $this->createForm(MovieAwardType::class, $movieAward);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $movieAward = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($movieAward);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.movies.awards', [
            'movieId' => $movieId,
        ]);
    }

    /**
     * Remove an award categry
     *
     * @Route("/admin/movies/{movieId}/awards/remove}", name="admin.movies.awards.actions.remove", methods={"POST"})
     */
    public function remove(string $awardId, string $movieId)
    {
        $movieAward = $this->getDoctrine()
            ->getRepository(MovieAward::class)
            ->find($awardId);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($movieAward);
        $entityManager->flush();

        return $this->redirectToRoute('admin.movies.awards', [
            'movieId' => $movieId,
        ]);
    }
}
