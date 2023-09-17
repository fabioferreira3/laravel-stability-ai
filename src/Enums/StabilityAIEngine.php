<?php

namespace Talendor\StabilityAI\Enums;

enum StabilityAIEngine: string
{
    case ESRERGAN = 'esrgan-v1-x2plus';
    case SD_XL_V_09 = 'stable-diffusion-xl-1024-v0-9';
    case SD_XL_V_1 = 'stable-diffusion-xl-1024-v1-0';
    case SD_XL_BETA_V2_2_2 = 'stable-diffusion-xl-beta-v2-2-2';
    case SD_V1 = 'stable-diffusion-v1';
    case SV_V1_5 = 'stable-diffusion-v1-5';
    case SD_512_V2 = 'stable-diffusion-512-v2-0';
    case SD_512_V2_1 = 'stable-diffusion-512-v2-1';
    case SD_768_V2 = 'stable-diffusion-768-v2-0';
    case SD_768_V2_1 = 'stable-diffusion-768-v2-1';
    case SD_DEPTH_V2 = 'stable-diffusion-depth-v2-0';
    case SD_X4_UPSCALER = 'stable-diffusion-x4-latent-upscaler';
    case INPAINTING_V1 = 'stable-inpainting-v1-0';
    case INPAINTING_512_V2 = 'stable-inpainting-512-v2-0';

    public function label()
    {
        return match ($this) {
            self::ESRERGAN => "Real-ESRGAN_x2plus upscaler model",
            self::SD_XL_V_09 => "Stability-AI Stable Diffusion XL v0.9",
            self::SD_XL_V_1 => "Stability-AI Stable Diffusion XL v1.0",
            self::SD_XL_BETA_V2_2_2 => "Stability-AI Stable Diffusion XL Beta v2.2.2",
            self::SD_V1 => "Stability-AI Stable Diffusion v1.4",
            self::SV_V1_5 => "Stability-AI Stable Diffusion v1.5",
            self::SD_512_V2 => "Stability-AI Stable Diffusion v2.0",
            self::SD_512_V2_1 => "Stability-AI Stable Diffusion v2.1",
            self::SD_768_V2 => "Stability-AI Stable Diffusion 768 v2.0",
            self::SD_768_V2_1 => "Stability-AI Stable Diffusion 768 v2.1",
            self::SD_DEPTH_V2 => "Stability-AI Stable Diffusion Depth v2.0",
            self::SD_X4_UPSCALER => "Stable Diffusion x4 Latent Upscaler",
            self::INPAINTING_V1 => "Stability-AI Stable Inpainting v1.0",
            self::INPAINTING_512_V2 => "Stability-AI Stable Inpainting v2.0",
        };
    }

    public static function getKeyValues(): array
    {
        return collect(self::cases())->flatMap(fn ($type) => [$type->value => $type->label()])->toArray();
    }
}
