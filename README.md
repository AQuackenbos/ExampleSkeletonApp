# Qore

Qore is a lightweight framework for PHP, built to make it simple to design and send websites to production.

This documentation currently represents the target functionality.  

## Installation

Qore is ideally used as a standalone framework, so cloning this git repo is the simplest way to get a project started.  

> *****@todo***** Setup Qore in a more generic way such that it can be included, and updated, via composer.
> *****@todo***** This repo should be converted to be a skeleton app, with proper composer setup for dependencies.

### Adding Modules

Modules should be added via composer, and installed via `composer update`.  Modules must be given an active status in Qore's master module list in config.php.

### Finalizing Installation

Once the code is in place, Qore's CLI script should be used to run the proper install routines for each module.

```bash
php qore-cli install
```

# Building Modules for Qore

Qore comes with 2 primary modules.

* **Qore_Framework** which builds the MVC architecture that is used throughout the rest of the application.
* **Qore_Admin** which constructs the admin area that other apps can add management areas to.

Any amount of modules can be added.  After any modules are added, `qore-cli install` should be run.

## Structure

Modules can contain many pieces to define them.  Only certain pieces are required:

* Module/**Install.php**: defines the installation routine for the module, even if there isn't one.  Also sets the version and acknowledge name.
* Module/**Config.php**: defines any routes and configuration elements that the module requires.

#### Install.php

Install.php must extend Qore\Framework\Utility\Installer.  It requires 3 properties as well:

> *****@todo***** Remove deprecated \_\_active property.

* **__name** defines the internal reference name to this module.  The suggested format is Namespace_Module.
* **__version** defines the internal version number.  It must be an integer and should increment any time a change is made to the module.
* **__install** defines the installation routine that will be followed when an install command is run.

The key property here is **__install**.  It has a specific required structure that defines each action that will be taken as part of the module's installation via `qore-cli install`.  See below for an example install array.

```php
protected static $__install = [
  1 => [
    'filesystem' => [
      'mkdir' => ['module-storage','module-cache'],
      'touch' => 'special-module-readme.md'
    ],
    'database' => [
      'module_information' => ['CREATE TABLE IF NOT EXISTS ? ( id int(10) auto_increment constraint pk_id primary key )']
    ],
    'scripts' => ['extraInstall','requestUserInformation']
  ]
]
```

Each entry under the install array must represent the version of the module that each install routine is for.  The install routines will be run in sequence, or (in the case of a module update) only for uninstalled versions.

* **filesystem** entries are a whitelist of commands that can be run.  All paths are relative to the root directory, which should be the same directory qore-cli is run from.  Allowed commands: mkdir, touch
* **database** entries are database updates.  Each entry should be keyed by tablename (so the query builder can properly attach any prefixes and events), with an array of queries with a blank binding ("?") for the tablename.
* **scripts** are additional scripts that will run with the installation.  These should represent method names within the Install class.  Any interaction required from the user should be handled here as well.

> *****@todo***** Update install method to properly accept tablename array arguments
> *****@todo***** Update whitelist of filesystem commands both in code and in readme

### Config.php
