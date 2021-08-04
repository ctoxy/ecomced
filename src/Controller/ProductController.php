<?php

namespace App\Controller;
use App\Entity\Product;
use App\Classe\Search;
use App\Form\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ProductController extends AbstractController
{
    //instanciation du contructeur doctrine entitymanager
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager=$entityManager;
    }
    /**
     * @Route("/product", name="products")
     */
    public function index(Request $request): Response
    {
        
        //console log
        //dd($products);
        /*instanciation class SEARCH */
        $search = new Search();
        /*instanciation du formulaire  Search*/
        $form = $this->createForm(SearchType::class,$search);

        //passage des parametre de search
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // non util $search = $form->getData();
            //console log
            //dd($search);
            //recuperation des des products via les critere search repository
        $products = $this->entityManager->getRepository(Product::class)->findWithSearch($search);
        } else {
            //recuperation de tout les products via le repository
            $products = $this->entityManager->getRepository(Product::class)->findAll();
        }
        return $this->render('product/index.html.twig',[
            //affichage de tout les produits
            'products'=>$products,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/produit/{slug}", name="product")
     */
    public function show($slug): Response
    {
        //recuperation de un products via le repository et son slug
        $product = $this->entityManager->getRepository(Product::class)->findOneBy(['slug' => $slug]);
        // si le slug n existe pas redirection
        if (!$product) {
            return $this->redirectToRoute('products');
        }
        //console log
        //dd($products);
        return $this->render('product/show.html.twig',[
            //affichage de un produit par slug
            'product'=>$product
        ]);
    }
}
