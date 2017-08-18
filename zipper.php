<?php

/*
The skipping must be easier....
make it not need to have two // in some cases....

*/

//Starts Here
//Put here the directory you want to search for. Put / if you want to search your entire domain
/*$dir='/home/zfyl/domains/elszanta.tk/public_html/phpftp';
$matc = preg_match("/.*\/([+\w\-. ]+)\/?/",$dir,$dir_to_start1);
$dir_to_start = $dir_to_start1[1];*/
//try
/*
*This is the "security"
*basicaly it was needed to make it a bit harder to use for everyone
*/
if(isset($_GET['key'])){
	$key = $_GET['key'];
	if($key == '31415926'){//some sort a security
		$enable = true;
		$path_to_parse_n_zip = $_GET['path'];
	}else{
		exit("THIS PAGE IS PASSWORD SECURED");
	}
}else{
	exit("THIS PAGE IS PASSWORD SECURED");
}


if(isset($_GET['dir2zip'])){
	$dir = $_GET['dir2zip'];
}else{
	$dir = ''; //Setup here @default directory to look at
}


//Put the date you want to compare, in the format of:  YYYY-mm-dd hh:mm:ss


echo "MODE[".$_GET['mode']."]";
if(!isset($_GET['mode'])){
	$mode = 'default';
}else{
	$mode = $_GET['mode'];
}


//Date comparison
if(isset($_GET['from_date'])){
	$comparedatestr = $_GET['from_date'];
}else{
	$comparedatestr="2016-07-29 15:52:00";//.date("YYYY-MM-dd hh-mm-ss")
}


//Date comparison
if(isset($_GET['until_date'])){
	$until_date = $_GET['until_date'];
}else{
	$until_date=date('Y-m-d H:m:s');//.date("YYYY-MM-dd hh-mm-ss")
}

//what
if(isset($_GET['skip'])){
	$skip_pathes_getted = $_GET['skip'];
}else{
	$skip_pathes_getted = '';
}

// echo "until date before[$until_date]";
$until_date=strtotime($until_date);
// echo "until date after[$until_date]";
$comparedate=strtotime($comparedatestr);
//echo $comparedate."------<br>";



/*if($enable){


	$by_date_files_list = "";

	zfyl_sbd($dir,$comparedate,$by_date_files_list);

	zfyl_sbd($dir,$comparedate,$text_me, true);

	echo "<table>$text_me</table>";

	zfyl_zip_from_list($by_date_files_list, $dir);


}*/

// echo "[$skip_pathes_getted]";
switch($mode){
	case 'show-only':
	zfyl_zipper_mode_show_only($dir, $comparedate, $until_date, $skip_pathes_getted);
	break;
	case 'default':
	zfyl_zipper_mode_default($dir, $comparedate, $until_date, $skip_pathes_getted);
	break;
	default:
	zfyl_zipper_mode_default($dir, $comparedate, $until_date, $skip_pathes_getted);
	break;
}

/*function zfyl_zipper_mode_default2() {

}*/

function zfyl_zipper_mode_default($dir, $comparedate, $until_date, $skip_pathes_getted) {

	zfyl_sbd($dir,$comparedate,$until_date,$by_date_files_list);

	zfyl_sbd($dir,$comparedate,$until_date,$text_me, true, $skip_pathes_getted);

	echo "<table>$text_me</table>";

	zfyl_zip_from_list($by_date_files_list, $dir, $skip_pathes_getted);

}
function zfyl_zipper_mode_show_only($dir, $comparedate, $until_date, $skip_pathes) {
	// echo "inside outer - [$skip_pathes]";
	zfyl_sbd($dir,$comparedate,$until_date,$text_me, true, $skip_pathes);



	echo "<table>$text_me</table>";

}
function zfyl_sbd($address,$comparedate,$until_date,&$string_to_result,$get_with_dates = false, $skip_pathes = ""){
	//$until_date = $GLOBALS['until_date'];
// echo "inside_pre [$skip_pathes]";
@$dir = opendir($address);
//var_dump(opendir($address));
  if(!$dir){ return 0; }
  //$rest;
        while($entry = readdir($dir)){
                if(is_dir("$address/$entry") && ($entry != ".." && $entry != ".")){
                        zfyl_sbd("$address/$entry",$comparedate,$until_date,$string_to_result,$get_with_dates,$skip_pathes);
                }
                 else   {

                  if($entry != ".." && $entry != ".") {

                    $fulldir=$address.'/'.$entry;
                    $last_modified = filemtime($fulldir);
                    $last_modified_str= date("Y-m-d h:i:s", $last_modified);
						// echo "[$comparedate]>[$last_modified]>[$until_date]<br/>";
                       if($comparedate < $last_modified && $last_modified < $until_date)  {

						   if($get_with_dates){
							   $append = '</td><td>'.$last_modified_str.'</td></tr>';
							   $preppend = '<tr><td>';
							   $separator_char = '';
						   }else{
							   $append = '';
							   $preppend = '';
							   $separator_char = ';';
						   }



							$res = $preppend.$fulldir.$append;


						    $skip_this = false;

							if($skip_pathes != ""){
								$skippables = explode(';', $skip_pathes);
								// echo "inside - [$skip_pathes]";


								foreach($skippables as $skippable){

									$skippable_escaped = preg_quote($skippable, '/');

									// echo "^.*($skippable_escaped).*$------[$res]<br />";

									preg_match("/^.*($skippable_escaped).*$/", $res, $matches_to_skip);

											// echo "<br/>";
											// var_dump($matches_to_skip);
											// echo "<br/><br/><br/><br/>";


									$matches_presence = count($matches_to_skip);

									if($matches_presence >= 1){
											// echo "It  was skipped<br/>";
											// var_dump($matches_to_skip);
											// echo "<br/>";
											// unset($files_to_zip[$key]);
											$skip_this = true;

									}

								}

							}
						   if($skip_this){
							   continue;
						   }
						   $string_to_result .= $res.$separator_char;
                       }

                 }

            }

      }

}
function zfyl_zip_from_list($files_list, $dir_input, $skip_pathes = ''){

	$files_to_zip = explode(";",$files_list);

	if($skip_pathes != ''){//$skip_pathes == '' ||

		$skippables = explode(';', $skip_pathes);

		//var_dump($skippables);
		foreach($files_to_zip as $key => $file){


			//if($skip_pathes != ""){

				foreach($skippables as $skippable){

					$skippable_escaped = preg_quote($skippable, '/');

					// echo "^.*($skippable_escaped).*$------[$file]<br />";

					preg_match("/^.*($skippable_escaped).*$/", $file, $matches_to_skip);

							// echo "<br/>";
							// var_dump($matches_to_skip);
							// echo "<br/><br/><br/><br/>";


					$matches_presence = count($matches_to_skip);

					if($matches_presence >= 1){
							// echo "It  was skipped<br/>";
							// var_dump($matches_to_skip);
							// echo "<br/>";
						unset($files_to_zip[$key]);

					}

				}

			//}

			preg_match("/(update_\d{4}(_\d{2}){0,}.zip)/", $file, $matches_to_skip_updates);

			if(count($matches_to_skip_updates) > 1){

					unset($files_to_zip[$key]);

				}

		}

	}


	$dir=$dir_input;
	$matc = preg_match("/.*\/([+\w\-. ]+)\/?/",$dir,$dir_to_start1);
	// echo "NIDD[/.*\/([+\w\-. ]+)\/?/]----[$dir]<br/>";
	$dir_to_start = $dir_to_start1[1];



	$zip = new ZipArchive();
	$filename = "update_".date('Y_m_d_H_i_s').".zip";

	if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
		exit("Cannot open <$filename>\n");
	}
	foreach($files_to_zip as $file){



		$dir_to_start8 = preg_quote($dir_to_start, '/');
		preg_match('/\/'.$dir_to_start8."\/([\/+\w\-. ]+)/",$file, $matches1);
		// echo "NIDD[/.$dir_to_start8([\/+\w\-. ]+)/]----[$file]<br/>";
		$file_in_zip = $matches1[1];
		//echo "---[$file]---[$file_in_zip]".print_r(file_exists($file),true)."<br/>";


		$zip->addFile($file, $file_in_zip);



		// for( $i = 0; $i < $zip->numFiles; $i++ ){
			// $stat = $zip->statIndex( $i );
			// print_r( basename( $stat['name'] ) . PHP_EOL );
		// }
	}

	$zip->close();
	echo "<a href=\"/$dir_to/$filename\">DOWNLOAD THE UPDATE ZIP</a>";
}


?>
