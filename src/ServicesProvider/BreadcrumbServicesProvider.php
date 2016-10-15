<?php
/**
 * UF Breadcrumb (https://github.com/lcharette/UF_Breadcrumb)
 *
 * @link      https://github.com/lcharette/GASTON
 * @copyright Copyright (c) 2016 Louis Charette
 * @license
 */
namespace UserFrosting\Sprinkle\Breadcrumb\ServicesProvider;

use UserFrosting\Sprinkle\Breadcrumb\BreadcrumbManager;
use UserFrosting\Sprinkle\Breadcrumb\Twig\BreadcrumbExtension;

/**
 * Registers services for the Breadcrumb sprinkle.
 *
 * @author Louis Charette (https://github.com/lcharette)
 */
class BreadcrumbServicesProvider
{
    /**
     * Register UserFrosting's Breadcrumb services.
     *
     * @param Container $container A DI container implementing ArrayAccess and container-interop.
     */
    public function register($container)
    {
        /**
         * Authentication service.
         *
         * Supports logging in users, remembering their sessions, etc.
         */
        $container['breadcrumb'] = function ($c) {
            return new BreadcrumbManager($c->get('config')['site.title'], $c->get('translator'));
        };

        /**
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
