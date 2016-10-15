<?php
/**
 * UF Breadcrumb (https://github.com/lcharette/UF_Breadcrumb)
 *
 * @link      https://github.com/lcharette/GASTON
 * @copyright Copyright (c) 2016 Louis Charette
 * @license
 */
namespace UserFrosting\Sprinkle\Breadcrumb;

use UserFrosting\Sprinkle\Breadcrumb\ServicesProvider\BreadcrumbServicesProvider;
use UserFrosting\Sprinkle\Core\Initialize\Sprinkle;

/**
 * Bootstrapper class for the 'Breadcrumb' sprinkle.
 *
 * @author Louis Charette (https://github.com/lcharette)
 */
class Breadcrumb extends Sprinkle
{
    /**
     * Register Account services.
     */
    public function init()
    {
        $serviceProvider = new BreadcrumbServicesProvider();
        $serviceProvider->register($this->ci);
    }
}
