<?php


namespace App\Http\Controllers;

use App\Notifications\InboxMessage;
use App\Http\Requests\ContactFormRequest;
use App\Models\Admin;


class ContactController extends Controller
{

    public function sendEmail(ContactFormRequest $message, Admin $admin)
    {
        $admin->notify(new InboxMessage($message));

        // redirect the user back
        return redirect()
            ->to('/#contact')
            ->with('message', 'Thanks for contacting me! I\'ll be reaching out shortly');
    }
}
