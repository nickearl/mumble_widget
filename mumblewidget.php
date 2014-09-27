<?php

/*Mumble Status Widget v1.1
By Nicholas Earl
September 2014
*/

//Configuration
$title = "MUMBLE"; //Set the title of the widget
$imgpath = "/sites/all/libraries/mumble_widget/images/"; //Set the path to the directory containing the images



//Initialize Ice
require_once 'Ice.php';
include_once 'Murmur.php';
$ICE = Ice_initialize();
//$meta = Murmur_MetaPrxHelper::checkedCast($ICE->stringToProxy('Meta:tcp -h 127.0.0.1 -p 6502')); //Use this format for Ice 3.4.x and earlier
$meta = Murmur_MetaPrxHelper::checkedCast($ICE->stringToProxy('Meta -e 1.0:tcp -h 127.0.0.1 -p 6502'));  //Use this format for Ice 3.5.x and later

//Get channels and users
$server = $meta->getServer(1); //You may change the getServer parameter if you have multiple servers
$channels = $server->getChannels();
$users = $server->getUsers();

//Puts users into channels
foreach ($users as $key){
	if(array_key_exists('channel', $key)){
		$channels[$key->channel]->users[$key->name] = array('name'=>$key->name);
	}
}


//Create custom array organized with the info we want
foreach ($channels as $key){
	//Create array of primary channels
	if($key->parent < 1){
		$mainchannels[$key->id] = array('name'=>$key->name, 'id'=>$key->id);
		if (array_key_exists('users', $key)){
			$mainchannels[$key->id]['users'] = $key->users;
		}
	}else if ($key->parent >=1){
		$mainchannels[$key->parent]['subchannels'][$key->id] = array('name'=>$key->name, 'id'=>$key->id);
		if (array_key_exists('users', $key)){
			$mainchannels[$key->parent]['subchannels'][$key->id]['users'] = $key->users;
		}
	}
}

//Display widget
echo '<div id="mumblewidget" class="mumblewidget">';
echo '<div id="mumblewidget-title-area">';
echo '<img src="'.$imgpath.'mumble.svg" height="30" width="30" id="mumblewidget-title-icon">';
echo '<div id="mumblewidget-title-text">';
echo $title.'</div>';
echo '</div>';

//Display each channel name
foreach ($mainchannels as $key){
	echo '<div class="mumblewidget-channel">';
	echo '<div class="mumblewidget-channel-name">';
	if(array_key_exists('users', $key)){
		echo '<img src="'.$imgpath.'channel_active.svg" height="15" width="15" class="mumblewidget-channel-icon">';		
	}else{
		echo '<img src="'.$imgpath.'channel.svg" height="15" width="15" class="mumblewidget-channel-icon">';
	}
	echo '<div class="mumblewidget-channel-name-text">'.$key['name'].'</div></div>';
	if(array_key_exists('users', $key)){
		echo '<div class="mumblewidget-channel-users">';
		foreach($key['users'] as $key2){
			echo $key2['name'].'<br>';		
		}
		echo '</div>';
	}
	if(array_key_exists('subchannels', $key)){

		foreach($key['subchannels'] as $key2){
				echo '<div class="mumblewidget-channel-subchannel">';
				echo '<div class="mumblewidget-channel-subchannel-name">';
					if(array_key_exists('users', $key2)){
						echo '<img src="'.$imgpath.'channel_active.svg" height="15" width="15" class="mumblewidget-channel-icon">';		
					}else{
						echo '<img src="'.$imgpath.'channel.svg" height="15" width="15" class="mumblewidget-channel-icon">';
					}
				echo '<div class="mumblewidget-channel-subchannel-name-text">'.$key2['name'].'</div></div>';
				if(array_key_exists('users', $key2)){
					echo '<div class="mumblewidget-channel-subchannel-users">';
				foreach($key2['users'] as $key3){
					echo $key3['name'].'<br>';
				}
				echo '</div>';
			}
			echo '</div>';
		}

	}
	echo '</div>';
}

echo '</div><br><br>';

?>
