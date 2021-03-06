#tomkyle/rbac

Role-based access control solution, extracted from my legacy codebase. 
It provides a **permissions** and **roles** system as well as a simple **ACL implementation.**

[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/tomkyle/RBAC/badges/quality-score.png?s=58b756b227576429ae7c237aac26a4440a305004)](https://scrutinizer-ci.com/g/tomkyle/RBAC/)

##Core concepts


###Roles

A client may be associated with certain roles, e.g. *Authors* or *Admins*. 
These are stored in a `RolesStorage` object that contains role IDs.

```php
<?php
use \tomkyle\Roles\RolesStorage;

$roles = new RolesStorage( 1, 2 );
echo $roles->contains( 2 ) ? "YES" : "NO";
```

###ACL
A service may be restricted to certain roles. 
`AccessControlList` as an extension of `RolesStorage` will do that:

```php
<?php
use \tomkyle\Roles\RolesStorage;
use \tomkyle\Roles\RolesAwareInterface;
use \tomkyle\AccessControlList\AccessControlList;
use \tomkyle\AccessControlList\AccessControlListAwareInterface;

class MyUser implements RolesAwareInterface {
  use RolesAwareTrait;
}

class MyService implements AccessControlListAwareInterface {
  use AccessControlListAwareTrait;
}

$service = new MyService;
$service->setAccessControlList( new AccessControlList( 1, 2) );

$user = new MyUser;
$user->setRoles( new RolesStorage( 2, 3 ) );

echo $service->isAllowed( $user ) ? "YES" : "NO";
```


###Permissions
A client may be allowed or disallowed to do certain things. 
`PermissionsStorage` will do that:

```php
<?php
use \tomkyle\Permissions\PermissionsAwareInterface;
use \tomkyle\Permissions\PermissionsAwareTrait;
use \tomkyle\Permissions\ApplyPermissionsStorage;

class MyUser implements PermissionsAwareInterface {
  use PermissionsAwareTrait;
}

$user = new MyUser;

// Reads users permissions from database:
new ApplyPermissionsStorage( $user, $pdo );

echo $user->hasPermission( "my_action" ) ? "YES" : "NO";
```



##Installation

This library has no dependencies except a PDO connection. Install from command line or `composer.json` file:

#####Command line
    
    composer require tomykle/rbac

#####composer.json

    "require": {
        "tomkyle/rbac": "dev-master"
    }

#####MySQL
This package comes with two MySQL dumps, `install.sql.dist` and `install.sample-data.sql.dist`. Simply execute their contents; former installs tables, indices and unique constraints, dropping existing tables; latter adds sample data. See comments in table info or field comments. 

The databasa schema uses InnoDB tables for better transaction and relation handling, although currently not using these features (since I never have worked with it yet).


##Database
Roles, Permissions and their respective associations to clients are stored in a bunch of database tables: 

| Table  | Description |
| :----- | :---------- |
| tomkyle_roles | Defines all roles (aka *user groups*) the application works with. |
| tomkyle_permissions | Holds  permissions the application works with.|
| tomkyle_permissions_roles_mm | Associates permissions with one or many roles. |
| tomkyle_clients_roles_mm | Associates a client with one or many roles.|
| tomkyle_clients_permissions_adjust | Adjusts a clients' permissions, overriding the ones he is granted or permitted due to his roles |

##Administration
Sorry, currently there is no administration tool available. I used to manage them manually in the database. Anyhow, `unique` constraints will prevent you from adding doublettes. So if you have to delete a certain role or permission, do not forget the relation tables that refer to their primary key.
