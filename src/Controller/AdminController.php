<?php
namespace App\Controller;

use App\Repository\RecipeRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController {
    /**
     * @Route("/admin/recipes/{filter?pending}/{published?}", name="admin_recipes")
     */
    public function recipes(Request $request, RecipeRepository $recipeRepository, string $filter, $published = null) : Response {
        $criteria = [];
        $order = [];
        if($filter==='pending'){
            $criteria['published'] = null;
        }
        if($filter==='published'){
            $criteria['published'] = true;
        }
        if($filter==='denied'){
            $criteria['published'] = false;
        }
        $recipes = $recipeRepository->findBy($criteria, $order);
        $recipe = false;
        if($published){
            $recipe = $recipeRepository->findOneBy([
                'uuid'=>$published
            ]);
        }
        return $this->render('admin/recipes.html.twig', [
            'recipes'=>$recipes,
            'published'=>$recipe,
            'filter'=>$filter
        ]);
    }

    /**
     * @Route("/admin/preview/{uuid}", name="admin_preview_recipe")
     */
    public function recipe(Request $request, string $uuid, RecipeRepository $recipeRepository) : Response {
        $recipe = $recipeRepository->findOneBy([
            'uuid'=>$uuid
        ]);
        return $this->render('admin/recipe-preview.html.twig', [
            'recipe'=>$recipe
        ]);
    }

    /**
     * @Route("/admin/approve/{uuid}", name="admin_approve_recipe")
     */
    public function approve(Request $request, string $uuid, RecipeRepository $recipeRepository, MailerInterface $mailer) : Response {
        $recipe = $recipeRepository->findOneBy([
            'uuid' => $uuid
        ]);
        if($recipe){
            $manager = $this->getDoctrine()->getManager();
            $recipe->setPublished(true);
            $manager->persist($recipe);
            $manager->flush();
            try{
                $toAddress = $recipe->getEntryEmail();
                $email = (new TemplatedEmail())
                    ->to($toAddress)
                    ->subject('Your Cheesesteak Day Recipe Is Approved!')
                    ->htmlTemplate('email/recipe-approved.html.twig')
                    ->context([
                        'recipe'=>$recipe
                    ])
                ;
                $mailer->send($email);
            }catch(TransportException $e){
                
            }
        }
        return $this->redirectToRoute('admin_recipes', [
            'filter'=>'pending',
            'published'=>$recipe ? $recipe->getUuid() : ''
        ]);
    }

    /**
     * @Route("/admin/deny/{uuid}", name="admin_deny_recipe")
     */
    public function deny(Request $request, string $uuid, RecipeRepository $recipeRepository, MailerInterface $mailer) : Response {
        $recipe = $recipeRepository->findOneBy([
            'uuid' => $uuid
        ]);
        if($recipe){
            $manager = $this->getDoctrine()->getManager();
            $recipe->setPublished(false);
            $manager->persist($recipe);
            $manager->flush();

            try{
                $toAddress = $recipe->getEntryEmail();
                $email = (new TemplatedEmail())
                    ->to($toAddress)
                    ->subject('Your Cheesesteak Day Recipe Was Denied')
                    ->htmlTemplate('email/recipe-denied.html.twig')
                    ->context([
                        'recipe'=>$recipe
                    ])
                ;
                $mailer->send($email);
            }catch(TransportException $e){
                
            }
        }
        return $this->redirectToRoute('admin_recipes', [
            'filter'=>'pending'
        ]);
    }
}