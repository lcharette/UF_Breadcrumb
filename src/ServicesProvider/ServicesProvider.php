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
use UserFrosting\Sprinkle\Breadcrumb\Breadcrumb\Manager;
use UserFrosting\Sprinkle\Breadcrumb\Twig\BreadcrumbExtension;

/**
 * Registers services for the Breadcrumb sprinkle.
 */
class ServicesProvider
{
    /**
     * Register UserFrosting's Breadcrumb services.
     *
     * @param ContainerInterface $container A DI container implementing ArrayAccess and container-interop.
     */
    public function register(ContainerInterface $container)
    {
        /*
         * Authentication service.
         *
         * Supports logging in users, remembering their sessions, etc.
         *
         * @return \UserFrosting\Sprinkle\Breadcrumb\Breadcrumb\Manager
         */
        $container['breadcrumb'] = function ($c) {
            return new Manager($c->config, $c->translator, $c->router);
        };

        /*
         * Extends the 'view' service with the BreadcrumbExtension for Twig.
         *
         * Adds account-specific functions, globals, filters, etc to Twig.
         */
        $container->extend('view', function ($view, $c) {
            $twig = $view->getEnvironment();
            $extension = new BreadcrumbExtension($c->breadcrumb);
            $twig->addExtension($extension);

            return $view;
        });
    }
}
