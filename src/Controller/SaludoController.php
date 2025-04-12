<?php 
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;


class SaludoController extends AbstractController
{
    #[Route('/bienvenido/{nombre}', name:'bienvenido')]
    public function bienvenidoAction(string $nombre): Response
    {
        $saludo = "Bienvenido al sitio, ";
        return new Response(
            '<html><body><h1>'.$saludo.$nombre.'🙂 </h1>
            </body></html>'
        );
    }

    #[Route('/bienvenido/estado/{nombre}/{estado}', name:'bienvenido_estado')]
    public function bienvenidoEstadoAction(string $nombre, string $estado): Response
    {
        return new Response(
            "<h1>Hola $nombre, hoy estás $estado 😃 </h1>"
        );
    }

    #[Route('/despedida/{nombre}', name:'despedida')]
    public function despedidaAction(string $nombre): Response
    {
        $saludo = "Hasta luego, ";
        return new Response( 
            '<html><body style="font-family: sans-serif;">
                    <h1 style="color: darkblue;">😆  Hasta luego, '.$nombre.'</h1>
                    </body>
            </html>'
        );
    }


    #[Route('/azar/{numero}', name: 'juego_azar')]
    public function juegoAzar(int $numero): Response
    {
        $numeroUsuario = $numero; // El número que el usuario ingresó en la URL
        $numeroGanador = rand(1, 2); // Generamos un número ganador aleatorio entre 1 y 100
        $mensaje = '';

        if ($numeroUsuario === $numeroGanador) {
            $mensaje = "¡Felicidades! Tu número ($numeroUsuario) coincide con el número ganador ($numeroGanador). ¡Has ganado!";
        } elseif (abs($numeroUsuario - $numeroGanador) <= 5) {
            $mensaje = "¡Casi! Tu número ($numeroUsuario) estuvo cerca del número ganador ($numeroGanador). ¡Sigue intentando!";
        } else {
            $mensaje = "Lo siento, tu número ($numeroUsuario) no coincide con el número ganador ($numeroGanador). ¡Inténtalo de nuevo!";
        }

        return new Response("<h1>Resultado del juego:</h1><p>$mensaje</p>");
    }


    //Usamos una plantilla para mostrar datos, una vez que extendemos de abstract
    #[Route('/renderizado/{nombre}', name:'renderizado')]
    public function renderizadoAction(string $nombre): Response
    {
        $saludo = "Estamos mostrando la información dentro de una plantilla Twig, ";
        $personajes = [
            'Mario ',
            'Luigi',
            'Link',
            'Samus',
            'Kirby',
            'Pikachu'
        ];
        
        return $this->render('renderizado.html.twig', [
            'nombre' => $nombre,
            'saludo' => $saludo,
            'personajes' => $personajes
        ]);
    }


    #[Route('/saludo/form', name: 'form_saludo', methods: ['GET', 'POST'])]
    public function saludoForm(Request $request): Response
    {

        if ($request){
            dump($request);die;
        }
        
        if ($request->isMethod('POST')) {
            $nombre = $request->request->get('nombre');
            $apellido = $request->request->get('apellido');

            return new Response("<h1>¡Hola, $nombre $apellido!</h1>");
        }

        return new Response('
            <form method="POST">
                <label>Nombre: <input name="nombre" /></label><br>
                <label>Apellido: <input name="apellido" /></label><br>
                <button type="submit">Saludar</button>
            </form>
        ');
    }

    #[Route('/api/datos', name: 'api_datos', methods: ['GET'])]
    public function datos(): Response
    {
        $datos = [
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'edad' => 30,
        ];
        return $this->json($datos);
    }




    #[Route('/blog/{page}', name: 'blog_list', requirements: ['page' => '\d+'])]
    public function listAction(int $page = 1): Response
    {
        return new Response(
            "<html><body><h1>Mostrando la página $page del blog</h1></body></html>"
        );
    }
    // URL	    Resultado
    // -----    ----------
    // /blog	Mostrando la página 1 del blog
    // /blog/5	Mostrando la página 5 del blog
    // /blog/abc	Error 404 (no cumple el requisito de número)


    #[Route('/blogDos/{page?}', name: 'blogDos_list')]
    public function listDosAction(?int $page): Response
    {
        if ($page === null) {
            $page = 1;
        }
        return new Response("<h1>Blog - Página $page</h1>");
    }

}









//el problema aquí se encuentra en que si modificamos con el tiempo la ruta, deja de servir
// el enlace, una por eso lo ideal sería usar uno de los métodos abstract para usar rutas amigalbes

//<a href="/bienvenido/hola">Ir a Bienvenida</a>

//$urlDespedida = $this->generateUrl('despedida', ['nombre' => $nombre]);

// #[Route('/bienvenido/{nombre}', name:'bienvenido')]
// public function bienvenidoAction(string $nombre): Response
// {
//     $urlHome= $this->generateUrl('home');
//     $saludo = "Bienvenido, ";
//     return new Response(
//         '<html><body><h1>'.$saludo.$nombre.'</h1>'.
//         '<p><a href="'.$urlHome.'">Ir a home </a></p>'.
//         '</body></html>'
//     );
// }
