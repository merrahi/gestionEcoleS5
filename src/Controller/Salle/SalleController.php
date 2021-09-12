<?php

namespace App\Controller\Salle;


use App\Entity\Salle;
use App\Form\SalleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SalleController extends AbstractController
{
    /**
     * @Route("/salle/all", name="salle_all")
     */
    public function listAll(Request $request)
    {

        try{

            $salles = $this->getDoctrine()->getRepository(Salle::class)->findAll();
            return $this->render('salle/list.html.twig', [
                'numberSalle' => count($salles),
                'salles' => $salles
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
     * @Route("/salle/details/{id}", name="salle_details")
     */
    public function details(Salle $id)
    {
        $salle=$this->getDoctrine()
            ->getRepository(Salle::class)
            ->find($id);



        // replace this example code with whatever you need
        return $this->render('salle/details.html.twig', array("salle"=>$salle)

        );

    }

    /**
     * @Route("/salle/create", name="salle_create")
     */
    public function create(Request $request)
    {
        $salle= new Salle();
        $form = $this->createForm(SalleType::class, $salle);

        /*$form=$this->createFormBuilder($stg)
            ->add("firstname",TextType::class,array("attr"=>array("class"=>"form-control","style"=>"margin-bottom:15px")))
            ->add("lastname",TextType::class,array("attr"=>array("class"=>"form-control","style"=>"margin-bottom:15px")))
            ->add("username",TextType::class,array("attr"=>array("class"=>"form-control","style"=>"margin-bottom:15px")))
            ->add("save",SubmitType::class,array("label"=>"EDIT Stagiaire","attr"=>array("class"=>"btn btn-primary","style"=>"margin-bottom:15px")))
            ->getForm();*/
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $salle = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($salle);
            $entityManager->flush();
            $this->addFlash(
                "notice",
                'Salle Created'
            );

            return $this->redirectToRoute('salle_all');
        }
        // replace this example code with whatever you need
        return $this->render('salle/create.html.twig', array(
            "form" => $form->createView()
        ));

    }

    /**
     * @Route("/salle/edit/{id}", name="salle_edit")
     */
    public function edit(Salle $id, Request $request)
    {
        $salle= $this->getDoctrine()->getRepository(Salle::class)->find($id);
        $form = $this->createForm(SalleType::class, $salle);

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
                 'Salle UPDATED'
             );
             return $this->redirectToRoute("listpage");*/
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $salle = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            //dd($salle);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($salle);
            $entityManager->flush();
            $this->addFlash(
                "notice",
                'Salle UPDATED'
            );

            return $this->redirectToRoute('salle_all');
        }
        // replace this example code with whatever you need
        return $this->render('salle/edite.html.twig', array(
            "form" => $form->createView()
        ));

    }

    /**
     * @Route("/salle/delete/{id}", name="salle_delete")
     */
    public function delete(Salle $id)
    {
        $em=$this->getDoctrine()->getManager();
        $etu=$em->getRepository(Salle::class)->find($id);

        $em->remove($etu);
        $em->flush();
        $this->addFlash(
            "notice",
            'Salle REMOVED'
        );
        return $this->redirectToRoute("salle_all");
    }
}
