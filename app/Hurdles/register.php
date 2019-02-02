<?php

return [
	//'YearIsCurrent' => App\Hurdles\YearIsCurrent::class,
    'Csrf' => Chibi\Hurdle\CSRFTokenable::class,
    'Session' => \Chibi\Hurdle\StartSession::class
];