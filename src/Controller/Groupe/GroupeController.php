<?php

namespace App\Controller\Groupe;


use App\Entity\Groupe;
use App\Form\GroupeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GroupeController extends AbstractController
{
    /**
     * @Route("/groupe/all", name="groupe_all")
     */
    public function listAll(Request $request)
    {

        try{

            $groupes = $this->getDoctrine()->getRepository(Groupe::class)->findAll();
            return $this->render('groupe/list.html.twig', [
                'numberGroupe' => count($groupes),
                'groupes' => $groupes
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
     * @Route("/groupe/details/{id}", name="groupe_details")
     */
    public function details(Groupe $id)
    {
        $groupe=$this->getDoctrine()
            ->getRepository(Groupe::class)
            ->find($id);



        // replace this example code with whatever you need
        return $this->render('groupe/details.html.twig', array("groupe"=>$groupe)

        );

    }

    /**
     * @Route("/groupe/create", name="groupe_create")
     */
    public function create(Request $request)
    {
        $groupe= new Groupe();
        $form = $this->createForm(GroupeType::class, $groupe);

        /*$form=$this->createFormBuilder($stg)
            ->add("firstname",TextType::class,array("attr"=>array("class"=>"form-control","style"=>"margin-bottom:15px")))
            ->add("lastname",TextType::class,array("attr"=>array("class"=>"form-control","style"=>"margin-bottom:15px")))
            ->add("username",TextType::class,array("attr"=>array("class"=>"form-control","style"=>"margin-bottom:15px")))
            ->add("save",SubmitType::class,array("label"=>"EDIT Stagiaire","attr"=>array("class"=>"btn btn-primary","style"=>"margin-bottom:15px")))
            ->getForm();*/
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $groupe = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($groupe);
            $entityManager->flush();
            $this->addFlash(
                "notice",
                'Groupe Created'
            );

            return $this->redirectToRoute('groupe_all');
        }
        // replace this example code with whatever you need
        return $this->render('groupe/create.html.twig', array(
            "form" => $form->createView()
        ));

    }

    /**
     * @Route("/groupe/edit/{id}", name="groupe_edit")
     */
    public function edit(Groupe $id, Request $request)
    {
        $groupe= $this->getDoctrine()->getRepository(Groupe::class)->find($id);
        $form = $this->createForm(GroupeType::class, $groupe);

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
                 'Groupe UPDATED'
             );
             return $this->redirectToRoute("listpage");*/
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $groupe = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            //dd($groupe);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($groupe);
            $entityManager->flush();
            $this->addFlash(
                "notice",
                'Groupe UPDATED'
            );

            return $this->redirectToRoute('groupe_all');
        }
        // replace this example code with whatever you need
        return $this->render('groupe/edite.html.twig', array(
            "form" => $form->createView()
        ));

    }

    /**
     * @Route("/groupe/delete/{id}", name="groupe_delete")
     */
    public function delete(Groupe $id)
    {
        $em=$this->getDoctrine()->getManager();
        $etu=$em->getRepository(Groupe::class)->find($id);

        $em->remove($etu);
        $em->flush();
        $this->addFlash(
            "notice",
            'Groupe REMOVED'
        );
        return $this->redirectToRoute("groupe_all");
    }
}
