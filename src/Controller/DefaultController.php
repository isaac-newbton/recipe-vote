<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController {

    /**
     * @Route("/", name="index")
     */
    public function index() : Response {
        return $this->render('home.html.twig', [

        ]);
    }

    /**
     * @Route("/enter", name="enter")
     */
    public function enter() : Response {
        return $this->render('enter-recipe.html.twig', [

        ]);
    }

    /**
     * @Route("/rules", name="rules")
     */
    public function rules() : Response {
        return $this->render('rules.html.twig', [

        ]);
    }

    /**
     * @Route("/recipe", name="recipe")
     */
    public function recipe() : Response {
        return $this->render('view-recipe.html.twig', [

        ]);
    }
}