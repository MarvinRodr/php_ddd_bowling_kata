<?php

declare(strict_types=1);

namespace App\Controller\WEB\Home;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final class GetHomeController
{
    public function __construct(private readonly Environment $twig)
    {
    }

    public function __invoke(Request $request): Response
    {
        return new Response($this->twig->render('home/index.html.twig'));
    }
}
