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
        $result = 'ACCESSING';

        if ($request->isMethod('POST')) {
            $result = $organisationManager->updateOrganizations($request->request->all());
        }

        if ($result == 'CREATED') {
            if ($result == 'CREATED')
                $this->addFlash('success', 'Organization successfully created');
            return $this->render('organisations.twig', [
                'organisations' => $organisationManager->getOrganizations()
            ]);
        } else if ($result == 'UPDATED' || $result == 'ACCESSING') {
            $fileOrganisation = $organisationManager->getOrganizations($slug);
            if ($fileOrganisation == null)
                return $this->render('notFound.twig');
            if ($result == 'UPDATED')
                $this->addFlash('success', 'Organization successfully updated');
            return $this->render('organization_info.twig', [
                'organization_name' => $slug,
                'organization' => $fileOrganisation
            ]);
        }
    }

    /**
     * @Route("/deleteOrganization/{slug}", name="deleteOrganization")
     */

    public function deleteOrganization($slug, OrganisationManager $organisationManager, Request $request)
    {
        dump($request->isMethod('POST'));
        if ($request->isMethod('POST')) {
            $result = $organisationManager->deleteOrganization($slug);
            if ($result) {
                $this->addFlash('success', "Organization deleted successfully");
            } else {
                $this->addFlash('error', 'Organization doesnt exist');
            }
            return $this->render('organisations.twig', [
                'organisations' => $organisationManager->getOrganizations()
            ]);
        }
        return $this->render('notFound.twig');
    }
}
