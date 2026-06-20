<?php

/*
 * UserFrosting Breadcrumb Sprinkle
 *
 * @link      https://github.com/lcharette/UF_Breadcrumb
 * @copyright Copyright (c) 2020 Louis Charette
 * @license   https://github.com/lcharette/UF_Breadcrumb/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Sprinkle\Breadcrumb;

use UserFrosting\Sprinkle\Breadcrumb\Twig\BreadcrumbExtension;
use UserFrosting\Sprinkle\Core\Core;
use UserFrosting\Sprinkle\Core\Sprinkle\Recipe\TwigExtensionRecipe;
use UserFrosting\Sprinkle\SprinkleRecipe;
use UserFrosting\Theme\AdminLTE\AdminLTE;

class Breadcrumb implements SprinkleRecipe, TwigExtensionRecipe
{
    public function getName(): string
    {
        return 'Breadcrumb';
    }

    public function getPath(): string
    {
        return __DIR__ . '/../';
    }

    public function getSprinkles(): array
    {
        return [
            Core::class,
            AdminLTE::class,
        ];
    }

    public function getRoutes(): array
    {
        return [];
    }

    public function getServices(): array
    {
        return [];
    }

    public function getTwigExtensions(): array
    {
        return [
            BreadcrumbExtension::class,
        ];
    }
}
