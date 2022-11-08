<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Repository\BookingRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route('/api', name: 'app_api')]
    public function index(): Response
    {
        return $this->json([]);
    }


    /**
     * @throws \Exception
     */
    #[Route('/api/calendar/bookings', name: 'app_api_calendar_bookings  ')]
    #[IsGranted('ROLE_USER')]
    public function getBookingsByDateRange(Request $request, BookingRepository $repository): Response
    {

        //get a new DateTime object from an ISO8601 string
        $startDate = new \DateTime($request->query->get('start'));
        $endDate = new \DateTime($request->query->get('end'));

        //If admin, then pass null to user param on query
        $user = $this->isGranted('ROLE_ADMIN') ? null : $this->getUser();
        $bookings = $repository->findBookingsByDateRangeAndUser($startDate, $endDate, $user);

        $events = [];

        foreach ($bookings as $booking) {
            $title = $booking->__toString();
            $events[] = [
                'title' => $booking->__toString(),
                'start' => $booking->getBookingTime()->format('Y-m-d H:i:s'),
//                'url' => $this->adminUrlGenerator
//                    ->setController(BookingCrudController::class)
//                    ->setAction(Action::DETAIL)
//                    ->setEntityId($booking->getId())
//                    ->generateUrl(),
                'backgroundColor' => '#ff0000',
//                'extendedProps' => [
////                    'id' => $booking->getOrderNumber(),
////                    'actions' => [
////                        [
////                            'name' => 'Texto al chofer',
////                            'path' => '#',
//////                                'path' => $this->generateUrl('admin_booking_actions_driver_view', ['uniqueId' => $booking->getUniqueId()]),
////                            'value' => $this->renderView('dash/board/bookings/driver_view.txt.twig', ['booking' => $booking])
////                        ],
//////                            [
//////                                'name' => 'Ver detalles',
//////                                'path' => $this->generateUrl('admin_booking_actions_driver_view', ['uniqueId' => $booking->getUniqueId()])
//////                            ]
////                    ],
////                    'isCanceled' => $booking->getStatus() === $booking::STATUS_CANCELLED
//
//
//                ]
//                'borderColor' => $this->findColor($booking->getPaymentStatus()),
            ];
        }
        return new JsonResponse($events);

    }

}
