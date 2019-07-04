<?php

namespace App\Controller;

use App\Entity\AwardCategory;
use App\Form\AwardCategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AwardCategoryController extends AbstractController
{
    /**
     * Create an award category
     *
     * @param Request $request
     *
     * @Route("/admin/awardscategory/create", name="admin.awardscategory.actions.create", methods={"POST"})
     */
    public function create(Request $request)
    {
        $awardscategory = new AwardCategory();
        $form = $this->createForm(AwardCategoryType::class, $awardscategory);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $awardscategory = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($awardscategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.awardscategory');
    }

    /**
     * Edit an award category
     *
     * @Route("/admin/awardscategory/edit/{awardscategoryId}", name="admin.awardscategory.actions.edit", methods={"POST"})
     */
    public function edit(Request $request, string $awardscategoryId)
    {
        $awardscategory = $this->getDoctrine()
            ->getRepository(AwardCategory::class)
            ->find($awardscategoryId);

        $form = $this->createForm(AwardCategoryType::class, $awardscategory);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $awardscategory = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($awardscategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.awardscategory');
    }

    /**
     * Remove an award categry
     *
     * @param string $awardscategoryId
     *
     * @Route("/admin/awardscategory/remove/{awardscategoryId}", name="admin.awardscategory.actions.remove", methods={"POST"})
     */
    public function remove(string $awardscategoryId)
    {
        $awardscategory = $this->getDoctrine()
            ->getRepository(AwardCategory::class)
            ->find($awardscategoryId);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($awardscategory);
        $entityManager->flush();

        return $this->redirectToRoute('admin.awardscategory');
    }
}
