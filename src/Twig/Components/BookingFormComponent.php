<?php
namespace App\Twig\Components;

use App\Entity\Booking;
use App\Form\BookingAddType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('booking_form')]
class BookingFormComponent extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    /**
     * The initial data used to create the form.
     *
     * Needed so the same form can be re-created
     * when the component is re-rendered via Ajax.
     *
     * The `fieldName` option is needed in this situation because
     * the form renders fields with names like `name="post[title]"`.
     * We set `fieldName: ''` so that this live prop doesn't collide
     * with that data. The value - data - could be anything.
     */
    #[LiveProp(fieldName: 'data')]
    public ?Booking $booking = null;

    /**
     * Used to re-create the PostType form for re-rendering.
     */
    protected function instantiateForm(): FormInterface
    {
        // we can extend AbstractController to get the normal shortcuts
        return $this->createForm(BookingAddType::class, $this->booking);
    }
}