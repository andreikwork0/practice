<?php
return [
    'ldap' => [
        'host'         =>   env('LDAP_HOST'),
        'username'     =>   env('LDAP_USERNAME'),
        'password'     =>   env('LDAP_PASSWORD'),
        'dns'          =>
            [
                'vo'    => 'ou=образовательные структуры,dc=vuz,dc=magtu,dc=ru',
                'spo'  => 'ou=многопрофильный колледж (ук№3),dc=vuz,dc=magtu,dc=ru',
                'def'   =>'ou=общеуниверситетские службы,dc=vuz,dc=magtu,dc=ru',
            ]
    ]
];
