# opCMS

This is a CMS framework for tiny websites with only one template and one dynamic page.

It provides an app to manage your contents and has a builtin example template for the website.
Both will be deployed separately with a shared database.
The app's main directory is `public` and the default website points to `example/public`.
Look through the `docker-compose.yml` and `Dockerfile` to get more details about requirements and build steps.

The template uses a static container and interfaces to access dynamic contents. 
All interfaces always have two different implementations. 
There is one to create the final output and one to collect all information for the CMS.
The example contains all available default features.
Take a look at `dscheinah/sx-template` and a plugin with configuration page if you intend to add more features.

## CMS

The application is targeted for users from Germany and has no translations ready.

It provides a main page to select what to render for all keys defined in your template. 
Each plugin also has its own configuration page to provide the real content.

## Custom template

To create a custom template, start with a copy of the example code to e.g. `.website`. Also point the CMS to your template,
by providing a `config/template.local.php` override containing `return ['template' => __DIR__ . '/../.website/template.phtml'];`.

You also need to make sure that both your apps do have (write) access to the configured image folders. You may need to change these with an override and use volumes in production.

If you intend to create a separate project for the website, 
you need to adapt the `TemplateEmitterProvider` and `Template/*ValueProvider` with its dependencies.
You also need a way to provide shared read access to your template and database.
