<?php

namespace App\Http\Controllers;

use App\Models\NewsletterCampaign;
use App\Models\NewsletterSubscriber;
use App\Services\NewsletterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    public function __construct(
        protected NewsletterService $newsletterService
    ) {}

    public function showSubscriptionForm()
    {
        return view('newsletter.subscribe');
    }

    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:newsletter_subscribers,email',
            'name' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $subscriber = NewsletterSubscriber::create([
            'email' => $request->email,
            'name' => $request->name,
            'verified_at' => now(), // Dans un cas réel, vous devriez envoyer un email de confirmation
        ]);

        return back()->with('success', 'Vous êtes maintenant inscrit à notre newsletter !');
    }

    public function unsubscribe(NewsletterSubscriber $subscriber)
    {
        $subscriber->update(['is_active' => false]);

        return view('newsletter.unsubscribed');
    }

    public function trackOpen(NewsletterCampaign $campaign, NewsletterSubscriber $subscriber)
    {
        $this->newsletterService->trackOpen($campaign);

        return response()->file(public_path('images/pixel.gif'));
    }

    public function trackClick(NewsletterCampaign $campaign, NewsletterSubscriber $subscriber, $link)
    {
        $this->newsletterService->trackClick($campaign);

        return redirect()->away(base64_decode($link));
    }
} 