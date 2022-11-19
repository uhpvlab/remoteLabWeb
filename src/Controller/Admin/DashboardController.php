<?php

namespace App\Controller\Admin;

use App\Entity\Booking;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\BlogPost;
use Symfony\Component\Security\Core\User\UserInterface;

class DashboardController extends AbstractDashboardController
{

    public function __construct(private AdminUrlGenerator $adminUrlGenerator){}

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        //return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        
//        return $this->redirect($this->adminUrlGenerator->setController(BlogPostCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

       if($this->isGranted('ROLE_ADMIN'))
       {
//             return $this->render('dashboard/index.html.twig');
           return $this->redirect($this->adminUrlGenerator
               ->setController(\App\Controller\Dash\BookingCrudController::class)
               ->setDashboard(DashboardController::class)
               ->generateUrl());

       }

        return $this->redirectToRoute('dash');


        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
         //return $this->render('dashboard/index.html.twig');
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
        if ($user instanceof User) {
            return (parent::configureUserMenu($user))->setAvatarUrl($user->getRobotAvatar());
        }
        return parent::configureUserMenu($user);
    }


    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Post', 'fas fa-list', BlogPost::class);
        yield MenuItem::linkToCrud('Users', 'fas fa-users', User::class);
        yield MenuItem::linkToCrud('Bookings', 'fas fa-calendar', Booking::class)
            ->setController(BookingCrudController::class);
        ;
    }



}
