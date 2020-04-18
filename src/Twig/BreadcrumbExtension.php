<?php

/*
 * UserFrosting Breadcrumb Sprinkle
 *
 * @link      https://github.com/lcharette/UF_Breadcrumb
 * @copyright Copyright (c) 2020 Louis Charette
 * @license   https://github.com/lcharette/UF_Breadcrumb/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Sprinkle\Breadcrumb\Twig;

use Psr\Container\ContainerInterface;
use Twig\Extension\AbstractExtension;

/**
 * Extends Twig functionality for the Breadcrumb sprinkle.
 */
class BreadcrumbExtension extends AbstractExtension
{
    /**
     * @var ContainerInterface
     */
    protected $ci;

    public function __construct(ContainerInterface $ci)
    {
        $this->ci = $ci;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'userfrosting/breadcrumb';
    }

    /**
     * @return array<string,string>
     */
    public function getGlobals()
    {
        return [
            'breadcrumbs' => $this->ci->breadcrumb->get(),
        ];
    }
}
