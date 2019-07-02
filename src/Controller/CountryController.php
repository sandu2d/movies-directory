<?php

namespace App\Controller;

use App\Entity\Country;
use App\Form\CountryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CountryController extends AbstractController
{
    /**
     * Create a country
     *
     * @param Request $request
     *
     * @Route("/admin/countries/create", name="admin.countries.actions.create", methods={"POST"})
     */
    public function create(Request $request)
    {
        $country = new Country();
        $form = $this->createForm(CountryType::class, $country);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $country = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($country);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.countries');
    }

    /**
     * Edit a country
     *
     * @param Request $request
     *
     * @Route("/admin/countries/edit/{countryId}", name="admin.countries.actions.edit", methods={"POST"})
     */
    public function edit(Request $request, string $countryId)
    {
        $country = $this->getDoctrine()
            ->getRepository(Country::class)
            ->find($countryId);

        $form = $this->createForm(CountryType::class, $country);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $country = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($country);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.countries');
    }

    /**
     * Remove a country
     *
     * @param string $countryId
     *
     * @Route("/admin/countries/remove/{countryId}", name="admin.countries.actions.remove", methods={"POST"})
     */
    public function remove(string $countryId)
    {
        $country = $this->getDoctrine()
            ->getRepository(Country::class)
            ->find($countryId);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($country);
        $entityManager->flush();

        return $this->redirectToRoute('admin.countries');
    }
}
