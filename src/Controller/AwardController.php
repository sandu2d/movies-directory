<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Award;
use App\Form\AwardType;
use Symfony\Component\HttpFoundation\Request;

class AwardController extends AbstractController
{
    /**
     * Create an award
     *
     * @param Request $request
     *
     * @Route("/admin/awards/create", name="admin.awards.actions.create", methods={"POST"})
     */
    public function create(Request $request)
    {
        $award = new Award();
        $form = $this->createForm(AwardType::class, $award);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $award = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($award);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.awards');
    }

    /**
     * Edit an award
     *
     * @param Request $request
     *
     * @Route("/admin/awards/edit/{awardId}", name="admin.awards.actions.edit", methods={"POST"})
     */
    public function edit(Request $request, string $awardId)
    {
        $award = $this->getDoctrine()
            ->getRepository(Award::class)
            ->find($awardId);

        $form = $this->createForm(AwardType::class, $award);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $award = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($award);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.awards');
    }

    /**
     * Remove an award
     *
     * @param string $awardId
     *
     * @Route("/admin/awards/remove/{awardId}", name="admin.awards.actions.remove", methods={"POST"})
     */
    public function remove(string $awardId)
    {
        $award = $this->getDoctrine()
            ->getRepository(Award::class)
            ->find($awardId);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($award);
        $entityManager->flush();

        return $this->redirectToRoute('admin.awards');
    }
}
