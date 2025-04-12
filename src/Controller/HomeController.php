<?php 
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class HomeController
{
    #[Route('/home', name:'home')]
    public function homeAction(): Response
    {
        $valor = "Pagina principal";
        return new Response(
            '<html><body style="font-family: sans-serif;">
                        <h1  style="color: green;">'.$valor.' 🇦🇷 </h1>
            <body><html>'
        );
    }
}
