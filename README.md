# UF_Breadcrumb
Breadcrumb service provider for Userfrosting 4.

## Install
Edit UserFrosting `app/sprinkles/sprinkles.json` file and add the following to the `require` list :
```
"lcharette/uf_breadcrumb": "dev-develop"
```

Run `composer update` then `composer run-script bake` to install the sprinkle.

## Usage

In your controllers, you can dynamically add breadcrumbs to the UI. Simply use the `addItem` function of the `breadcrumb` service. 

```
$this->ci->breadcrumb->addItem("Item name", "path/");
```

Note that the item name can also be a translation key. Path can also be optional if you don't want to provide a link with your breadcrumb.

Note that the site index is automatically added to the list. 

See file `templates/components/breadcrumb.html.twig` for breadcrumbs styling.  If your UF theme doesn't include breadcrumbs automatically, simply add this line to your twig files:
```
{% include 'components/breadcrumb.html.twig' %}
```
