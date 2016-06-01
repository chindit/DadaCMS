# DadaCMS

## INSTALLATION

### Composer
1. Add DadaCMS as a dependency on your *composer.json*
	```"dada/cmsbundle": "dev-master"```
2. Update your dependencies `composer update`
3. Load routes by adding this line in *app/config/routing.yml*
	```dada_cms:
		resource: "@DadaCMSBundle/Resources/config/routing.yml"
		prefix: "/cms"```
4. Register bundle in *app/appKernel.php*
    ```new Dada\CMSBundle\DadaCMSBundle(),```
5. Update your database schema
6. DadaCMS **requires** _StofDoctrineExtensionBundle_  Please install it and load it in your _appKernel.php_
	* Add the following lines to your _config.yml_
	```stof_doctrine_extensions:
    orm:
        default:
            sluggable: true
            timestampable: true```
	* Also in _config.yml_ add these lines **just under** `orm:` in `doctrine:` group:
	```    mappings:
        gedmo_loggable:
            type: annotation
            prefix: Gedmo\Loggable\Entity
            dir: "%kernel.root_dir%/../vendor/gedmo/doctrine-extensions/lib/Gedmo/Loggable/Entity"
            is_bundle: false```
7. Define DadaCMS parameters in your _parameters.yml_
	```dadacms.history: false
	dadacms.items_page: 10
	dadacms.default_role: "all"```
8. Add these two lines under _twig_ on your _config.yml_
	```globals:
        dadacms_history: "%dadacms.history%"```
9. DadaCMS is now operational!  You can access it going to «you-app-path/cms»

### WARNING
DadaCMS requires you te have the «ROLE_ADMIN» role to access the bundle.
It is recommended to use FOSUserBundle to manage your users.

## HISTORY
DadaCMS possess a powerfull history function which needs to be activated manually.
To activate history, you juste have to change the value of `dadacms.history` from _false_ to _true_ and… it's OK ;)

# USER FUNCTIONS
DadaCMS possess some useful functions to help you retrieve your pages.
You can call `@DadaCMSBundle:Front:getPageBySlug($slug)` or `@DadaCMSBundle:Front:getPageById($id)` to easily get a `Page` object.

We hope you have found DadaCMS usefull.
Thanks for your support.
_Chindit_
