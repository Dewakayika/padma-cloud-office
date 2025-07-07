<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DiscordNotifier
{
    /**
     * Send a message to a Discord webhook.
     *
     * @param string $webhookUrl
     * @param string $message
     * @param array $options (optional: username, avatar_url, embeds, etc.)
     * @return bool
     */
    public static function send(string $webhookUrl, string $message, array $options = []): bool
    {
        $payload = array_merge([
            'content' => $message,
        ], $options);

        $response = Http::post($webhookUrl, $payload);
        return $response->successful();
    }
}
