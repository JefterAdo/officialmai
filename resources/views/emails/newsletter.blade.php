<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $campaign->subject }}</title>
</head>
<body style="margin: 0; padding: 20px; background-color: #f3f4f6; font-family: Arial, sans-serif;">
    <div style="max-width: 600px; margin: 0 auto; background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
        @if($subscriber->name)
            <p style="color: #4b5563;">Bonjour {{ $subscriber->name }},</p>
        @else
            <p style="color: #4b5563;">Bonjour,</p>
        @endif

        <div style="margin: 20px 0;">
            {!! $campaign->content !!}
        </div>

        <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 20px 0;">

        <p style="color: #6b7280; font-size: 0.875rem;">
            Si vous ne souhaitez plus recevoir nos newsletters, 
            <a href="{{ route('newsletter.unsubscribe', ['subscriber' => $subscriber->id]) }}" style="color: #3b82f6; text-decoration: none;">
                cliquez ici pour vous désabonner
            </a>.
        </p>
    </div>

    <img src="{{ $trackingPixel }}" alt="" width="1" height="1" style="display: none;">
</body>
</html> 