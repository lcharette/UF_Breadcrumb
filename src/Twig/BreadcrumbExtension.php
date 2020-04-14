<?php

/*
 * UserFrosting Breadcrumb Sprinkle
 *
 * @link      https://github.com/lcharette/UF_Breadcrumb
 * @copyright Copyright (c) 2020 Louis Charette
 * @license   https://github.com/lcharette/UF_Breadcrumb/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Sprinkle\Breadcrumb\Twig;

use Interop\Container\ContainerInterface;

/**
 * Extends Twig functionality for the Breadcrumb sprinkle.
 *
 * @author Louis Charette (https://github.com/lcharette)
 */
class BreadcrumbExtension extends \Twig_Extension
{
    protected $services;

    public function __construct(ContainerInterface $services)
    {
        $this->services = $services;
    }

    public function getName()
    {
        return 'userfrosting/breadcrumb';
    }

    public function getGlobals()
    {
        return [
            'breadcrumbs'   => $this->services['breadcrumb']->get(),
        ];
    }
}
