#tomkyle/rbac

This is my role-based access control solution, extracted from my legacy codebase.

*Since I did not distill that mysql stuff into a proper install file yet, you will not be able to install or use it. Please wait one or two days. Thank you!*

##Core concepts


###Roles

A client may be associated with certain roles, e.g. *Authors* or *Admins*. 
These are stored in a `RolesStorage` object that contains role IDs.

```php
//namespace stuff truncated...
$roles = new RolesStorage( 1, 2 );
echo $roles->contains( 2 ) ? "YES" : "NO";
```

###ACL
A service may be restricted to certain roles. 
`AccessControlList` as an extension of `RolesStorage` will do that:

```php
//namespace stuff truncated...

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
//namespace stuff truncated...

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
TBD: I'll prepare and deliver a MySQL dump as soon as possible.



##Database
Roles, Permissions and their respective associations to clients are stored in a bunch of database tables: 

| Table  | Description |
| :----- | :---------- |
| tomkyle_roles | Defines all roles (aka *user groups*) the application works with. |
| tomkyle_permissions | Holds  permissions the application works with.|
| tomkyle_permissions_roles_mm | Associates permissions with one or many roles. |
| tomkyle_clients_roles_mm | Associates a client with one or many roles.|
| tomkyle_clients_rights_adjust | Adjusts a clients' permissions, overriding the ones he is granted or permitted due to his roles |

##Administration
Sorry, currently there is no administration tool available. I used to manage them manually in the database…
