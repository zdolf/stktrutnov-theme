<?php namespace LZaplata\Pages;

use Lzaplata\Pages\Components\Breadcrumbs;
use LZaplata\Pages\Models\Page;
use October\Rain\Support\Facades\Event;
use System\Classes\PluginBase;
use Lzaplata\Pages\Components\Page as PageComponent;

/**
 * Plugin class
 */
class Plugin extends PluginBase
{
    /**
     * register method, called when the plugin is first registered.
     */
    public function register()
    {
    }

    /**
     * boot method, called right before the request route.
     */
    public function boot()
    {
        Event::listen(["cms.pageLookup.listTypes", "pages.menuitem.listTypes"], function() {
            return [
                "page" => "lzaplata.pages::lang.menuitem.listtype.page.label",
            ];
        });

        Event::listen(["cms.pageLookup.getTypeInfo", "pages.menuitem.getTypeInfo"], function($type) {
            if ($type == "page") {
                return Page::getMenuTypeInfo($type);
            }
        });

        Event::listen(["cms.pageLookup.resolveItem", "pages.menuitem.resolveItem"], function($type, $item, $url, $theme) {
            if ($type == "page") {
                return Page::resolveMenuItem($item, $url, $theme);
            }
        });
    }

    /**
     * registerComponents used by the frontend.
     */
    public function registerComponents()
    {
        return [
            PageComponent::class    => "page",
            Breadcrumbs::class      => "breadcrumbs",
        ];
    }

    /**
     * registerSettings used by the backend.
     */
    public function registerSettings()
    {
    }

    /**
     * @return array
     */
    public function registerMarkupTags(): array
    {
        return [
            "filters" => [
                "bootstrap" => function (string $text): string {
                    return preg_replace_callback("~<table.*?</table>~is", function(array $matches): string {
                        $table = str_replace("<table", "<table class='table table-bordered'", $matches[0]);

                        return "<div class='table-responsive'>" . $table . "</div>";
                    }, $text);
                },
            ],
        ];
    }
}
