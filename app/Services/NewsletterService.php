<?php

namespace App\Services;

use App\Models\NewsletterCampaign;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Mail;

class NewsletterService
{
    public function sendCampaign(NewsletterCampaign $campaign)
    {
        if ($campaign->sent_at !== null) {
            throw new \Exception('Cette campagne a déjà été envoyée.');
        }

        $subscribers = NewsletterSubscriber::active()->verified()->get();
        $totalRecipients = $subscribers->count();

        $campaign->update([
            'total_recipients' => $totalRecipients,
            'sent_at' => now(),
        ]);

        $successfulDeliveries = 0;
        $failedDeliveries = 0;

        foreach ($subscribers as $subscriber) {
            try {
                Mail::to($subscriber->email)
                    ->send(new \App\Mail\Newsletter($campaign, $subscriber));
                $successfulDeliveries++;
            } catch (\Exception $e) {
                $failedDeliveries++;
                // Log l'erreur
                \Log::error('Erreur lors de l\'envoi de la newsletter', [
                    'campaign_id' => $campaign->id,
                    'subscriber_id' => $subscriber->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        $campaign->update([
            'successful_deliveries' => $successfulDeliveries,
            'failed_deliveries' => $failedDeliveries,
        ]);

        return [
            'total_recipients' => $totalRecipients,
            'successful_deliveries' => $successfulDeliveries,
            'failed_deliveries' => $failedDeliveries,
        ];
    }

    public function trackOpen(NewsletterCampaign $campaign)
    {
        $campaign->increment('opens');
    }

    public function trackClick(NewsletterCampaign $campaign)
    {
        $campaign->increment('clicks');
    }
} 