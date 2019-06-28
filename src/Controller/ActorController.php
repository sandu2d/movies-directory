<?php

namespace App\Controller;

use App\Entity\Actor;
use App\Form\ActorType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ActorController extends AbstractController
{
    /**
     * Create a movie
     *
     * @param Request $request
     *
     * @Route("/admin/actors/create", name="admin.actors.actions.create", methods={"POST"})
     */
    public function create(Request $request)
    {
        $actor = new Actor();
        $form = $this->createForm(ActorType::class, $actor);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $actor = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($actor);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.actors');
    }

    /**
     * Create a movie
     *
     * @param Request $request
     *
     * @Route("/admin/actors/edit/{actorId}", name="admin.actors.actions.edit", methods={"POST"})
     */
    public function edit(string $actorId, Request $request)
    {
        $actor = $this->getDoctrine()
            ->getRepository(Actor::class)
            ->find($actorId);

        $form = $this->createForm(ActorType::class, $actor);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $actor = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($actor);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.actors');
    }
}
