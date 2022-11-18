<?php

namespace App\Controller\Dash;

use App\Entity\Booking;
use App\Entity\User;
use App\Repository\BookingRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Security\Permission;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Logout\LogoutUrlGenerator;
use function Symfony\Component\Translation\t;

class UserDashboardController extends AbstractDashboardController
{

    public function __construct(public BookingRepository $bookingRepository)
    {
    }

    #[Route('/dash', name: 'dash')]
    #[IsGranted('ROLE_USER')]
    public function index(): Response
    {

        $bookings = $this->bookingRepository->findFuturesBookingsByUser($this->getUser());

        return $this->render('dashboard/index.html.twig', [
            'bookings' => $bookings
        ]);


        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }


    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            // the name visible to end users
            ->setTitle('PV Remote Lab')

            // you can include HTML contents too (e.g. to link to an image)
            ->setTitle('<img src="img/logo-rect.png" class="h-16 my-2" alt="logo">')

            // the path defined in this method is passed to the Twig asset() function
            ->setFaviconPath('apple-touch-icon.png')


            // set this option if you prefer the page content to span the entire
            // browser width, instead of the default design which sets a max width
            ->renderContentMaximized();

        // set this option if you prefer the sidebar (which contains the main menu)
        // to be displayed as a narrow column instead of the default expanded design
//            ->renderSidebarMinimized();
    }


    public function configureUserMenu(UserInterface $user): UserMenu
    {
        $userMenuItems = [];
        if($this->isGranted('ROLE_ADMIN'))
        {
            $userMenuItems[] = MenuItem::linkToUrl('Administration', 'fa-gear', $this->generateUrl('admin'));
        }

        if (class_exists(LogoutUrlGenerator::class)) {
            $userMenuItems[] = MenuItem::section();
            $userMenuItems[] = MenuItem::linkToLogout(t('user.sign_out', domain: 'EasyAdminBundle'), 'fa-sign-out');
        }
        if ($this->isGranted(Permission::EA_EXIT_IMPERSONATION)) {
            $userMenuItems[] = MenuItem::linkToExitImpersonation(t('user.exit_impersonation', domain: 'EasyAdminBundle'), 'fa-user-lock');
        }


        $userName = '';
        if (method_exists($user, '__toString')) {
            $userName = (string) $user;
        } elseif (method_exists($user, 'getUserIdentifier')) {
            $userName = $user->getUserIdentifier();
        } elseif (method_exists($user, 'getUsername')) {
            $userName = $user->getUsername();
        }

        $menu = UserMenu::new()
            ->displayUserName()
            ->displayUserAvatar()
            ->setName($userName);

        if ($user instanceof User) {
            $menu->setAvatarUrl($user->getRobotAvatar());
        }
        else {
            $menu->setAvatarUrl(null);
        }

        return $menu->setMenuItems($userMenuItems);
    }



    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
         yield MenuItem::linkToCrud('My Bookings', 'fas fa-list', Booking::class)
             ->setController(BookingCrudController::class);
    }

}
