<?php

/*
 * UserFrosting Breadcrumb Sprinkle
 *
 * @link      https://github.com/lcharette/UF_Breadcrumb
 * @copyright Copyright (c) 2020 Louis Charette
 * @license   https://github.com/lcharette/UF_Breadcrumb/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Sprinkle\Breadcrumb\Twig;

use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use UserFrosting\Sprinkle\Breadcrumb\Breadcrumb\Manager;

/**
 * Extends Twig functionality for the Breadcrumb sprinkle.
 */
class BreadcrumbExtension extends AbstractExtension implements GlobalsInterface
{
    /**
     * @var Manager
     */
    protected $breadcrumb;

    public function __construct(Manager $breadcrumb)
    {
        $this->breadcrumb = $breadcrumb;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'userfrosting/breadcrumb';
    }

    /**
     * @return array<string,mixed>
     */
    public function getGlobals()
    {
        return [
            'breadcrumbs' => $this->breadcrumb->generate(),
        ];
    }
}
