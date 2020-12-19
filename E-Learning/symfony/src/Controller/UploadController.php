<?php

namespace App\Controller;

use App\Entity\Cour;
use App\Entity\Upload;
use App\Form\UploadType;
use App\Repository\UploadRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/upload")
 */
class UploadController extends AbstractController
{
    /**
     * @Route("/", name="upload_index", methods={"GET"})
     */
    public function index(UploadRepository $uploadRepository): Response
    {
        return $this->render('upload/index.html.twig', [
            'uploads' => $uploadRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="upload_new", methods={"GET","POST","PUT"})
     */
    public function new(Request $request, Cour $cour): Response
    {
        $upload = new Upload();
        $user = $this->getUser();
        $form = $this->createForm(UploadType::class, $upload);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $filepdf = $upload->getFilePdf();
            if (!is_null($filepdf)) {
                $fileName = md5(uniqid()).".".$filepdf->guessExtension();
                $filepdf->move($this->getParameter('upload_directory'), $fileName);
                $upload->setFilePdf($fileName);
            }
            
            $upload->setUser($user);
            $upload->setCour($cour);
            $entityManager->persist($upload);
            $entityManager->flush();

               return $this->redirectToRoute('groupe_show', [
            'id' => $cour->getGroupe()->getId(),
            ]);
        }

        return $this->render('upload/new.html.twig', [
            'upload' => $upload,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="upload_show", methods={"GET"})
     */
    public function show(Upload $upload): Response
    {
        return $this->render('upload/show.html.twig', [
            'upload' => $upload,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="upload_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Upload $upload): Response
    {
        $form = $this->createForm(UploadType::class, $upload);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('upload_index');
        }

        return $this->render('upload/edit.html.twig', [
            'upload' => $upload,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="upload_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Upload $upload): Response
    {
        if ($this->isCsrfTokenValid('delete'.$upload->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($upload);
            $entityManager->flush();
        }

        return $this->redirectToRoute('upload_index');
    }

}
