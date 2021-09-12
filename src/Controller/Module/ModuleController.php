<?php

namespace App\Controller\Module;


use App\Entity\Module;
use App\Form\ModuleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ModuleController extends AbstractController
{
    /**
     * @Route("/module/all", name="module_all")
     */
    public function listAll(Request $request)
    {

        try{

            $modules = $this->getDoctrine()->getRepository(Module::class)->findAll();
            return $this->render('module/list.html.twig', [
                'numberModule' => count($modules),
                'modules' => $modules
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
     * @Route("/module/details/{id}", name="module_details")
     */
    public function details(Module $id)
    {
        $module=$this->getDoctrine()
            ->getRepository(Module::class)
            ->find($id);



        // replace this example code with whatever you need
        return $this->render('module/details.html.twig', array("module"=>$module)

        );

    }

    /**
     * @Route("/module/create", name="module_create")
     */
    public function create(Request $request)
    {
        $module= new Module();
        $form = $this->createForm(ModuleType::class, $module);

        /*$form=$this->createFormBuilder($stg)
            ->add("firstname",TextType::class,array("attr"=>array("class"=>"form-control","style"=>"margin-bottom:15px")))
            ->add("lastname",TextType::class,array("attr"=>array("class"=>"form-control","style"=>"margin-bottom:15px")))
            ->add("username",TextType::class,array("attr"=>array("class"=>"form-control","style"=>"margin-bottom:15px")))
            ->add("save",SubmitType::class,array("label"=>"EDIT Stagiaire","attr"=>array("class"=>"btn btn-primary","style"=>"margin-bottom:15px")))
            ->getForm();*/
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $module = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($module);
            $entityManager->flush();
            $this->addFlash(
                "notice",
                'Module Created'
            );

            return $this->redirectToRoute('module_all');
        }
        // replace this example code with whatever you need
        return $this->render('module/create.html.twig', array(
            "form" => $form->createView()
        ));

    }

    /**
     * @Route("/module/edit/{id}", name="module_edit")
     */
    public function edit(Module $id, Request $request)
    {
        $module= $this->getDoctrine()->getRepository(Module::class)->find($id);
        $form = $this->createForm(ModuleType::class, $module);

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
                 'Module UPDATED'
             );
             return $this->redirectToRoute("listpage");*/
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $module = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            //dd($module);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($module);
            $entityManager->flush();
            $this->addFlash(
                "notice",
                'Module UPDATED'
            );

            return $this->redirectToRoute('module_all');
        }
        // replace this example code with whatever you need
        return $this->render('module/edite.html.twig', array(
            "form" => $form->createView()
        ));

    }

    /**
     * @Route("/module/delete/{id}", name="module_delete")
     */
    public function delete(Module $id)
    {
        $em=$this->getDoctrine()->getManager();
        $etu=$em->getRepository(Module::class)->find($id);

        $em->remove($etu);
        $em->flush();
        $this->addFlash(
            "notice",
            'Module REMOVED'
        );
        return $this->redirectToRoute("module_all");
    }
}
