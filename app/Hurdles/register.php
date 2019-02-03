<?php

return [
	//'YearIsCurrent' => App\Hurdles\YearIsCurrent::class,
    'Session' => \Chibi\Hurdle\StartSession::class,
    'Csrf' => Chibi\Hurdle\CSRFTokenable::class,
];