<?php
    Route::any(config('ucenter.url').'/api/uc.php', '\Binaryoung\Ucenter\Controllers\ApiController@init');
