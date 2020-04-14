<?php

/*
 * UserFrosting Breadcrumb Sprinkle
 *
 * @link      https://github.com/lcharette/UF_Breadcrumb
 * @copyright Copyright (c) 2020 Louis Charette
 * @license   https://github.com/lcharette/UF_Breadcrumb/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Sprinkle\Breadcrumb\ServicesProvider;

use UserFrosting\Sprinkle\Breadcrumb\BreadcrumbManager;
use UserFrosting\Sprinkle\Breadcrumb\Twig\BreadcrumbExtension;

/**
 * Registers services for the Breadcrumb sprinkle.
 *
 * @author Louis Charette (https://github.com/lcharette)
 */
class ServicesProvider
{
    /**
     * Register UserFrosting's Breadcrumb services.
     *
     * @param Container $container A DI container implementing ArrayAccess and container-interop.
     */
    public function register($container)
    {
        /*
         * Authentication service.
         *
         * Supports logging in users, remembering their sessions, etc.
         */
        $container['breadcrumb'] = function ($c) {
            return new BreadcrumbManager($c);
        };

        /*
         * Extends the 'view' service with the BreadcrumbExtension for Twig.
         *
         * Adds account-specific functions, globals, filters, etc to Twig.
         */
        $container->extend('view', function ($view, $c) {
            $twig = $view->getEnvironment();
            $extension = new BreadcrumbExtension($c);
            $twig->addExtension($extension);

            return $view;
        });
    }
}
