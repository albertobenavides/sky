<?php

namespace LaraZeus\Sky\Classes;

use Illuminate\Support\Facades\Blade;

class BoltParser
{
    public function __invoke(string $content): string
    {
        if (class_exists(\LaraZeus\Bolt\Facades\Bolt::class)) {
            $content = html_entity_decode($content);
            preg_match('/<bolt>(.*?)<\/bolt>/s', $content, $bolt);
            if (is_array($bolt) && isset($bolt[1])) {
                $formSlug = trim($bolt[1]);
                $checkForm = config('zeus-bolt.models.Form')::where('slug', $formSlug)->first();
                if ($checkForm !== null) {
                    $boltComponent = Blade::render('<livewire:bolt.fill-form slug="' . $formSlug . '" />');
                    $content = str_replace('<bolt>' . $formSlug . '</bolt>', $boltComponent, $content);
                }
            }
        }

        return $content;
    }
}
