<?php

namespace Talendor\StabilityAI\Enums;

enum StylePreset: string
{
    case ANALOG_FILM = 'analog-film';
    case ANIME = 'anime';
    case CINEMATIC = 'cinematic';
    case COMIC_BOOK = 'comic-book';
    case DIGITAL_ART = 'digital-art';
    case ENHANCE = 'enhance';
    case FANTASY_ART = 'fantasy-art';
    case ISOMETRIC = 'isometric';
    case LINE_ART = 'line-art';
    case LOW_POLY = 'low-poly';
    case MODELING_COMPOUND = 'modeling-compound';
    case NEON_PUNK = 'neon-punk';
    case ORIGAMI = 'origami';
    case PHOTOGRAPHIC = 'photographic';
    case PIXEL_ART = 'pixel-art';
    case TILE_TEXTURE = 'tile-texture';
    case T3D_MODEL = '3d-model';

    public function label()
    {
        return match ($this) {
            self::ANALOG_FILM => 'Analog Film',
            self::ANIME => 'Anime',
            self::CINEMATIC => 'Cinematic',
            self::COMIC_BOOK => 'Comic Book',
            self::DIGITAL_ART => 'Digital Art',
            self::ENHANCE => 'Enhance',
            self::FANTASY_ART => 'Fantasy Art',
            self::ISOMETRIC => 'Isometric',
            self::LINE_ART => 'Line Art',
            self::LOW_POLY => 'Low Poly',
            self::MODELING_COMPOUND => 'Modeling Compound',
            self::NEON_PUNK => 'Neon Punk',
            self::ORIGAMI => 'Origami',
            self::PHOTOGRAPHIC => 'Photographic',
            self::PIXEL_ART => 'Pixel Art',
            self::T3D_MODEL => '3D Model',
            self::TILE_TEXTURE => 'Tile Texture'
        };
    }

    public function getImageUrl(): string
    {
        return asset("vendor/talendor/laravel-stability-ai/images/style-presets/{$this->value}.png");
    }

    public static function getMappedValues(): array
    {
        return collect(self::cases())->map(function ($type) {
            return [
                'image_path' => $type->getImageUrl(),
                'label'      => $type->label(),
                'value'      => $type->value
            ];
        })->values()->toArray();
    }

    public static function getKeyValues(): array
    {
        return collect(self::cases())->flatMap(fn ($type) => [$type->value => $type->label()])->toArray();
    }
}
