<?php

namespace App\Controller\Cours;


use App\Entity\Cours;
use App\Form\CoursType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CoursController extends AbstractController
{
    /**
     * @Route("/cours/all", name="cours_all")
     */
    public function listAll(Request $request)
    {

        try{

            $courss = $this->getDoctrine()->getRepository(Cours::class)->findAll();
            return $this->render('cours/list.html.twig', [
                'numberCours' => count($courss),
                'courss' => $courss
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
     * @Route("/cours/details/{id}", name="cours_details")
     */
    public function details(Cours $id)
    {
        $cours=$this->getDoctrine()
            ->getRepository(Cours::class)
            ->find($id);



        // replace this example code with whatever you need
        return $this->render('cours/details.html.twig', array("cours"=>$cours)

        );

    }

    /**
     * @Route("/cours/create", name="cours_create")
     */
    public function create(Request $request)
    {
        $cours= new Cours();
        $form = $this->createForm(CoursType::class, $cours,array(
            'app.time_zone' => $this->getParameter('app.time_zone')
        ));
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $cours = $form->getData();
            $faitle=$cours->getFaitLe();
            $cours->getStartAt()->setDate($faitle->format("Y"),$faitle->format("m"),$faitle->format("d"));
            $cours->getEndAt()->setDate($faitle->format("Y"),$faitle->format("m"),$faitle->format("d"));
            //dd($cours);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cours);
            $entityManager->flush();
            $this->addFlash(
                "notice",
                'Cours Created'
            );

            return $this->redirectToRoute('cours_all');
        }
        // replace this example code with whatever you need
        return $this->render('cours/create.html.twig', array(
            "form" => $form->createView()
        ));

    }

    /**
     * @Route("/cours/edit/{id}", name="cours_edit")
     */
    public function edit(Cours $id, Request $request)
    {
        $cours= $this->getDoctrine()->getRepository(Cours::class)->find($id);
        $form = $this->createForm(CoursType::class, $cours);

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
                 'Cours UPDATED'
             );
             return $this->redirectToRoute("listpage");*/
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $cours = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            //dd($cours);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cours);
            $entityManager->flush();
            $this->addFlash(
                "notice",
                'Cours UPDATED'
            );

            return $this->redirectToRoute('cours_all');
        }
        // replace this example code with whatever you need
        return $this->render('cours/edite.html.twig', array(
            "form" => $form->createView()
        ));

    }

    /**
     * @Route("/cours/delete/{id}", name="cours_delete")
     */
    public function delete(Cours $id)
    {
        $em=$this->getDoctrine()->getManager();
        $etu=$em->getRepository(Cours::class)->find($id);

        $em->remove($etu);
        $em->flush();
        $this->addFlash(
            "notice",
            'Cours REMOVED'
        );
        return $this->redirectToRoute("cours_all");
    }
}
