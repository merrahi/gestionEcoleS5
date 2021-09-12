<?php

namespace App\Controller\Professeur;


use App\Entity\Professeur;
use App\Form\ProfesseurType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProfesseurController extends AbstractController
{
    /**
     * @Route("/professeur/all", name="professeur_all")
     */
    public function listAll(Request $request)
    {

        try{

            $professeurs = $this->getDoctrine()->getRepository(Professeur::class)->findAll();
            return $this->render('professeur/list.html.twig', [
                'numberProfesseur' => count($professeurs),
                'professeurs' => $professeurs
            ]);
        }  catch (DBALException $e) {
            $this->addFlash(
                'exception',
                sprintf('DBALException [%i]: %s', $e->getCode(), $e->getMessage())
            );
            //$message = sprintf('DBALException [%i]: %s', $e->getCode(), $e->getMessage());
        } catch (PDOException $e) {
            $this->addFlash(
                'exception',
                sprintf('PDOException [%i]: %s', $e->getCode(), $e->getMessage())
            );
            //$message = sprintf('PDOException [%i]: %s', $e->getCode(), $e->getMessage());
        } catch (ORMException $e) {
            $this->addFlash(
                'exception',
                sprintf('ORMException [%i]: %s', $e->getCode(), $e->getMessage())
            );
            //$message = sprintf('ORMException [%i]: %s', $e->getCode(), $e->getMessage());
        } catch (Exception $e) {
            $this->addFlash(
                'exception',
                sprintf('Exception [%i]: %s', $e->getCode(), $e->getMessage())
            );
            //$message = sprintf('Exception [%i]: %s', $e->getCode(), $e->getMessage());
        }
        return $this->render('error/error.html.twig');
    }

    /**
     * @Route("/professeur/details/{id}", name="professeur_details")
     */
    public function details(Professeur $id)
    {
        $professeur=$this->getDoctrine()
            ->getRepository(Professeur::class)
            ->find($id);



        // replace this example code with whatever you need
        return $this->render('professeur/details.html.twig', array("professeur"=>$professeur)

        );

    }

    /**
     * @Route("/professeur/create", name="professeur_create")
     */
    public function create(Request $request)
    {
        $professeur= new Professeur();
        $form = $this->createForm(ProfesseurType::class, $professeur);

        /*$form=$this->createFormBuilder($stg)
            ->add("firstname",TextType::class,array("attr"=>array("class"=>"form-control","style"=>"margin-bottom:15px")))
            ->add("lastname",TextType::class,array("attr"=>array("class"=>"form-control","style"=>"margin-bottom:15px")))
            ->add("username",TextType::class,array("attr"=>array("class"=>"form-control","style"=>"margin-bottom:15px")))
            ->add("save",SubmitType::class,array("label"=>"EDIT Stagiaire","attr"=>array("class"=>"btn btn-primary","style"=>"margin-bottom:15px")))
            ->getForm();*/
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $professeur = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($professeur);
            $entityManager->flush();
            $this->addFlash(
                "notice",
                'Professeur Created'
            );

            return $this->redirectToRoute('professeur_all');
        }
        // replace this example code with whatever you need
        return $this->render('professeur/create.html.twig', array(
            "form" => $form->createView()
        ));

    }

    /**
     * @Route("/professeur/edit/{id}", name="professeur_edit")
     */
    public function edit(Professeur $id, Request $request)
    {
        $professeur= $this->getDoctrine()->getRepository(Professeur::class)->find($id);
        $form = $this->createForm(ProfesseurType::class, $professeur);

        /*$form=$this->createFormBuilder($stg)
            ->add("firstname",TextType::class,array("attr"=>array("class"=>"form-control","style"=>"margin-bottom:15px")))
            ->add("lastname",TextType::class,array("attr"=>array("class"=>"form-control","style"=>"margin-bottom:15px")))
            ->add("username",TextType::class,array("attr"=>array("class"=>"form-control","style"=>"margin-bottom:15px")))
            ->add("save",SubmitType::class,array("label"=>"EDIT Stagiaire","attr"=>array("class"=>"btn btn-primary","style"=>"margin-bottom:15px")))
            ->getForm();*/
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //die("submited");
            //get data
            /* $fn=$form["firstname"]->getData();
             $ln=$form["lastname"]->getData();
             $un=$form["username"]->getData();

             $em=$this->getDoctrine()->getManager();
             $stg=$em->getRepository("AppBundle:Stagiaire")->find($id);
             $stg->setFirstName($fn);
             $stg->setLastName($ln);
             $stg->setUserName($un);

             $em->flush();

             $this->addFlash(
                 "notice",
                 'Professeur UPDATED'
             );
             return $this->redirectToRoute("listpage");*/
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $professeur = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            //dd($professeur);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($professeur);
            $entityManager->flush();
            $this->addFlash(
                "notice",
                'Professeur UPDATED'
            );

            return $this->redirectToRoute('professeur_all');
        }
        // replace this example code with whatever you need
        return $this->render('professeur/edite.html.twig', array(
            "form" => $form->createView()
        ));

    }

    /**
     * @Route("/professeur/delete/{id}", name="professeur_delete")
     */
    public function delete(Professeur $id)
    {
        $em=$this->getDoctrine()->getManager();
        $etu=$em->getRepository(Professeur::class)->find($id);

        $em->remove($etu);
        $em->flush();
        $this->addFlash(
            "notice",
            'Professeur REMOVED'
        );
        return $this->redirectToRoute("professeur_all");
    }
}
