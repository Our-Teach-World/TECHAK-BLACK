<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Mail\ContactFormSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Show the contact form.
     */
    public function show()
    {
        return view('contact');
    }

    /**
     * Process the contact form.
     */
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:2000',
        ]);

        // Create contact record
        $contact = Contact::create($validated);

        // Send email to admin
        Mail::to(config('mail.from.address'))->send(new ContactFormSubmitted($contact));

        return redirect()->route('contact')
            ->with('success', 'Thank you for contacting us! We will get back to you soon.');
    }
}
