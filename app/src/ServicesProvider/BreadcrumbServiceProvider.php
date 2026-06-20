<?php

/*
 * UserFrosting Breadcrumb Sprinkle
 *
 * @link      https://github.com/lcharette/UF_Breadcrumb
 * @copyright Copyright (c) 2020 Louis Charette
 * @license   https://github.com/lcharette/UF_Breadcrumb/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Sprinkle\Breadcrumb\ServicesProvider;

use Psr\Container\ContainerInterface;
use UserFrosting\Config\Config;
use UserFrosting\I18n\Translator;
use UserFrosting\ServicesProvider\ServicesProviderInterface;
use UserFrosting\Sprinkle\Breadcrumb\BreadcrumbManager;
use UserFrosting\Sprinkle\Core\Router;

/**
 * Registers services for the Breadcrumb sprinkle.
 */
class BreadcrumbServiceProvider implements ServicesProviderInterface
{
    /**
     * Register UserFrosting's Breadcrumb services.
     *
     * @param ContainerInterface $container A DI container implementing ArrayAccess and container-interop.
     */
    public function register(): array
    {
        return [
            BreadcrumbManager::class => function (Config $config, Translator $translator, Router $router) {
                return new BreadcrumbManager($config, $translator, $router);
            },
        ];
    }
}
