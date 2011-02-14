<?php
/*
Plugin Name: My Weather
Description: Display your city's weather on your sidebar. Choice of widget designs and sizes.
Author: enclick
Version: 1.0
Author URI: http://openweather.com
Plugin URI: http://openweather.com/wordpress.phtml/
*/



function my_weather_init() 
{

     if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
    	   return; 

    function my_weather_control() 
    {

        $newoptions = get_option('my_weather');
    	$options = $newoptions;
	$options_flag=0;


    	if ( empty($newoptions) )
	{
	   $options_flag=1;
      	   $newoptions = array(
	   	'title'=>'London Weather',
           	'titleflag'=>'1', 
           	'transparentflag'=>'0', 
           	'fahrenheitflag'=>'0', 
           	'country' => 'GB',
           	'country_name' => 'United Kingdom',
           	'city' => 'London',
           	'size' => '150',
           	'type' => 'medium',
           	'typeflag' => 'weather100',
           	'text_color' => '#000000',
           	'border_color' => '#963939',
           	'background_color' => '#FFFFFF'
	   );
	}

	if ( $_POST['my-weather-submit'] ) {
	     $options_flag=1;
              $newoptions['title'] = strip_tags(stripslashes($_POST['my-weather-title']));
              $newoptions['titleflag'] = strip_tags(stripslashes($_POST['my-weather-titleflag']));
              $newoptions['transparentflag'] = strip_tags(stripslashes($_POST['my-weather-transparentflag']));
              $newoptions['fahrenheitflag'] = strip_tags(stripslashes($_POST['my-weather-fahrenheitflag']));
              $newoptions['country'] = strip_tags(stripslashes($_POST['my-weather-country']));
              $newoptions['city'] = strip_tags(stripslashes($_POST['my-weather-city']));
              $newoptions['country_name'] = strip_tags(stripslashes($_POST['my-weather-country_name']));
              $newoptions['size'] = strip_tags(stripslashes($_POST['my-weather-size']));
              $newoptions['type'] = strip_tags(stripslashes($_POST['my-weather-type']));
              $newoptions['typeflag'] = strip_tags(stripslashes($_POST['my-weather-typeflag']));
              $newoptions['text_color'] = strip_tags(stripslashes($_POST['my-weather-text-color']));
              $newoptions['border_color'] = strip_tags(stripslashes($_POST['my-weather-border-color']));
              $newoptions['background_color'] = strip_tags(stripslashes($_POST['my-weather-background-color']));
        }

      	if ( $options_flag ==1 ) {
              $options = $newoptions;
              update_option('my_weather', $options);
      	}

      	// Extract value from vars
      	$title = htmlspecialchars($options['title'], ENT_QUOTES);
      	$titleflag = htmlspecialchars($options['titleflag'], ENT_QUOTES);
      	$transparent_flag = htmlspecialchars($options['transparentflag'], ENT_QUOTES);
      	$fahrenheit_flag = htmlspecialchars($options['fahrenheitflag'], ENT_QUOTES);
      	$country = htmlspecialchars($options['country'], ENT_QUOTES);
      	$country_name = htmlspecialchars($options['country_name'], ENT_QUOTES);
      	$city = htmlspecialchars($options['city'], ENT_QUOTES);
      	$size = htmlspecialchars($options['size'], ENT_QUOTES);
      	$type = htmlspecialchars($options['type'], ENT_QUOTES);
      	$typeflag = htmlspecialchars($options['typeflag'], ENT_QUOTES);
      	$text_color = htmlspecialchars($options['text_color'], ENT_QUOTES);
      	$border_color = htmlspecialchars($options['border_color'], ENT_QUOTES);
      	$background_color = htmlspecialchars($options['background_color'], ENT_QUOTES);

      	echo '<ul><li style="text-align:center;list-style: none;"><label for="my-weather-title">Weather<br> by <a href="http://openweather.com">openweather.com</a></label></li>';


       	// Get country, state, city

       	echo '<li style="list-style: none;"><label for="my-weather-country">Country:'.
               '<select id="my-weather-country" name="my-weather-country" style="width:90%">';

     	$country_name = print_thecountry_weather_list($country);
      	echo '<input id="my-weather-country_name" name="my-weather-country_name" type="hidden" value="'.$country_name.'" />';
      	echo '</select></label></li>';



       	// Get city

        echo '<li style="list-style: none;"><label for="my-weather-city">City: <input style="width: 90%;" id="my-weather-city" name="my-weather-city" type="text" value="'.$city.'" /> </label></li><br>';



      	// Set weather type
      	echo '<li style="list-style: none;"><label for="my-weather-typeflag">'.'Widget Type:&nbsp;';
       	echo '<select id="my-weather-typeflag" name="my-weather-typeflag"  style="width:125px" >';
      	print_type_weather_list($typeflag);
      	echo '</select></label>';
      	echo '</li><br>';







	//   Transparent option

	$transparent_checked = "";
	if ($transparent_flag =="1")
	   $transparent_checked = "CHECKED";

	echo "\n";
        echo '<li style="list-style: none;"><label for="my-weather-transparentflag"> Transparent: 
	<input type="checkbox" id="my-weather-transparentflag" name="my-weather-transparentflag" value=1 '.$transparent_checked.' /> 
	</label></li>';


      	// Hidden "OK" button
      	echo '<label for="my-weather-submit">';
      	echo '<input id="my-weather-submit" name="my-weather-submit" type="hidden" value="Ok" />';
      	echo '</label>';


	//	Title header option	

	$title = UCWords($city) . " Weather";

        echo '<label for="my-weather-title"> <input type="hidden" id="my-weather-title" name="my-weather-title" value="'.$title.'" /> </label>';



	//	Fahrenheit option	


	//   Fahrenheit option

	$fahrenheit_checked = "";
	if ($fahrenheit_flag =="1")
	   $fahrenheit_checked = "CHECKED";

	echo "\n";
        echo '<li style="list-style: none;"><label for="my-weather-fahrenheitflag"> Centigrade/Fahrenheit: 
	<input type="checkbox" id="my-weather-fahrenheitflag" name="my-weather-fahrenheitflag" value=1 '.$fahrenheit_checked.' /> 
	</label></li>';



	echo "\n";
        echo '<li style="list-style: none;font-size:9px;text-align:left;margin:20px 0px 0px 0px">*Save after each selection</li>';


	echo '</ul>';


    }


    /////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    //	OUTPUT CLOCK WIDGET
    //
    /////////////////////////////////////////////////////////////////////////////////////////////////////

     function my_weather($args) 
     {

	// Get values 
      	extract($args);

      	$options = get_option('my_weather');


	// Get Title,Location,Size,

      	$title = htmlspecialchars($options['title'], ENT_QUOTES);
      	$titleflag = htmlspecialchars($options['titleflag'], ENT_QUOTES);
      	$transparentflag = htmlspecialchars($options['transparentflag'], ENT_QUOTES);
      	$fahrenheitflag = htmlspecialchars($options['fahrenheitflag'], ENT_QUOTES);
      	$country = htmlspecialchars($options['country'], ENT_QUOTES);
      	$state = htmlspecialchars($options['state'], ENT_QUOTES);
      	$country_name = htmlspecialchars($options['country_name'], ENT_QUOTES);
      	$state_name = htmlspecialchars($options['state_name'], ENT_QUOTES);
      	$city = htmlspecialchars($options['city'], ENT_QUOTES);
      	$size = htmlspecialchars($options['size'], ENT_QUOTES);
      	$type = htmlspecialchars($options['type'], ENT_QUOTES);
      	$typeflag = htmlspecialchars($options['typeflag'], ENT_QUOTES);
      	$text_color = htmlspecialchars($options['text_color'], ENT_QUOTES);
      	$border_color = htmlspecialchars($options['border_color'], ENT_QUOTES);
      	$background_color = htmlspecialchars($options['background_color'], ENT_QUOTES);


	echo $before_widget; 




	// Output title
	echo $before_title . $title . $after_title; 


	// Output weather
	$country_name0 = $country_name;
	if($country_name == "United Kingdom") $country_name = "england";
	$country_code = strtolower($country);


	$target_url= "http://openweather.com/$country_name/";
	$target_url .= $city ."/";
	$target_url= str_replace(" ", "_", $target_url);
	$target_url = strtolower($target_url);


	if($titleflag != 1){
	      $noscript_start = "<noscript>";
	      $noscript_end = "</noscript>";
	}

	if($typeflag == "weather2000") $width = "130px";
	elseif($typeflag == "weather2") $width = "100%";
	elseif($typeflag == "weather100") $width = "100%";
	elseif($typeflag == "weather1") $width = "100%";
	elseif($typeflag == "weather3") $width = "100%";
	elseif($typeflag == "weather1000") $width = "150px";


	echo'<!--Weather in '. $city . ' ' . $country_name0.' widget - HTML code - openweather.com --><center>';
	
	if($typeflag == "weather2000" || $typeflag == "weather1000")
	{
	      if($transparentflag != 1){
	      	     $header_html = '<div align="center" style="width:'.$width . ';border:1px solid #ccc;background:#fff;font-color:#ddd;font-weight:bold;margin:15px 0px 0px 0px;">';
	      			  $header_html .= '<a title="'. $title. '" style="font-size:12px;text-decoration:none;color:#000" href="'.$target_url.'">&nbsp;&nbsp;'.$title.'</a>';
	      }
	      else{
	      	     $header_html = '<div align="center" style="width:'.$width . ';border:1px solid #ccc;;font-weight:bold;margin:15px 0px 0px 0px;">';
    			  $header_html .= '<a title="'. $title. '" style="font-size:12px;text-decoration:none;" href="'.$target_url.'">&nbsp;&nbsp;'.$title.'</a>';
              }

	      $footer_html = "</div>";
	}
	elseif($typeflag == "weather2" || $typeflag == "weather100" || $typeflag == "weather1"  || $typeflag == "weather3"){
	      $header_html = '<div align="center" style ="font-size:12px!important;margin:15px 0px 0px 0px;">';
	      $title2= $city . " Weather Forecast";
	      if($typeflag == "weather1")
	      		   $title2= "Current Weather in " . $city;
	      $footer_html = '<a title="'. $title. '" style="align:center!important;text-align:center!important;font-size:10px;text-decoration:none;margin:0px!important;padding:0px!important;" href="'.$target_url.'">'.$title2.'</a></div>';
       }

	if($transparentflag == 1)
	{
		if($typeflag == "weather2000") $typeflag="weather2001";
		elseif($typeflag == "weather2") $typeflag="weather21";
		elseif($typeflag == "weather100") $typeflag="weather101";
		elseif($typeflag == "weather1") $typeflag="weather11";
		elseif($typeflag == "weather3") $typeflag="weather31";
		elseif($typeflag == "weather1000") $typeflag="weather1001";
	}

	$widget_call_string = 'http://openweather.com/' . $typeflag;
	$widget_call_string .= '.php?zona='.$country_name;
	$widget_call_string .= '_'.$city;
	$widget_call_string = str_replace(" ", "-", $widget_call_string);
	$widget_call_string = strtolower($widget_call_string);
	if($fahrenheitflag != 0) 
   	       $widget_call_string = str_replace(".php", "F.php", $widget_call_string);


	echo $header_html;

	echo '<script type="text/javascript" src="'.$widget_call_string . '"></script>';

	echo $footer_html . '</center><!-end of code-->';




	echo $after_widget;


    }
  
    register_sidebar_widget('My Weather', 'my_weather');
    register_widget_control('My Weather', 'my_weather_control', 245, 300);


}


add_action('plugins_loaded', 'my_weather_init');


// This function print for selector weather 

include("functions.php");


?>