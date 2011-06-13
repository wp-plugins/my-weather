<?php

function print_thecountry_weather_list($country)
{

	//	$country_weather_list[$country_name]['country_code']

	if(empty($country_weather_list)){

		$file_location = dirname(__FILE__)."/countries.ser"; 
		if ($fd = fopen($file_location,'r')){
			$country_weather_list_ser = fread($fd,filesize($file_location));
			fclose($fd);
		}
		$country_weather_list = array();
		$country_weather_list = unserialize($country_weather_list_ser);
	}

	$country_name ="";
	foreach($country_weather_list as $k => $v)
	{
		$check_value = "";
		if ($country == $v['country_code']){
	   		$check_value = " SELECTED ";
			$country_name = $k;
		}

		$country_code = $v['country_code'];
		$output_string = '<option value="' . $country_code . '" ';
		$output_string .= $check_value . '>';
		$output_string .= $k . '</option>';
		echo $output_string;
		echo "\n";

	}

	return $country_name;
}


function print_theprovince_weather_list($country, $province)
{
	//
	//	Province list
	//	$province_weather_list[$country_name][$province_name]['province_code'];


	if(empty($province_weather_list)){
		$file_location = dirname(__FILE__)."/province_weather_list.ser"; 
		if ($fd = fopen($file_location,'r')){
			$province_weather_list_ser = fread($fd,filesize($file_location));
			fclose($fd);
		}
		$province_weather_list = unserialize($province_weather_list_ser);
	}

	$state_name ="";
	foreach($province_weather_list[$country] as $k=>$v)
	{
		$check_value = "";
		if ($province == $v['province_code']){
	   		$check_value = ' SELECTED ';
			$state_name = $k;
		}
		echo '<option value="'.$v['province_code'].'" '.$check_value .'>'.$k.'</option>';
		echo "\n";
	}

	return $state_name;

}



// This function print for selector clock size list

function print_thesize_weather_list($size){
	 $size_weather_list = array("50","75","100","150","180","200","250","300");

	 echo "\n";
	foreach($size_weather_list as $isize)
	{
		$check_value = "";
		if ($isize == $size)
	   		$check_value = ' SELECTED ';
		echo '<option value="'.$isize.'" '.$check_value .'>'.$isize.'</option>';
		echo "\n";
	}
}







// This function print for selector clock color list

function print_textcolor_weather_list($text_color){

	 $color_weather_list =array(
		   "#FF0000" => "Red",
		   "#CC033C" =>"Crimson",
		   "#FF6F00" =>"Orange",
		   "#FFCC00" =>"Gold",
		   "#009000" =>"Green",
		   "#00FF00" =>"Lime",
  		   "#0000FF" => "Blue",
		   "#000090" =>"Navy",
		   "#FE00FF" =>"Indigo",
		   "#F99CF9" =>"Pink",
		   "#900090" =>"Purple",
		   "#000000" =>"Black",
		   "#FFFFFF" =>"White",
		   "#DDDDDD" =>"Grey",
		   "#666666" =>"Gray"
         );

	 echo "\n";
	foreach($color_weather_list as $key=>$tcolor)
	{
		$check_value = "";
		if ($text_color == $key)
	   		$check_value = ' SELECTED ';

		$white_text = "";
		if ($key == "#000000" OR $key == "#000090" OR $key == "#666666" OR $key == "#0000FF" )
	   		$white_text = ';color:#FFFFFF ';
		echo '<option value="'.$key.'" style="background-color:'.$key. $white_text .'" '.$check_value .'>'.$tcolor.'</option>';
		echo "\n";
	}


}


// This function print for selector clock color list

function print_bordercolor_weather_list($text_color){

	 $color_weather_list =array(
	      "#FF0000" => "Red",
	      "#CC033C" => "Crimson",
	      "#FF6F00" => "Orange",
	      "#FFCC00" => "Gold",
	      "#009000" => "Green",
	      "#00FF00" => "Lime",
	      "#963939" => "Brown",
	      "#C69633" => "Brass",
	      "#0000FF" => "Blue",
	      "#000090" => "Navy",
	      "#FE00FF" => "Indigo",
	      "#F99CF9" => "Pink",
	      "#900090" => "Purple",
	      "#000000" => "Black",
	      "#FFFFFF" => "White",
	      "#DDDDDD" => "Grey",
	      "#666666" => "Gray",
	      "#F6F9F9;" => "Silver");


	 echo "\n";
	foreach($color_weather_list as $key=>$tcolor)
	{
		$check_value = "";
		if ($text_color == $key)
	   		$check_value = ' SELECTED ';

		$white_text = "";
		if ($key == "#000000" OR $key == "#000090" OR $key == "#666666" OR $key == "#0000FF" )
	   		$white_text = ';color:#FFFFFF ';
		echo '<option value="'.$key.'" style="background-color:'.$key. $white_text .'" '.$check_value .'>'.$tcolor.'</option>';
		echo "\n";
	}



}


// This function print for selector clock color list

function print_backgroundcolor_weather_list($text_color){

	 $color_weather_list =array(
	       "#FF0000" => "Red",
	       "#CC033C" => "Crimson",
	       "#FF6F00" => "Orange",
	       "#F9F99F" => "Golden",
	       "#FFFCCC" => "Almond",
	       "#F6F6CC" => "Beige",
	       "#209020" => "Green",
	       "#c3e44f" => "Light Green",
	       "#963939" => "Brown",
	       "#00FF00" => "Lime",
      	       "#99CCFF" => "Light Blue",
	       "#000090" => "Navy",
	       "#FE00FF" => "Indigo",
	       "#F99CF9" => "Pink",
	       "#993CF3" => "Violet",
	       "#000000" => "Black",
	       "#FFFFFF" => "White",
	       "#DDDDDD" => "Grey",
	       "#666666" => "Gray",
	       "#F6F9F9;" => "Silver");


	 echo "\n";
	foreach($color_weather_list as $key=>$tcolor)
	{
		$check_value = "";
		if ($text_color == $key)
	   		$check_value = ' SELECTED ';

		$white_text = "";
		if ($key == "#000000" OR $key == "#000090" OR $key == "#666666" OR $key == "#0000FF" )
	   		$white_text = ';color:#FFFFFF ';
		echo '<option value="'.$key.'" style="background-color:'.$key. $white_text .'" '.$check_value .'>'.$tcolor.'</option>';
		echo "\n";
	}

}



// This function print for selector clock color list

function print_type_weather_list($type){

	 $type_weather_list =array(
	       "weather2000" => "Weather Clock",
	       "weather2" => "Medium",
	       "weather100" => "Small",
	       "weather1" => "Forecast - Horizontal",
	       "weather3" => "Forecast - Vertical",
	       "weather1000" => "Forecast - Animated"
);


	 echo "\n";
	foreach($type_weather_list as $key=>$ttype)
	{
		$check_value = "";
		if ($type == $key)
	   		$check_value = ' SELECTED ';

		echo '<option value="'.$key.'" style="background-color:'.$key .'" '.$check_value .'>'.$ttype.'</option>';
		echo "\n";
	}

}

?>