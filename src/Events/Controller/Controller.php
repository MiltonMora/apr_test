<?php

namespace App\Events\Controller;

use App\AbstractGeneralController;
use App\Events\Application\Command\EventCancel;
use App\Events\Application\Command\EventCreate;
use App\Events\Application\Command\EventEdit;
use App\Events\Application\Command\EventList;
use App\Spaces\Application\Command\SpacesList;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

#[Route('/dashboard/event')]
class Controller extends AbstractGeneralController
{
    #[Route('/list', name: 'events_list', methods: ['GET'])]
    public function list(Request $request): Response
    {
        $data['events'] = $this->commandBus->handle(new EventList());
        $data['spaces'] = $this->commandBus->handle(new SpacesList());
        return $this->render('Events/Dashboard.html.twig',
            [
                'events' => $data['events'],
                'spaces' => $data['spaces']
            ]
        );
    }

    #[Route('/create', name: 'event_create', methods: ['POST'])]
    public function create(Request $request): RedirectResponse
    {
        try {
            $this->commandBus->handle(new EventCreate(
                $request->request->get('event_name'),
                $request->request->get('event_space'),
                new \DateTime($request->request->get('start_datetime')),
                new \DateTime($request->request->get('end_datetime'))
            ));
            $this->addFlash('success', 'Evento creado con éxito.');
        } catch (BadRequestHttpException $e) {
            return $this->verifyErrors($e, $request);
        }

        return $this->redirectToRoute('spaces_list');

    }

    #[Route('/edit', name: 'event_edit', methods: ['POST'])]
    public function edit(Request $request): RedirectResponse
    {
        try {
            $this->commandBus->handle(new EventEdit(
                $request->request->get('event_id'),
                $request->request->get('event_name'),
                $request->request->get('event_space'),
                new \DateTime($request->request->get('start_datetime')),
                new \DateTime($request->request->get('end_datetime'))
            ));
            $this->addFlash('success', 'Evento Editado con éxito.');
        } catch (BadRequestHttpException $e) {
            return $this->verifyErrors($e, $request);
        }

        return $this->redirectToRoute('spaces_list');

    }

    #[Route('/cancel', name: 'event_cancel', methods: ['POST'])]
    public function cancel(Request $request): RedirectResponse
    {
        try {
            $this->commandBus->handle(new EventCancel($request->request->get('event_id_detail')));
            $this->addFlash('success', 'Evento Cancelado con éxito.');
        } catch (BadRequestHttpException $e) {
            return $this->verifyErrors($e, $request);
        }

        return $this->redirectToRoute('spaces_list');

    }
    public function verifyErrors(\Exception|BadRequestHttpException $e, Request $request): RedirectResponse
    {
        $errors = json_decode($e->getMessage(), true);
        if (is_array($errors)) {
            foreach ($errors as $error) {
                if (is_array($error)) {
                    $error = implode(', ', $error);
                }
                $this->addFlash('error', $error);
            }
        } else {
            $this->addFlash('error', (string)$errors);
        }

        $referer = $request->headers->get('referer', $this->generateUrl('events_list'));
        return $this->redirect($referer);
    }
}
