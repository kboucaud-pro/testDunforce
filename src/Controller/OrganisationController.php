<?php

namespace App\Controller;

use App\Entity\Organization;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\OrganisationManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class OrganisationController extends AbstractController
{

    /**
     * @Route("/")
     */

    public function index(OrganisationManager $organisationManager)
    {
        $organisations = $organisationManager->getOrganizations();
        if ($organisations == null)
            return $this->render('notFound.twig');
        return $this->render('organisations.twig', [
            'organisations' => $organisations
        ]);
    }

    /**
     * @Route("/organization/{slug}", name="organization_info")
     */

    public function organizationInfo(string $slug, Request $request, OrganisationManager $organisationManager)
    {
        $fileOrganisation = $organisationManager->getOrganizations($slug);
        if ($fileOrganisation == null)
            return $this->render('notFound.twig');

        if ($request->isMethod('POST')){
            $organisationManager->updateOrganizations($request->request->all());
        }
        return $this->render('organization_info.twig', [
            'organization_name' => $slug,
            'organization' => $fileOrganisation
        ]);
    }
}
