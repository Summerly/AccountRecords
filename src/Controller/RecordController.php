<?php

namespace App\Controller;

use App\Entity\Record;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RecordController extends AbstractController
{
    /**
     * @Route("/record", name="record")
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        $recordRepository = $this->getDoctrine()->getRepository(Record::class);

        $query = $recordRepository->createQueryBuilder('r')->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            50
        );

        return $this->render('record/index.html.twig', [
            'controller_name' => 'RecordController',
            'pagination'      => $pagination
        ]);
    }
}
