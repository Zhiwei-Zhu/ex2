<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Series;
use App\Form\CategoriesType;
use App\Form\SerieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CategoriesController extends AbstractController
{
    /**
     * @Route("/", name="categories")
     */
    public function index(EntityManagerInterface $entityManager, Request $request)
    {
        $categories= new  Categories();

        $form = $this->createForm(CategoriesType::class, $categories);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $categorie= $form->getData();

            $entityManager->persist($categorie);
            $entityManager->flush();
        }

        $SerieRepo = $this->getDoctrine()
                ->getRepository(Series::class)
                ->findAll();

        $CategorieRepo = $this->getDoctrine()
            ->getRepository(Categories::class)
            ->findAll();

        return $this->render('categories/index.html.twig', [
            'controller_name' => 'CategoriesController',
            'series'=> $SerieRepo,
            'categories'=>$CategorieRepo,
            'form'=>$form->createView(),
        ]);
    }
    /**
     * @Route("/remove/{id}", name="remove1")
     */
    public function remove1($id, EntityManagerInterface $entityManager){
        $categorie = $this->getDoctrine()->getRepository(Categories::class)->find($id);

        $entityManager->remove($categorie);
        $entityManager->flush();

        return $this->redirectToRoute('categories');
    }

    /**
     * @Route("/series", name="series")
     */
    public function series(EntityManagerInterface $entityManager , Request $request)
    {
        $serie= new Series();

        $SerieRepo = $this->getDoctrine()
            ->getRepository(Series::class)
            ->findAll();

        $form=$this->createForm(SerieType::class, $serie);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $serie= $form->getData();
            $image = $serie->getAffiche();


            $imageName = md5(uniqid()).'.'.$image->guessExtension();

            $image->move($this->getParameter('upload_files'),$imageName);
            $serie ->setAffiche($imageName);

            $entityManager->persist($serie);
            $entityManager->flush();
        }


        return $this->render('categories/series.html.twig', [
            'controller_name' => 'CategoriesController',
            'form'=> $form->createView(),
            'series'=>$SerieRepo,
        ]);
    }
    /**
     * @Route("/categories/{id}", name="categorie")
     */
    public function categorie($id,Request $request, EntityManagerInterface $entityManager)
    {

        $series = $this->getDoctrine()
            ->getRepository(Series::class)->findBy(['categorie'=>['id'=>$id]]);
        $categorie = $this->getDoctrine()
            ->getRepository(Categories::class)->find($id);


        $form = $this->createForm(CategoriesType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $categorie= $form->getData();

            $entityManager->persist($categorie);
            $entityManager->flush();
        }

        return $this->render('categories/categorie.html.twig', [
            'controller_name' => 'CategoriesController',
            'form'=>$form->createView(),
            'categorie'=>$categorie,
            'series'=>$series,
        ]);
    }
    /**
     * @Route("/serie/{id}", name="serie")
     */
    public function serie($id,Request $request, EntityManagerInterface $entityManager)
    {

        $series = $this->getDoctrine()
            ->getRepository(Series::class)->find($id);


        if (!is_null($series->getAffiche())) {
            $series->setAffiche(new File($this->getParameter('upload_files').'/'.$series->getAffiche()));
        }

        $form = $this->createForm(SerieType::class, $series);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $serie= $form->getData();

            $image = $serie->getAffiche();
            $imageName = md5(uniqid()).'.'.$image->guessExtension();
            $image->move($this->getParameter('upload_files') ,
                $imageName);
            $serie ->setAffiche($imageName);

            $entityManager->persist($serie);
            $entityManager->flush();

            $this->redirectToRoute('series');
        }


        return $this->render('categories/serie.html.twig', [
            'controller_name' => 'CategoriesController',
            'form' => $form->createView(),
            'serie'=>$series,
        ]);
    }
    /**
     * @Route("/serie/remove/{id}", name="remove")
     */
    public function remove($id, EntityManagerInterface $entityManager){
        $serie = $this->getDoctrine()->getRepository(Series::class)->find($id);

        $entityManager->remove($serie);
        $entityManager->flush();

        return $this->redirectToRoute('categories');
    }

}
