<?php

namespace Talendor\StabilityAI;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Talendor\StabilityAI\Enums\StabilityAIEngine;
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

    public function textToImage(array $params, StabilityAIEngine $engine = null)
    {
        if (!$engine) {
            $engine = StabilityAIEngine::SD_XL_V_1;
        }
        try {
            $response = $this->client->post($this->generationEndpoint . '/' . $engine->value . '/text-to-image', [
                'style_preset' => $params['style_preset'],
                'steps' => $params['steps'] ?? 30,
                'height' => $params['height'],
                'width' => $params['width'],
                'samples' => $params['samples'] ?? 1,
                'text_prompts' => [
                    [
                        'text' => $params['prompt'],
                        'weight' => $params['weight'] ?? 1
                    ]
                ]
            ]);

            if ($response->failed()) {
                throw new BadRequestException($response->body());
            }

            $content = json_decode($response->body(), true);
            $files = [];

            if (isset($content['artifacts']) && is_array($content['artifacts'])) {
                foreach ($content['artifacts'] as $artifact) {
                    if (isset($artifact['base64'])) {
                        $base64String = $artifact['base64'];

                        $imageData = base64_decode($base64String);
                        $fileName = uniqid() . '.png';
                        $files[] = ['fileName' => $fileName, 'imageData' => $imageData];
                    }
                }
            }

            return $files;
        } catch (Throwable $err) {
            Log::error("Error in text to image: {$err->getMessage()}", ['exception' => $err]);
            throw new Exception($err->getMessage());
        }

        return collect([]);
    }

    public function imageToImage(StabilityAIEngine $engine, array $params)
    {
        try {
            $response = $this->client->post($this->generationEndpoint . '/' . $engine->value . '/image-to-image', [
                'init_image' => $params['init_image'],
                'style_preset' => $params['style_preset'],
                'steps' => $params['steps'] ?? 30,
                'samples' => $params['samples'] ?? 4,
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
            $files = [];

            if (isset($content['artifacts']) && is_array($content['artifacts'])) {
                foreach ($content['artifacts'] as $artifact) {
                    if (isset($artifact['base64'])) {
                        $base64String = $artifact['base64'];
                        $imageData = base64_decode($base64String);
                        $fileName = uniqid() . '.png';
                        $files[] = ['fileName' => $fileName, 'imageData' => $imageData];
                    }
                }
            }

            return $files;
        } catch (Throwable $err) {
            Log::error("Error in image to image: {$err->getMessage()}", ['exception' => $err]);
            throw new Exception($err->getMessage());
        }

        return collect([]);
    }
}
