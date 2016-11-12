<?php

namespace UserFrosting\Sprinkle\Breadcrumb;

use Interop\Container\ContainerInterface;

/**
 * The Breadcrumbs class, which manage the breadcrumbs in the Application
 *
 * @package Breadcrumbs
 * @author Louis Charette
 * @link http://www.userfrosting.com/
 */
class BreadcrumbManager {

    /**
     * @var items[] An array of item in the breadcrumbs list.
     */
    protected $items = [];

     /**
     * @var ContainerInterface The global container object, which holds all your services.
     */
    protected $ci;

    /**
     * Create a new Breadcrumbs object.
     *
     */
    public function __construct(ContainerInterface $ci) {

        $this->ci = $ci;

	    //TODO: Add site setting to enabled this or not
	    $this->addItem($ci->config['site.title'], "/");
    }

    /**
     * Add an item to the breadcrumbs list.
     *
     * This method does NOT modify the database.  Call `store` to persist to database.
     * @param string $name The name of the page that will be displayed.
     * @param string $uri optional The uri this entry will point to.
     * @param bool $uri optional If this entry is active or not
     * @return null
     */
	public function addItem($name, $uri = "", $active = true){

		//Translate the name. Doing this here allow to pass or not translation keys
		$n = $this->ci->translator->translate($name);

		//Before we add the new one, any item are not the last one
		foreach ($this->items as $key => $value) {
			$this->items[$key]["last"] = false;
		}

		// If $uri is an array, we reconstruct the route
        if (is_array($uri)) {
            $uri = $this->ci->router->pathFor($uri[0], $uri[1]);
        }

		//Add the item to the array
		$this->items[] = array(
			"title" => $n,
			"uri" => $uri,
			"active" => $active,
			"last" => true,
			"first" => (count($this->items) == 0) ? true : false
		);
	}

    /**
     * Determine if the property for this object exists.
     *
     * This method does NOT modify the database.  Call `store` to persist to database.
     * @param string $name The name of the page that will be displayed.
     * @param string $uri optional The uri this entry will point to.
     * @return array[items] Array of all the entry in the Breadcrumbs list
     */
	public function getItems() {
		return $this->items;
	}

}