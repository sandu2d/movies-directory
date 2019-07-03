<?php

namespace App\Controller;

use App\Entity\Director;
use App\Form\DirectorType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DirectorController extends AbstractController
{
    /**
     * Create a director
     *
     * @param Request $request
     *
     * @Route("/admin/directors/create", name="admin.directors.actions.create", methods={"POST"})
     */
    public function create(Request $request)
    {
        $director = new Director();
        $form = $this->createForm(DirectorType::class, $director);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $director = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($director);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.directors');
    }

    /**
     * Edit a director
     *
     * @Route("/admin/directors/edit/{directorId}", name="admin.directors.actions.edit", methods={"POST"})
     */
    public function edit(Request $request, string $directorId)
    {
        $director = $this->getDoctrine()
            ->getRepository(Director::class)
            ->find($directorId);

        $form = $this->createForm(DirectorType::class, $director);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $director = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($director);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.directors');
    }

    /**
     * Remove a director
     *
     * @param string $directorId
     *
     * @Route("/admin/directors/remove/{directorId}", name="admin.directors.actions.remove", methods={"POST"})
     */
    public function remove(string $directorId)
    {
        $director = $this->getDoctrine()
            ->getRepository(Director::class)
            ->find($directorId);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($director);
        $entityManager->flush();

        return $this->redirectToRoute('admin.directors');
    }
}
