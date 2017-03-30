<?php

/*This file is responsible for organising the ZFYL_zipper system data*/

class zfyl_zipper_manage{

private $profilesData = file_get_contents("profiles.txt");

private $profiles;

  public function __construct(){

    $this->readProfiles();

  }

  public function readProfiles($file_contents = false){
    if(!$file_contents){
      $file_contents = $this->profilesData;
    }

    

  }

}

?>
