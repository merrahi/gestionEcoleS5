<?php

namespace App\Controller\Note;


use App\Entity\Exam;
use App\Entity\Filiere;
use App\Entity\Groupe;
use App\Entity\Module;
use App\Entity\Note;
use App\Form\NotesAddType;
use App\Form\NoteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Annotation\Groups;

class NoteController extends AbstractController
{
    /**
     * @Route("/note/all", name="note_all")
     */
    public function listAll(Request $request)
    {

        try{
            //filieres
            $filieres = $this->getDoctrine()->getRepository(Filiere::class)->findAll();
            $defaultFiliere = $this->getDoctrine()->getRepository(Filiere::class)->findOneBy([]);
            $groupes=$this->getDoctrine()->getRepository(Groupe::class)->findBy(['filiere' => $defaultFiliere]);
            //$modules=$this->getDoctrine()->getRepository(Module::class)->findBy(['filiere' => $defaultFiliere]);

            $notes = $this->getDoctrine()->getRepository(Note::class)->findAll();
            //$groupes = $this->getDoctrine()->getRepository(Groupe::class)->findAll();
            $defaultGroupe = $this->getDoctrine()->getRepository(Groupe::class)->findOneBy([]);
            /*dd($defaultGroupe);*/
            //$modules=$this->getDoctrine()->getRepository(Module::class)->findBy(['groupe' => $defaultGroupe]);
            $modules=$defaultGroupe->getModules();
            //dd($defaultGroupe);
            $exams=$this->getDoctrine()->getRepository(Exam::class)->findBy(['groupe' => $defaultGroupe]);

           // dd(count($exams[0]->getNotes()));
            return $this->render('note/list.html.twig', [
                'numberNote' => count($exams[0]->getNotes()),
                'filieres' => $filieres,
                'groupes' => $groupes,
                'modules' => $modules,
                'exams' => $exams,
                'notes' => $notes,
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
     *
     * @Route("/groupes/filiere/{filiere}", name="groupes_filiere", methods={"GET", "POST"})
     *
     * @return Response
     */
    public function groupesFiliere(Filiere $filiere,Request $request) : Response
    {
        try{
            //$groupeReq=$request->query->getInt('id', 1);
            $groupes = $this->getDoctrine()->getRepository(Groupe::class)->findBy(['filiere'=> $filiere]);
            //dd($exams);
            $response=$this->json($groupes,200, [], ['groups' => 'filiere_groupes']);
            return $response;
        } catch (DBALException $e) {
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
    }

    /**
     *
     * @Route("note/modules/groupe/{groupe}", name="modules_groupe", methods={"GET", "POST"})
     *
     * @return Response
     */
    public function modulesGroupe(Groupe $groupe,Request $request) : Response
    {
        try{
            //$groupeReq=$request->query->getInt('id', 1);
            $groupe=$this->getDoctrine()->getRepository(Groupe::class)->find($groupe);
            $modules =$groupe->getModules();
            //dd($modules);
            $response=$this->json($modules,200, [], ['groups' => 'groupe_modules']);
            return $response;
        } catch (DBALException $e) {
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
    }


    /**
     *
     * @Route("note/exams/module/{module}", name="exams_module", methods={"GET", "POST"})
     *
     * @return Response
     */
    public function examsModule(Module $module,Request $request) : Response
    {
        try{
            //$groupeReq=$request->query->getInt('id', 1);
            $exams = $this->getDoctrine()->getRepository(Exam::class)->findBy(['module'=> $module]);
            //dd($exams);
            $response=$this->json($exams,200, [], ['groups' => 'exams']);
            return $response;
        } catch (DBALException $e) {
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
    }

    /**
     *
     * @Route("note/notes/exam/{exam}", name="notes_exam", methods={"GET", "POST"})
     *
     * @return Response
     */
    public function notesExam(Exam $exam,Request $request) : Response
    {
        try{
            $notes = $this->getDoctrine()->getRepository(Note::class)->findBy(['exam'=> $exam]);
            $response=$this->json($notes,200, [], ['groups' => 'notes']);
            return $response;
        } catch (DBALException $e) {
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
    }

    /**
     * @Route("/note/details/{id}", name="note_details")
     */
    public function details(Note $id)
    {
        $note=$this->getDoctrine()
            ->getRepository(Note::class)
            ->find($id);



        // replace this example code with whatever you need
        return $this->render('note/details.html.twig', array("note"=>$note)

        );

    }

    /**
     * @Route("/note/add", name="note_add",methods={"GET", "POST"})
     */
    public function add(Request $request)
    {

        try{
            //filieres
            $filieres = $this->getDoctrine()->getRepository(Filiere::class)->findAll();
            $defaultFiliere = $this->getDoctrine()->getRepository(Filiere::class)->findOneBy([]);
            $groupes=$this->getDoctrine()->getRepository(Groupe::class)->findBy(['filiere' => $defaultFiliere]);
            //$modules=$this->getDoctrine()->getRepository(Module::class)->findBy(['filiere' => $defaultFiliere]);

            $notes = $this->getDoctrine()->getRepository(Note::class)->findAll();
            //$groupes = $this->getDoctrine()->getRepository(Groupe::class)->findAll();
            $defaultGroupe = $this->getDoctrine()->getRepository(Groupe::class)->findOneBy([]);
            /*dd($defaultGroupe);*/
            //$modules=$this->getDoctrine()->getRepository(Module::class)->findBy(['groupe' => $defaultGroupe]);
            $modules=$defaultGroupe->getModules();
            $etudiants=$defaultGroupe->getEtudiants();
            //dd($defaultGroupe);
            $exams=$this->getDoctrine()->getRepository(Exam::class)->findBy(['groupe' => $defaultGroupe]);

            $notes= new NotesAddType();
            $form = $this->createForm(NotesAddType::class);
            $form->handleRequest($request);
            if($form->isSubmitted() ){
                //dd($request->request->all());
                dd($form->getData());
            }
            /*if($request->isMethod('post')){
                $posts = $request->request->all();
                $post = $request->request->get("name_field");
                dd($posts);
            }*/

          /*  if($request){

                $note = $form->getData();
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($note);
                $entityManager->flush();
                $this->addFlash(
                    "notice",
                    'Note Created'
                );

                return $this->redirectToRoute('note_all');
            }*/
            // replace this example code with whatever you need
            return $this->render('note/add.html.twig', array(
                'numberNote' => count($exams[0]->getNotes()),
                'filieres' => $filieres,
                'groupes' => $groupes,
                'modules' => $modules,
                'exams' => $exams,
                'etudiants' => $etudiants,
                'form'=> $form->createView()
            ));
        }
        catch (DBALException $e) {
            $this->addFlash(
                'exception',
                sprintf('DBALException [%i]: %s', $e->getCode(), $e->getMessage())
            );
            //$message = sprintf('DBALException [%i]: %s', $e->getCode(), $e->getMessage());
        }
        catch (PDOException $e) {
            $this->addFlash(
                'exception',
                sprintf('PDOException [%i]: %s', $e->getCode(), $e->getMessage())
            );
            //$message = sprintf('PDOException [%i]: %s', $e->getCode(), $e->getMessage());
        }
        catch (ORMException $e) {
            $this->addFlash(
                'exception',
                sprintf('ORMException [%i]: %s', $e->getCode(), $e->getMessage())
            );
            //$message = sprintf('ORMException [%i]: %s', $e->getCode(), $e->getMessage());
        }
        catch (Exception $e) {
            $this->addFlash(
                'exception',
                sprintf('Exception [%i]: %s', $e->getCode(), $e->getMessage())
            );
            //$message = sprintf('Exception [%i]: %s', $e->getCode(), $e->getMessage());
        }
        return $this->render('error/error.html.twig');
    }

    /**
     * @Route("/note/create", name="note_create")
     */
    public function create(Request $request)
    {
        $note= new Note();
        $form = $this->createForm(NoteType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $note = $form->getData();
            $faitle=$note->getFaitLe();
            $note->getStartAt()->setDate($faitle->format("Y"),$faitle->format("m"),$faitle->format("d"));
            $note->getEndAt()->setDate($faitle->format("Y"),$faitle->format("m"),$faitle->format("d"));
            //dd($note);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($note);
            $entityManager->flush();
            $this->addFlash(
                "notice",
                'Note Created'
            );

            return $this->redirectToRoute('note_all');
        }
        // replace this example code with whatever you need
        return $this->render('note/create.html.twig', array(
            "form" => $form->createView()
        ));

    }

    /**
     * @Route("/note/edit/{id}", name="note_edit")
     */
    public function edit(Note $id, Request $request)
    {
        $note= $this->getDoctrine()->getRepository(Note::class)->find($id);
        $form = $this->createForm(NoteType::class, $note);

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
                 'Note UPDATED'
             );
             return $this->redirectToRoute("listpage");*/
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $note = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            //dd($note);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($note);
            $entityManager->flush();
            $this->addFlash(
                "notice",
                'Note UPDATED'
            );

            return $this->redirectToRoute('note_all');
        }
        // replace this example code with whatever you need
        return $this->render('note/edite.html.twig', array(
            "form" => $form->createView()
        ));

    }

    /**
     * @Route("/note/delete/{id}", name="note_delete")
     */
    public function delete(Note $id)
    {
        $em=$this->getDoctrine()->getManager();
        $etu=$em->getRepository(Note::class)->find($id);

        $em->remove($etu);
        $em->flush();
        $this->addFlash(
            "notice",
            'Note REMOVED'
        );
        return $this->redirectToRoute("note_all");
    }
}
