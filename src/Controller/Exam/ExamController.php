<?php

namespace App\Controller\Exam;


use App\Entity\Exam;
use App\Form\ExamType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ExamController extends AbstractController
{
    /**
     * @Route("/exam/all", name="exam_all")
     */
    public function listAll(Request $request)
    {

        try{

            $exams = $this->getDoctrine()->getRepository(Exam::class)->findAll();
            return $this->render('exam/list.html.twig', [
                'numberExam' => count($exams),
                'exams' => $exams
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
     * @Route("/exam/details/{id}", name="exam_details")
     */
    public function details(Exam $id)
    {
        $exam=$this->getDoctrine()
            ->getRepository(Exam::class)
            ->find($id);



        // replace this example code with whatever you need
        return $this->render('exam/details.html.twig', array("exam"=>$exam)

        );

    }

    /**
     * @Route("/exam/create", name="exam_create")
     */
    public function create(Request $request)
    {
        $exam= new Exam();
        $form = $this->createForm(ExamType::class, $exam,array(
            'app.time_zone' => $this->getParameter('app.time_zone')
        ));
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $exam = $form->getData();
           // dd($exam);
            $faitle=$exam->getFaitLe();
            //dd($exam);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($exam);
            $entityManager->flush();
            $this->addFlash(
                "notice",
                'Exam Created'
            );

            return $this->redirectToRoute('exam_all');
        }
        // replace this example code with whatever you need
        return $this->render('exam/create.html.twig', array(
            "form" => $form->createView()
        ));

    }

    /**
     * @Route("/exam/edit/{id}", name="exam_edit")
     */
    public function edit(Exam $id, Request $request)
    {
        $exam= $this->getDoctrine()->getRepository(Exam::class)->find($id);
        $form = $this->createForm(ExamType::class, $exam);

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
                 'Exam UPDATED'
             );
             return $this->redirectToRoute("listpage");*/
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $exam = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            //dd($exam);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($exam);
            $entityManager->flush();
            $this->addFlash(
                "notice",
                'Exam UPDATED'
            );

            return $this->redirectToRoute('exam_all');
        }
        // replace this example code with whatever you need
        return $this->render('exam/edite.html.twig', array(
            "form" => $form->createView()
        ));

    }

    /**
     * @Route("/exam/delete/{id}", name="exam_delete")
     */
    public function delete(Exam $id)
    {
        $em=$this->getDoctrine()->getManager();
        $etu=$em->getRepository(Exam::class)->find($id);

        $em->remove($etu);
        $em->flush();
        $this->addFlash(
            "notice",
            'Exam REMOVED'
        );
        return $this->redirectToRoute("exam_all");
    }
}
