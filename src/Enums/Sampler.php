<?php

namespace Talendor\StabilityAI\Enums;

enum Sampler: string
{
    case DDIM = 'DDIM';
    case DDPM = 'DDPM';
    case K_DPMPP_2M = 'K_DPMPP_2M';
    case K_DPMPP_2S_ANCESTRAL = 'K_DPMPP_2S_ANCESTRAL';
    case K_DPM_2 = 'K_DPM_2';
    case K_DPM_2_ANCESTRAL = 'K_DPM_2_ANCESTRAL';
    case K_EULER = 'K_EULER';
    case K_EULER_ANCESTRAL = 'K_EULER_ANCESTRAL';
    case K_HEUN = 'K_HEUN';
    case K_LMS = 'K_LMS';
}
