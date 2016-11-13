<?php
/**
 * UF Breadcrumb (https://github.com/lcharette/UF_Breadcrumb)
 *
 * @link      https://github.com/lcharette/GASTON
 * @copyright Copyright (c) 2016 Louis Charette
 * @license
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
        return array(
            'breadcrumbs'   => $this->services['breadcrumb']->get()
        );
    }

}
