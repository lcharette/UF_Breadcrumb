# UF_Breadcrumb
Breadcrumb service provider for Userfrosting 4.

## Install
`cd` into the sprinkle directory of UserFrosting and clone as submodule:
```
git submodule add git@github.com:lcharette/UF_Breadcrumb.git Breadcrumb
```

Add `Breadcrumb` to the sprinkle list in `app/sprinkles/sprinkles.json`

## Usage

In your controllers, you can dynamicaly add breadcrumbs to the UI. Simply use the `addItem` function of the `breadcrumb` service. 

```
$this->ci->breadcrumb->addItem("Item name", "path/");
```

Note that the item name can also be a translation key. Path can also be optional if you don't want to provide a link with your breadcrumb.

Note that the site index is automatically added to the list. 

See file `templates/components/breadcrumb.html.twig` for breadcrumbs styling.  If your UF theme doesn't include breadcrumbs automatically, simply add this line to your twig files:
```
{% include 'components/breadcrumb.html.twig' %}
```
