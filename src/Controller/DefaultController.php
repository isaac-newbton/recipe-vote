<?php
namespace App\Controller;

use App\Entity\MediaFile;
use App\Entity\Recipe;
use App\Entity\RecipeVote;
use App\Form\RecipeType;
use App\Form\RecipeVoteType;
use App\Repository\RecipeRepository;
use App\Repository\RecipeVoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class DefaultController extends AbstractController {

    /**
     * @Route("/", name="index")
     */
    public function index() : Response {
        return $this->render('home.html.twig', [

        ]);
    }

    /**
     * @Route("/recipe", name="enter")
     */
    public function enter(Request $request, SluggerInterface $slugger) : Response {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $recipe = $form->getData();
            /** @var UploadedFile $uploadedFile */
            $file = $form->get('mainImage')->getData();
            $mediaFile = new MediaFile();
            $manager = $this->getDoctrine()->getManager();
            if($file){
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();
                $path = $this->getParameter('app.mediafiles_base_directory') . DIRECTORY_SEPARATOR . (string)date('Y') . DIRECTORY_SEPARATOR . (string)date('m');
                $mimeType = $file->getMimeType();
                try{
                    $file->move(
                        $this->getParameter('kernel.project_dir') . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . $path,
                        $newFilename
                    );
                }catch(FileException $e){

                }
                $mediaFile->setTitle($form->get('title')->getData());
                $mediaFile->setAltText($form->get('title')->getData());
                $mediaFile->setPath($path . DIRECTORY_SEPARATOR . $newFilename);
                $mediaFile->setName($newFilename);
                $mediaFile->setMimeType($mimeType);
                $manager->persist($mediaFile);
                $manager->flush();
            }
            $recipe->setMainImage($mediaFile);
            $manager->persist($recipe);
            $manager->flush();
            return $this->redirectToRoute('recipe_pending', [
                'uuid'=>$recipe->getUuid()
            ]);
        }

        return $this->render('enter-recipe.html.twig', [
            'form'=>$form->createView()
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
     * @Route("/privacy", name="privacy")
     */
    public function privacy() : Response {
        return $this->render('privacy.html.twig', [

        ]);
    }

    /**
     * @Route("/recipe/{uuid}", name="recipe_view")
     */
    public function recipe(Request $request, string $uuid, RecipeRepository $recipeRepository, RecipeVoteRepository $recipeVoteRepository) : Response {
        $recipe = $recipeRepository->findOneBy([
            'uuid'=>$uuid
        ]);
        if(!$recipe){
            return $this->createNotFoundException('Recipe not found');
        }
        $voted = false;
        $allowed = false;
        $vote = new RecipeVote();
        $form = $this->createForm(RecipeVoteType::class, $vote);
        $form->handleRequest($request);
        if(!$voted && $form->isSubmitted() && $form->isValid()){
            $vote = $form->getData();
            $vote->setRecipe($recipe);
            $votesToday = $recipeVoteRepository->findByEmailToday($vote->getVoterEmail());
            $allowed = !($votesToday);
            if($allowed){
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($vote);
                $manager->flush();
            }
            $voted = true;
        }
        return $this->render('view-recipe.html.twig', [
            'recipe'=>$recipe,
            'form'=>$form->createView(),
            'voted'=>$voted,
            'allowed'=>$allowed
        ]);
    }

    /**
     * @Route("/pending/{uuid}", name="recipe_pending")
     */
    public function pending(string $uuid, RecipeRepository $recipeRepository) : Response {
        $recipe = $recipeRepository->findOneBy([
            'uuid'=>$uuid
        ]);
        if(!$recipe){
            return $this->createNotFoundException('Recipe not found');
        }
        return $this->render('pending-recipe.html.twig', [
            'recipe'=>$recipe
        ]);
    }
}