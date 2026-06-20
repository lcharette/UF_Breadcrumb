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
use UserFrosting\Sprinkle\Breadcrumb\Breadcrumb;
use UserFrosting\Sprinkle\Breadcrumb\BreadcrumbManager;

/**
 * Extends Twig functionality for the Breadcrumb sprinkle.
 */
class BreadcrumbExtension extends AbstractExtension implements GlobalsInterface
{
    public function __construct(
        protected BreadcrumbManager $breadcrumb
    ) {
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
    public function getGlobals(): array
    {
        return [
            'breadcrumbs' => $this->breadcrumb->generate(),
        ];
    }
}
