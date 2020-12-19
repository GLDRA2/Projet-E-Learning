<?php

namespace App\Controller;

use App\Entity\Cour;
use App\Entity\Groupe;
use App\Form\CourType;
use App\Repository\CourRepository;
use App\Repository\GroupeRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/cour")
 */
class CourController extends AbstractController
{
    /**
     * @Route("/", name="cour_index", methods={"GET"})
     */
    public function index(CourRepository $courRepository): Response
    {
        return $this->render('cour/index.html.twig', [
            'cours' => $courRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="cour_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $cour = new Cour();
        $groupe = new Groupe();
        $user = $this->getUser();
        $form = $this->createForm(CourType::class, $cour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $fileimage = $cour->getImage();
            $fileName = md5(uniqid()).".".$fileimage->guessExtension();
            $fileimage->move($this->getParameter('upload_directory'), $fileName);
            
            $cour->setImage($fileName);
            $cour->setUser($user);

            $groupe->setName($cour->getName());
            $groupe->setCours($cour);
            $groupe->setPassword($cour->getName());
            $groupe->addUser($user);
            
            $entityManager->persist($cour);
            $entityManager->persist($groupe);
            $entityManager->flush();

            return $this->redirectToRoute('cour_index');
        }

        return $this->render('cour/new.html.twig', [
            'cour' => $cour,
            'form' => $form->createView(),
        ]);
    }

      /**
     * @Route("/{id}", name="cour_show", methods={"GET"})
     */
    public function show(Cour $cour): Response
    {
        return $this->render('cour/show.html.twig', [
            'cour' => $cour,
        ]);
    }


    /**
     * @Route("/{id}/edit", name="cour_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Cour $cour): Response
    {
        $form = $this->createForm(CourType::class, $cour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $cour->getImage();
            $cour->setImage($file);
            $groupe = $cour->getGroupe();
            $this->getDoctrine()->getManager()->flush();
           

           return $this->redirectToRoute('groupe_show', [
            'id' => $groupe->getId(),
            ]);
        }

        return $this->render('cour/edit.html.twig', [
            'cour' => $cour,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cour_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Cour $cour): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cour->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cour);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cour_index');
    }
    
}
