<?php

namespace App\Listeners;

use App\Events\UserSaved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SaveUserAddresses
{
    /**
     * Create the event listener.
     */
    use InteractsWithQueue;

    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserSaved $event): void
    {
        $user = $event->user;
        $addresses = request()->input('addresses', []);

        $user->addresses()->delete();

        foreach ($addresses as $address) {
            $user->addresses()->create($address);
        }
    }
}
