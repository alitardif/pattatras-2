<?php

namespace App\Controller;

use App\Form\NumberFilterType;
use App\Service\PattatrasService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PattatrasController extends AbstractController
{
    #[Route('/', name: 'pattatras_index', methods: ['GET'])]
    public function index(Request $request, PattatrasService $pattatrasService): Response
    {
        $form = $this->createForm(NumberFilterType::class);
        $form->handleRequest($request);

        $filtered = false;

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var int $number */
            $number = $form->get('number')->getData();
            $results = $pattatrasService->generate($number, $number);
            $filtered = true;
        } else {
            $results = $pattatrasService->generate();
        }

        return $this->render('pattatras/index.html.twig', [
            'form' => $form,
            'results' => $results,
            'filtered' => $filtered,
            'start' => PattatrasService::DEFAULT_START,
            'end' => PattatrasService::DEFAULT_END,
        ]);
    }
}
