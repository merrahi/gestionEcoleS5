<?php

namespace App\Controller;

use App\Entity\Cours;
use Faker\Provider\tr_TR\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EmploiDuTempsController extends AbstractController
{
    /**
     * @Route("/emploi/du/temps", name="emploi_du_temps" , methods={"GET","POST"})
     */
    public function index(Request $request)
    {

        try{
            $request->query->getAlnum('data', 'month');
            $courss = $this->getDoctrine()->getRepository(Cours::class)->findByDayField(0);
            return $this->render('emploi_du_temps/index.html.twig', [
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
     *
     * @Route("/emplois", name="emplois", methods={"GET", "POST"})
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function emploi(Request $request) : \Symfony\Component\HttpFoundation\JsonResponse
    {
        try{
            //dd(strtotime($request->query->get('startdate', 0)));
            $startdate = new \DateTime($request->query->get('startdate', 0));
            $enddate = new \DateTime($request->query->get('enddate', 0));
            //dd($startdate,$enddate);

            $cours = $this->getDoctrine()->getRepository(Cours::class)->findBetweenTwoDates($startdate,$enddate);
            /*$events=[
                    [
                        'title' => 'All Day Event',
                        'start' => new \DateTime()
                    ],
                     [
                        'id' => 999,
                        'title' => 'Repeating Event',
                        'start' => new \DateTime(),// Mon Jun 01 2020 00:00:00 GMT+0200 (heure d’été d’Europe centrale)
                        'allDay' => false,
                        'className' => 'info'
                    ],
                     [
                        'id' => 999,
                        'title' => 'Repeating Event',
                        'tart' => new \DateTime(),
                        'allDay' => false,
                        'className' => 'info'
                    ],
                     [
                        'title'=> 'Lghdaaa',
                        'start'=> date_modify(new \DateTime(), '+1 month'),
                        'allDay'=> false,
                        'className' => 'important'
                    ],
                     [
                        'title'=> 'Lunch',
                        'start'=> new \DateTime(),
                        'end'=> new \DateTime(),
                        'allDay'=> false,
                        'className' => 'important'
                    ],
                     [
                        'title'=> 'Birthday Party',
                        'start'=>  new \DateTime(),
                        'end'=> new \DateTime(),
                        'allDay' => false,
                    ],
                     [
                        'title' => 'Click for Google',
                        'start' => new \DateTime(),
                        'end'  => new \DateTime(),
                        'url' => 'http://google.com/',
                        'className'  => 'success'
                    ]
                ];
            $response=$this->json($events,200, []);*/
            $response=$this->json($cours,200, [],['groups' => 'liste_cours']);

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
}
