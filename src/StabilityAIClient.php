<?php

namespace Talendor\StabilityAI;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Talendor\StabilityAI\Enums\StabilityAIEngine;
use Talendor\StabilityAI\Enums\StylePreset;
use Talendor\StabilityAI\Exceptions\BadRequestException;
use Throwable;

class StabilityAIClient
{
    private $mainEndpoint;
    private $enginesEndpoint;
    private $generationEndpoint;
    private $client;

    public function __construct($apiKey)
    {
        $this->mainEndpoint = 'https://api.stability.ai/v1';
        $this->enginesEndpoint = $this->mainEndpoint . '/engines/list';
        $this->generationEndpoint = $this->mainEndpoint . '/generation';
        $this->client = Http::withToken($apiKey)->acceptJson();
    }


    public function listEngines()
    {
        $response = $this->client->get($this->enginesEndpoint);
        return $response->body();
    }

    public function textToImage(StabilityAIEngine $engine, array $params)
    {
        try {
            $response = $this->client->post($this->generationEndpoint . '/' . $engine->value . '/text-to-image', [
                'style_preset' => $params['style_preset'] ?? StylePreset::tryFrom('pixel-art')->value,
                'steps' => $params['steps'] ?? 50,
                'height' => $params['height'],
                'width' => $params['width'],
                'samples' => $params['samples'] ?? 1,
                'text_prompts' => [
                    [
                        'text' => $params['text'],
                        'weight' => $params['weight'] ?? 1
                    ]
                ]
            ]);

            if ($response->failed()) {
                throw new BadRequestException($response->body());
            }

            $content = json_decode($response->body(), true);
            $artifacts = collect([]);

            if (isset($content['artifacts']) && is_array($content['artifacts'])) {
                foreach ($content['artifacts'] as $artifact) {
                    if (isset($artifact['base64'])) {
                        $base64String = $artifact['base64'];

                        $imageData = base64_decode($base64String);
                        $fileName = uniqid() . '.png';
                        $artifacts->push(['fileName' => $fileName, 'imageData' => $imageData]);
                    }
                }
            }

            return $artifacts;
        } catch (Throwable $err) {
            Log::error("Error in textToImage: {$err->getMessage()}", ['exception' => $err]);
        }

        return collect([]);
    }
}
