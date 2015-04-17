# Team 14 Lloyds Banking Website
Most of our code is in public_html/mysite and unit tests are in public_html/mysite/tests.
When running the site through localhost it is at RootDirectory/public_html , this is to integrate with the hosting package.


## Overview of a our Silverstripe Framework website
1. **Routing** - Routes are set up in mysite/_config/routes.yml which define paths and url parameters to a Controller.
2. **Controllers** - When routed to a Controller's job is to return html that can be draw on the page, it does this though silverstripe's tempting engine. These are .php files in mysite/code/controllers
3. **Templates** - A template is a flavour of html which can directly call properties and functions on the controller drawing it, converting the objects into pure html. These are .ss files in mysite/templates

- Controllers: http://doc.silverstripe.org/en/developer_guides/controllers/introduction/
- Routing: http://doc.silverstripe.org/en/developer_guides/controllers/routing/
- Templating: http://doc.silverstripe.org/en/developer_guides/templates/syntax/
- Everything: http://doc.silverstripe.org/en/developer_guides/


## Database Management
- The silverstripe framework sets up and creates the database
- This works by having DataObjet subclasses shown here: http://doc.silverstripe.org/en/developer_guides/model/data_model_and_orm/


## Testing
Tests can be run through localhost by visiting ```../public_hmtl/dev/tests```.
At this page you can select a suite of tests to run, by default silverstripe already has a lot of tests on its own structures.
You can use ```../public_html/dev/tests/TestClassName``` to run a specific set of tests.


## References and Frameworks
- Silverstripe Framework: http://www.silverstripe.org
- PHP Unit: https://phpunit.de/
- Composer: https://getcomposer.org/
- Siteconfig: https://github.com/silverstripe/silverstripe-siteconfig/
- jquery: https://jquery.com/
- jquery ui: https://jqueryui.com/
- Bootstrap: http://getbootstrap.com/
- PHP_Crypt: https://github.com/gilfether/phpcrypt