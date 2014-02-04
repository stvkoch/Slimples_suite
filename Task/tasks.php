<?php

//from maki
set('LOCAL_BASE_DIR', __DIR__.'/../');

// maki remove twig-cache
task('remove', 'twig-cache', function(){
	local('find Cache/* -d -type d -exec rm -rf \'{}\' \;');
});

// maki remove local-sessions
task('remove', 'local-sessions', function(){
	local('find Sessions/* -d -type f -exec rm -rf \'{}\' \;');
});

// copy
task('copy-build-propel', function(){
	$opt = prompt('Select environment d==development or p=production', 'green');

	if(strtoupper($opt)=='D') {
		local('cp '.get('LOCAL_BASE_DIR').'/Application/Frontend/Config/development/build.properties '.get('LOCAL_BASE_DIR').'/');
	} else {
		local('cp '.get('LOCAL_BASE_DIR').'/Application/Frontend/Config/production/build.properties '.get('LOCAL_BASE_DIR').'/');
	}
});


// read anv file
task('read-env', function(){
	if(!file_exists(get('LOCAL_BASE_DIR').'.env'))
		echo "file .env not exist\n";
	else
		echo file_get_contents(get('LOCAL_BASE_DIR').'.env');

	echo "\n";
});


// write anv file
task('write-env', function(){

	$rawData = (file_exists(get('LOCAL_BASE_DIR').'.env')) ? file(get('LOCAL_BASE_DIR').'.env') : array();

	$data = array();

	foreach ($rawData as $row) {
		list($k,$v) = explode('=', $row, 2);
		$data[$k] =  $v;
	}

	while(true) {
		$key = prompt('Add key: ');
		$value = prompt('Add value: ');
		if($key == 'quit' && $value == '') break;
		if(!$value && isset($data[$key]))
			unset($data[$key]);
		else
			$data[$key] =  $value;
	}

	$rawData = array();
	foreach ($data as $k=>$v) {
		$rawData[] = $k.'='.$v;
	}

	file_put_contents(get('LOCAL_BASE_DIR').'.env', implode("\n", $rawData));
});

