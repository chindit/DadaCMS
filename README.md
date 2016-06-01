# DadaCMS

## INSTALLATION

### Composer
* Add DadaCMS as a dependency on your *composer.json*
    ```"dada/cmsbundle": "dev-master"```
* Update your dependencies `composer update`
* Load routes by adding this line in *app/config/routing.yml*
```
dada_cms: 
    resource: "@DadaCMSBundle/Resources/config/routing.yml"
    prefix: "/cms"
```

* Register bundle in *app/appKernel.php*
    `new Dada\CMSBundle\DadaCMSBundle(),`
* DadaCMS **requires** _StofDoctrineExtensionBundle_  Please install it and load it in your _appKernel.php_
	* Add the following lines to your _config.yml_
```
stof_doctrine_extensions:
    orm:
        default:
            sluggable: true
            timestampable: true
```
* Also in _config.yml_ add these lines **just under** `orm:` in `doctrine:` group:
```
mappings:
    gedmo_loggable:
        type: annotation
        prefix: Gedmo\Loggable\Entity
        dir: "%kernel.root_dir%/../vendor/gedmo/doctrine-extensions/lib/Gedmo/Loggable/Entity"
        is_bundle: false
```
* Update your database schema
* DadaCMS is now operational!  You can access it going to «you-app-path/cms»

### WARNING
DadaCMS requires you te have the «ROLE_ADMIN» role to access the bundle.
It is recommended to use FOSUserBundle to manage your users.

## PARAMETERS
##### History
DadaCMS possess a powerfull history function which needs to be activated manually.
To activate history, you juste have to change the value of `dadacms.history` from _false_ to _true_ and… it's OK ;)
##### Pagination
By default, 10 items are shown for a page.  You can change it by editing _dadacms.items_page_ on your `parameters.yml`
##### Default role
When you create a page, you can assign a default role to view it.  This role can be _ROLE_USER_ , _ROLE_ADMIN_ , or _all_
By default, it's set to _all_
You can change it by editing value of _dadacms.default_role_ on your `parameters.yml`

# USER FUNCTIONS
DadaCMS possess some useful functions to help you retrieve your pages.
You can call `@DadaCMSBundle:Front:getPageBySlug($slug)` or `@DadaCMSBundle:Front:getPageById($id)` to easily get a `Page` object.

### Totally disabling History functionality
By default, DadaCMS use an history functionality.  You can easily hide it (see _History_ above) but it will not be desactivated.  If you want to fully desactivate history, you must manually edit the bundle.  Therefor, is is **not recommended** to do it.  But if you want, you may open _Entity/Page.php_ and remove `@Gedmo\Loggable` and `@Gedmo\Versioned` lines.  You must also edit `config.yml` and remove the `mappings:` group.  Then, upgrade your database scheme and history will be fully desactivated.  Remember to set _dadacms.history_ to false to avoid any problem.

We hope you have found DadaCMS usefull.
Thanks for your support.
_Chindit_
