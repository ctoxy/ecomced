<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
// reference the Dompdf namespace
use Dompdf\Dompdf;
use Dompdf\Options;


class GenPdfController extends AbstractController
{
    protected $parameterBag;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;

    }
    /**
     * @Route("/genpdf", name="gen_pdf")
     */
    public function index(): Response
    {
        //options du document
        $options = new Options();
        $options->set('defaultFont','Courrier');
        //appel de la librairire dompdf avec passage des options
        $dompdf = new Dompdf($options);
        
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('gen_pdf/templatePdf.html.twig', [
            'title' => "Welcome to our PDF Test"
        ]);
        
        //mise en place de html via le buffer 
        $dompdf->loadHtml($html);
        //format du pdf
        $dompdf->setPaper('A4','portrait');

        // faire le rendu en cache
        $dompdf->render();

        // Store PDF Binary Data
        //$output = $dompdf->output();

        // In this case, we want to write the file in the public directory
        //$projectDir = $this->getParameter('kernel.project_dir');        

        // e.g /var/www/project/public/mypdf.pdf
        //$pdfFilepath =  $publicDirectory . '/mypdf.pdf';

        // Write file to the desired path
        //file_put_contents($pdfFilepath, $output);

        // Send some text response
        //return new Response("The PDF file has been succesfully generated !");
        //nommer le fichier pdf
        //$fichier = 'monpdftest.pdf';
        // rendu par le navigateur d'un pdf
        $dompdf->stream("mypdf.pdf", [
            //si false visualisable dans le navigateur
            "Attachmenet" => false
        ]);

        return $this->render('gen_pdf/index.html.twig');
    }
}
