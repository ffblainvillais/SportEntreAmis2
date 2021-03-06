<?php

namespace App\Controller;

use App\Entity\Sport;
use App\Service\SearchService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends Controller
{

    private $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    public function indexAction()
    {
        $sports = $this->getDoctrine()->getRepository(Sport::class)->findAll();

        return $this->render('application/index.twig', array(
            "sports" => $sports,
        ));
    }

    public function searchAction(Request $request)
    {
        $sports         = $this->getDoctrine()->getRepository(Sport::class)->findAll();
        $department     = $request->query->get('department');
        $sportsSelected = $request->query->get('sport');

        if ($department) {

            $establishments                 = $this->searchService->searchEstablishment($department, $sportsSelected);
            $establishmentsMappedWithSports = $this->searchService->mapEstablishmentWithSports($establishments);

        } else {

            $establishmentsMappedWithSports = array();
        }

        return $this->render('search/index.twig', array(
            'results'           => $establishmentsMappedWithSports,
            'sports'            => $sports,
            'department'        => $department,
            'sportsSelected'    => $sportsSelected,
        ));
    }
    
    public function autocompleteAction(Request $request)
    {
        $toComplete = $request->request->get('part');
        $department = null;
        $toRender   = array();

        $toCompleteSafe     = $this->searchService->cleanInputParam($toComplete);
        $autoCompleteRes    = $this->searchService->autocompleteDepartment($toCompleteSafe);

        if (!empty($autoCompleteRes)) {

            foreach ($autoCompleteRes as $res) {
                $toRender[] = $res['name'];
            }
        }

        return $this->json(array('res' => $toRender));
    }
}
