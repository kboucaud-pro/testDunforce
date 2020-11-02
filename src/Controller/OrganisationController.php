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
        $organisations = $organisationManager->getInfos();
        if ($organisations == null)
            return $this->render('notFound.twig');
        return $this->render('organisations.twig', [
            'organisations' => $organisations
        ]);
    }

    /**
     * @Route("/organization/update", name="organization_update")
     */

    public function updateInfo(Request $request, OrganisationManager $organisationManager)
    {
        if ($request->isMethod('POST')){
            dump($request->request);
            return $this->render('notFound.twig');
        }
    }

    /**
     * @Route("/organization/{slug}", name="organization_info")
     */

    public function organizationInfo(string $slug, OrganisationManager $organisationManager)
    {
        $fileOrganisation = $organisationManager->getInfos($slug);
        if ($fileOrganisation == null)
            return $this->render('notFound.twig');

        return $this->render('organization_info.twig', [
            'organization_name' => $slug,
            'organization' => $fileOrganisation
        ]);
    }
}
