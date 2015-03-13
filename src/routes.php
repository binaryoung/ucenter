<?php
	Route::any(config('ucenter.url').'/api/uc.php', function(){
		return Binaryoung\Ucenter\Api::init();
	});
