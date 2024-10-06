<?php

namespace App\Providers;

use App\Events\Account\AccountEvent;
use App\Models\User;
use App\Models\Member;
use App\Models\Ticket;
use App\Models\Employee;
use App\Models\TicketReply;
use App\Models\TicketAssign;
use App\Models\EmailTemplate;
use App\Observers\UserObserver;
use App\Events\Auth\LoggedEvent;
use App\Events\Notification\CreateEvent;
use App\Events\Notification\DeleteEvent;
use App\Events\Stock\StockHistoryEvent;
use App\Events\Ticket\AssignedEvent;
use App\Events\Ticket\CreatedEvent;
use App\Events\Ticket\RepliedEvent;
use App\Events\Transaction\PaymentEvent;
use App\Events\Transaction\PaymentTransferEvent;
use App\Events\Transaction\TransactionStatusChangeEvent;
use App\Http\Requests\Admin\Ticket\CreateRequest;
use App\Listeners\Account\AccountListener;
use App\Listeners\Auth\LoggedListener;
use App\Listeners\Notification\CreateListener;
use App\Listeners\Notification\DeleteListener;
use App\Listeners\Stock\StockHistoryListener;
use App\Listeners\Ticket\AssignedListener;
use App\Listeners\Ticket\CreatedListener;
use App\Listeners\Ticket\RepliedListener;
use App\Listeners\Transaction\PaymentListener;
use App\Listeners\Transaction\PaymentTransferListener;
use App\Listeners\Transaction\TransactionStatusChangeListener;
use App\Observers\MemberObserver;
use App\Observers\TicketObserver;
use App\Observers\EmployeeObserver;
use App\Observers\TicketReplyObserver;
use App\Observers\TicketAssignObserver;
use App\Observers\EmailTemplateObserver;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    protected $listen = [
        /*
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        */
        LoggedEvent::class => [
            LoggedListener::class
        ],
        //Notification Create Event
        CreateEvent::class => [
            CreateListener::class
        ],
        //Notification Delete Event
        DeleteEvent::class => [
            DeleteListener::class
        ],

        //Payment Event
        PaymentEvent::class => [
            PaymentListener::class
        ],

        //Account Event
        AccountEvent::class => [
            AccountListener::class
        ],

        CreateRequest::class => [
            CreatedListener::class
        ],
        //Ticket Events Start
        AssignedEvent::class => [
            AssignedListener::class
        ],

        CreatedEvent::class => [
            CreatedListener::class
        ],

        RepliedEvent::class => [
            RepliedListener::class
        ],
        //Ticket Events End

        TransactionStatusChangeEvent::class => [
            TransactionStatusChangeListener::class
        ],

        PaymentTransferEvent::class => [
            PaymentTransferListener::class
        ],

        StockHistoryEvent::class => [
            StockHistoryListener::class
        ],

    ];

    /**
     * The model observers for your application.
     *
     * @var array
    */
    protected $observers = [
        User::class                 => [UserObserver::class],
        // Role::class                 => [RoleObserver::class],
        // Permission::class           => [PermissionObserver::class],
        Member::class                => [MemberObserver::class],
        Ticket::class               => [TicketObserver::class],
        Employee::class             => [EmployeeObserver::class],
        EmailTemplate::class        => [EmailTemplateObserver::class],
        TicketAssign::class         => [TicketAssignObserver::class],
        TicketReply::class          => [TicketReplyObserver::class],
    ];

    public function boot()
    {
        //
    }

    public function shouldDiscoverEvents()
    {
        return false;
    }
}
