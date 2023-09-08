<?php

namespace App\Ldap;

use LdapRecord\Models\Model;

class LdapUser extends Model
{
    public static array $objectClasses = [
        'top',
        'person',
        'organizationalperson',
        'user',
    ];
}
