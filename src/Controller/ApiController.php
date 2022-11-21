<?php

namespace App\Controller;

use App\Controller\Dash\BookingCrudController;
use App\Controller\Dash\UserDashboardController;
use App\Entity\Booking;
use App\Repository\BookingRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class ApiController extends AbstractController
{

    public function __construct(private AdminUrlGenerator $adminUrlGenerator)
    {
    }

    #[Route('/api', name: 'app_api')]
    public function index(): Response
    {
        return $this->json([]);
    }


    /**
     * @throws \Exception
     */
    #[Route('/api/calendar/bookings', name: 'app_api_calendar_bookings')]
    #[IsGranted('ROLE_USER')]
    public function getBookingsByDateRange(Request $request, BookingRepository $repository): Response
    {

        //get a new DateTime object from an ISO8601 string
        $startDate = new \DateTime($request->query->get('start'));
        $endDate = new \DateTime($request->query->get('end'));

        //If admin, then pass null to user param on query
        $user = null; //$this->isGranted('ROLE_ADMIN') ? null : $this->getUser();
        $bookings = $repository->findBookingsByDateRangeAndUser($startDate, $endDate, $user);

        $events = [];

        foreach ($bookings as $booking) {
            $title = $booking->__toString();
            $events[] = [
                'title' => $booking->__toString() . " - ".$booking->getUser(),
                'start' => $booking->getBookingTime()->format('Y-m-d H:i:s'),
                'end' => $booking->getEndTime()->format('Y-m-d H:i:s'),
                'url' => $this->adminUrlGenerator
                    ->setController(BookingCrudController::class)
                    ->setDashboard(UserDashboardController::class)
                    ->setAction(Action::DETAIL)
                    ->setEntityId($booking->getId())
                    ->generateUrl(),
                'backgroundColor' => $booking->getUser()?->getUserIdentifier() === $this->getUser()?->getUserIdentifier() ? '#2cd967' : '#5e636e' ,
//                'borderColor' => 'red',
                'textColor' => 'green',
            ];
        }
        return new JsonResponse($events);

    }

}
