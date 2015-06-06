<?php

Route::any(config('ucenter.url').'/api/'.config('ucenter.apifilename'), '\Binaryoung\Ucenter\Controllers\ApiController@run');
