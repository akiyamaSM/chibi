
<?php

use App\Hurdles\RedirectIfAuthenticated;
use App\Hurdles\RedirectIfGuest;

return [
	'hurdles' => [
		'YearIsCurrent' => App\Hurdles\YearIsCurrent::class,
        'Guest' => RedirectIfAuthenticated::class,
        'Auth' => RedirectIfGuest::class,
    ]
];