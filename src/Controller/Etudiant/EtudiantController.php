<?php

namespace App\Controller\Etudiant;

use App\Entity\Etudiant;
use App\Entity\Groupe;

use App\Form\EtudiantType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\HttpFoundation\Response;

class EtudiantController extends AbstractController
{
    /**
     * @Route("/etudiant/all", name="etudiant_all")
     */
    public function listAll(Request $request)
    {

        try{
            //$groupe=$request->query->getInt('groupe', 1);
            //dd($groupe);
            $etudiants = $this->getDoctrine()->getRepository(Etudiant::class)->findAll();
            $groupes = $this->getDoctrine()->getRepository(Groupe::class)->findAll();
            $defaultgroupe = $this->getDoctrine()->getRepository(Groupe::class)->findOneBy([], ['id' => 'asc']);
            //dd($firstgroupe);
            return $this->render('etudiant/list.html.twig', [
                'etudiants' => $etudiants,
                'defaultgroupe' => $defaultgroupe,
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
     *
     * @Route("/etudiant/{gr}", name="etudiant_groupe", methods={"GET", "POST"})
     *
     * @return Response
     */
    public function active(Groupe $gr,Request $request) : Response
    {
        try{
            //$groupeReq=$request->query->getInt('id', 1);
            $groupe = $this->getDoctrine()->getRepository(Groupe::class)->find($gr);
            /*$classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
            $normalizer = new ObjectNormalizer($classMetadataFactory);
            $serializer = new Serializer([$normalizer]);
            $groupeJson = $serializer->normalize($groupe, 'json', ['groups' => 'group1']);
            return $groupeJson;
            $response = new JsonResponse($groupeJson,200,[],true);*/
            $response=$this->json($groupe,200, [], ['groups' => 'myread']);
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
     * @Route("/etudiant/details/{id}", name="etudiant_details")
     */
    public function details(Etudiant $id)
    {
        $etudiant=$this->getDoctrine()
            ->getRepository(Etudiant::class)
            ->find($id);



        // replace this example code with whatever you need
        return $this->render('etudiant/details.html.twig', array("etudiant"=>$etudiant)

        );

    }

    /**
     * @Route("/etudiant/edit/{id}", name="etudiant_edit")
     */
    public function edit(Etudiant $id, Request $request)
    {
        $etudiant= $this->getDoctrine()->getRepository(Etudiant::class)->find($id);
        $form = $this->createForm(EtudiantType::class, $etudiant);

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
                'Stagiaire UPDATED'
            );
            return $this->redirectToRoute("listpage");*/
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $etudiant = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            //dd($etudiant);
             $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($etudiant);
            $entityManager->flush();
            $this->addFlash(
                "notice",
                'Stagiaire UPDATED'
            );

            return $this->redirectToRoute('etudiant_all');
        }
        // replace this example code with whatever you need
        return $this->render('etudiant/edite.html.twig', array(
            "form" => $form->createView()
        ));

    }

    /**
     * @Route("/etudiant/delete/{id}", name="etudiant_delete")
     */
    public function delete(Etudiant $id)
    {
        $em=$this->getDoctrine()->getManager();
        $etu=$em->getRepository(Etudiant::class)->find($id);

        $em->remove($etu);
        $em->flush();
        $this->addFlash(
            "notice",
            'Etudinat REMOVED'
        );
        return $this->redirectToRoute("etudiant_all");
    }
}
