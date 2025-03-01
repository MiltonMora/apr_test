<?php

namespace App\Spaces\Controller;

use App\AbstractGeneralController;
use App\Spaces\Application\Command\SpacesCreate;
use App\Spaces\Application\Command\SpacesList;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

#[Route('/dashboard/spaces')]
class Controller extends AbstractGeneralController
{
    #[Route('/list', name: 'spaces_list', methods: ['GET'])]
    public function list(Request $request): Response
    {
        $data = $this->commandBus->handle(new SpacesList());
        return $this->render('Spaces/Spaces.html.twig', ['spaces' => $data]);
    }

    #[Route('/create', name: 'space_create', methods: ['POST'])]
    public function create(Request $request): RedirectResponse
    {
        $this->commandBus->handle(new SpacesCreate(
            $request->request->get('space_name')
        ));
        $this->addFlash('success', 'Espacio creado con éxito.');

        return $this->redirectToRoute('spaces_list');

    }
}
