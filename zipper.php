<?php

//Starts Here
//Put here the directory you want to search for. Put / if you want to search your entire domain
/*$dir='/home/zfyl/domains/elszanta.tk/public_html/phpftp';
$matc = preg_match("/.*\/([+\w\-. ]+)\/?/",$dir,$dir_to_start1);
$dir_to_start = $dir_to_start1[1];*/

if(isset($_GET['key'])){
	$key = $_GET['key'];
	if($key == '31415926'){

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
	$dir = '/home/zfyl/domains/elszanta.tk/public_html/phpftp';
}


//Put the date you want to compare with in the format of:  YYYY-mm-dd hh:mm:ss



if(isset($_GET['mode'])){
	$mode = 'default';
}else{
	$mode = $_GET['mode'];
}



if(isset($_GET['from_date'])){
	$comparedatestr = $_GET['from_date'];
}else{
	$comparedatestr="2016-07-29 15:52:00";
}

if(isset($_GET['skip'])){
	$skip_pathes_getted = $_GET['skip'];
}else{
	$skip_pathes_getted = '';
}


$comparedate=strtotime($comparedatestr);
//echo $comparedate."------<br>";



/*if($enable){


	$by_date_files_list = "";

	zfyl_sbd($dir,$comparedate,$by_date_files_list);

	zfyl_sbd($dir,$comparedate,$text_me, true);

	echo "<table>$text_me</table>";

	zfyl_zip_from_list($by_date_files_list, $dir);


}*/


switch($mode){
	case 'show-only':
	zfyl_zipper_mode_show_only($dir, $comparedate);
	break;
	case 'default':
	zfyl_zipper_mode_default($dir, $comparedate, $skip_pathes_getted);
	break;
	default:
	zfyl_zipper_mode_default($dir, $comparedate, $skip_pathes_getted);
	break;
}

/*function zfyl_zipper_mode_default2() {

}*/

function zfyl_zipper_mode_default($dir, $comparedate, $skip_pathes_getted) {

	zfyl_sbd($dir,$comparedate,$by_date_files_list);

	zfyl_sbd($dir,$comparedate,$text_me, true);

	echo "<table>$text_me</table>";

	zfyl_zip_from_list($by_date_files_list, $dir, $skip_pathes_getted);

}
function zfyl_zipper_mode_show_only($dir, $comparedate) {

	zfyl_sbd($dir,$comparedate,$text_me, true);

	echo "<table>$text_me</table>";

}
function zfyl_sbd($address,$comparedate,&$string_to_result,$get_with_dates = false){

@$dir = opendir($address);
//var_dump(opendir($address));
  if(!$dir){ return 0; }
  //$rest;
        while($entry = readdir($dir)){
                if(is_dir("$address/$entry") && ($entry != ".." && $entry != ".")){
                        zfyl_sbd("$address/$entry",$comparedate,$string_to_result,$get_with_dates);
                }
                 else   {

                  if($entry != ".." && $entry != ".") {

                    $fulldir=$address.'/'.$entry;
                    $last_modified = filemtime($fulldir);
                    $last_modified_str= date("Y-m-d h:i:s", $last_modified);

                       if($comparedate < $last_modified)  {

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
						   $string_to_result .= $res.$separator_char;
                       }

                 }

            }

      }

}



function zfyl_zip_from_list($files_list, $dir_input, $skip_pathes = ''){

	$files_to_zip = explode(";",$files_list);

	if($skip_pathes == '' || $skip_pathes != ''){

		$skippables = explode(';', $skip_pathes);

		//var_dump($skippables);
		foreach($files_to_zip as $key => $file){


			if($skip_pathes != ""){

				foreach($skippables as $skippable){

					$skippable_escaped = preg_quote($skippable, '/');

					echo "^.*($skippable_escaped).*$------[$file]<br />";

					preg_match("/^.*($skippable_escaped).*$/", $file, $matches_to_skip);





					$matches_presence = count($matches_to_skip);

					if($matches_presence > 1){

						unset($files_to_zip[$key]);

					}

				}

			}

			preg_match("/(update_\d{4}(_\d{2}){0,}.zip)/", $file, $matches_to_skip_updates);

			if(count($matches_to_skip_updates) > 1){

					unset($files_to_zip[$key]);

				}

		}

	}


	$dir=$dir_input;
	$matc = preg_match("/.*\/([+\w\-. ]+)\/?/",$dir,$dir_to_start1);
	$dir_to_start = $dir_to_start1[1];



	$zip = new ZipArchive();
	$filename = "update_".date('Y_m_d_H_i_s').".zip";

	if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
		exit("Cannot open <$filename>\n");
	}
	foreach($files_to_zip as $file){



		$dir_to_start8 = preg_quote($dir_to_start, '/');
		preg_match('/'.$dir_to_start8."([\/+\w\-. ]+)/",$file, $matches1);
		$file_in_zip = $matches1[1];



		$zip->addFile($file, $file_in_zip);
	}

	$zip->close();
	echo "<a href=\"$dir_to/$filename\">DOWNLOAD THE UPDATE ZIP</a>";
}


?>
