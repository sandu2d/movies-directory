<?php

namespace App\Controller;

use App\Entity\Language;
use App\Form\LanguageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LanguageController extends AbstractController
{
    /**
     * Create a language
     *
     * @param Request $request
     *
     * @Route("/admin/languages/create", name="admin.languages.actions.create", methods={"POST"})
     */
    public function create(Request $request)
    {
        $lang = new Language();
        $form = $this->createForm(LanguageType::class, $lang);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lang = $form->getData();

            $lang->setName(strtoupper($lang->getName()));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($lang);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.languages');
    }

    /**
     * Edit a language
     *
     * @param Request $request
     *
     * @Route("/admin/languages/edit/{langId}", name="admin.languages.actions.edit", methods={"POST"})
     */
    public function edit(Request $request, string $langId)
    {
        $lang = $this->getDoctrine()
            ->getRepository(Language::class)
            ->find($langId);

        $form = $this->createForm(LanguageType::class, $lang);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lang = $form->getData();

            $lang->setName(strtoupper($lang->getName()));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($lang);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.languages');
    }

    /**
     * Remove a language
     *
     * @param string $langId
     *
     * @Route("/admin/languages/remove/{langId}", name="admin.languages.actions.remove", methods={"POST"})
     */
    public function remove(string $langId)
    {
        $lang = $this->getDoctrine()
            ->getRepository(Language::class)
            ->find($langId);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($lang);
        $entityManager->flush();

        return $this->redirectToRoute('admin.languages');
    }
}
