<?php
/*
  Plugin Name: My Weather
  Description: Display your city's weather on your sidebar. Choice of widget designs and sizes.
  Author: enclick
  Version: 1.1
  Author URI: http://openweather.com
  Plugin URI: http://openweather.com/wordpress.phtml/
*/

require_once("functions.php");


/**
 * Add function to widgets_init that'll load our widget.
 */

add_action( 'widgets_init', 'load_my_weather' );

/**
 * Register our widget.
 * 'my_weather' is the widget class used below.
 *
 */
function load_my_weather() {
	register_widget( 'my_weather' );
}


/*******************************************************************************************
 *
 *       My Weather class.
 *       This class handles everything that needs to be handled with the widget:
 *       the settings, form, display, and update.
 *
 *********************************************************************************************/
class my_weather extends WP_Widget
{

	/*******************************************************************************************
	 *
	 *
	 * Widget setup.
	 *
	 *
	 ********************************************************************************************/
	function my_weather() 
	{
		#Widget settings
		$widget_ops = array( 'description' => __('Display city weather on the sidebar', 'my_weather') );

		#Widget control settings
		$control_ops = array( 'width' => 200, 'height' => 550, 'id_base' => 'my_weather' );

		#Create the widget
		$this->WP_Widget( 'my_weather', __('My Weather', 'my_weather'), $widget_ops, $control_ops );
	}


	/*******************************************************************************************
	 *
	 *
	 *	 Update the widget settings.
	 *
	 *
	 *******************************************************************************************/
	function update( $new_instance, $old_instance )
	{
		$instance = $old_instance;
		
		$city = strip_tags(stripslashes($new_instance['city']));
		$instance['city'] = $city;

		if($city)
			$instance['title'] = $city . " Weather";
		else
			$instance['title'] = strip_tags(stripslashes($new_instance['title']));

		$instance['tflag'] = strip_tags(stripslashes($new_instance['tflag']));
		$transparentflag = strip_tags(stripslashes($new_instance['transparentflag']));
		$instance['transparentflag'] = $transparentflag;
		$instance['fahrenheitflag'] = strip_tags(stripslashes($new_instance['fahrenheitflag']));
		$instance['country'] = strip_tags(stripslashes($new_instance['country']));

		$instance['country_name'] = strip_tags(stripslashes($new_instance['country_name']));
		$instance['size'] = strip_tags(stripslashes($new_instance['size']));
		$instance['type'] = strip_tags(stripslashes($new_instance['type']));
		$instance['typeflag'] = strip_tags(stripslashes($new_instance['typeflag']));

		if ($transparentflag == 0)
		{
			$instance['text_color'] = "#000000";
			$instance['background_color'] = "#FFFFFF";
		}
		else
		{
			$instance['text_color'] = strip_tags(stripslashes($new_instance['text_color']));
			$instance['border_color'] = strip_tags(stripslashes($new_instance['border_color']));	
			$instance['background_color'] = strip_tags(stripslashes($new_instance['background_color']));
		}

		return $instance;

	}


	/*******************************************************************************************
	 *
	 *      Displays the widget settings controls on the widget panel.
	 *      Make use of the get_field_id() and get_field_name() function
	 *      when creating your form elements. This handles the confusing stuff.
	 *
	 *
	 ********************************************************************************************/
	function form( $instance )
	{
		#
		#       Set up some default widget settings
		#

		$default = array(
			'title'=>'London Weather',
			'tflag'=>'0', 
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



		if(!isset($instance['country']))
			$instance = $default;



		// Extract value from vars
		$title = htmlspecialchars($instance['title'], ENT_QUOTES);
		$tflag = htmlspecialchars($instance['tflag'], ENT_QUOTES);
		$transparent_flag = htmlspecialchars($instance['transparentflag'], ENT_QUOTES);
		$fahrenheit_flag = htmlspecialchars($instance['fahrenheitflag'], ENT_QUOTES);
		$country = htmlspecialchars($instance['country'], ENT_QUOTES);
		$country_name = htmlspecialchars($instance['country_name'], ENT_QUOTES);
		$city = htmlspecialchars($instance['city'], ENT_QUOTES);
		$type = htmlspecialchars($instance['type'], ENT_QUOTES);
		$typeflag = htmlspecialchars($instance['typeflag'], ENT_QUOTES);
		$text_color = htmlspecialchars($instance['text_color'], ENT_QUOTES);
		$border_color = htmlspecialchars($instance['border_color'], ENT_QUOTES);
		$background_color = htmlspecialchars($instance['background_color'], ENT_QUOTES);
      		
		echo '<div style="margin-bottom:10px"></div>';



		// Get country, state, city

       	echo '<p><label for="' .$this->get_field_id( 'country' ). '">Country:';
        echo '<select id="' .$this->get_field_id( 'country' ). '" name="' .$this->get_field_name( 'country' ). '"  style="width:90%">';
     	$country_name = print_thecountry_weather_list($country);
      	echo '</select></label></p>';
	
		echo '<label for="' .$this->get_field_id( 'country_name' ). '">';
      	echo '<input id="' .$this->get_field_id( 'country_name' ). '" name="' .$this->get_field_name( 'country_name' ). '"  type="hidden" value="'.$country_name.'" /></label>';
       	// Get city

        echo '<p><label for="' .$this->get_field_id( 'city' ). '">City: <input style="width: 90%;" id="' .$this->get_field_id( 'city' ). '" name="' .$this->get_field_name( 'city' ). '" type="text" value="'.$city.'" /> </label></p>';


      	// Set weather type
      	echo '<p><label for="' .$this->get_field_id( 'typeflag' ). '">'.'Widget Type:&nbsp;';
       	echo '<select id="' .$this->get_field_id( 'typeflag' ). '" name="' .$this->get_field_name( 'typeflag' ). '"  style="width:125px" >';
      	print_type_weather_list($typeflag);
      	echo '</select></label>';
      	echo '</p>';

		//   Transparent option

		$transparent_checked = "";
		if ($transparent_flag == 1)
			$transparent_checked = "CHECKED";

		echo "\n";
        echo '<p><label for="' .$this->get_field_id( 'transparentflag' ). '">Customize Colors*: 
	<input type="checkbox" id="' .$this->get_field_id( 'transparentflag' ). '" name="' .$this->get_field_name( 'transparentflag' ). '" value=1 '.$transparent_checked.' />
     <span style="display:inline;font-size:9px">(save after selection)</span>
	</label></p>';


		if($transparent_flag == 1)
		{
			// Set Text Clock color
     	 	echo '<p><label for="' .$this->get_field_id( 'text_color' ). '">'.'Text Color: &nbsp;';
       	 	echo '<select id="' .$this->get_field_id( 'text_color' ). '" name="' .$this->get_field_name( 'text_color' ). '"  style="width:100px" >';
         	print_textcolor_weather_list($text_color);
         	echo '</select></label></p>';

         	// Set Background Clock color
         	echo '<p><label for="' .$this->get_field_id( 'background_color' ). '">'.'Background Color:&nbsp;';
         	echo '<select id="' .$this->get_field_id( 'background_color' ). '" name="' .$this->get_field_name( 'background_color' ). '"  style="width:100px" >';
         	print_backgroundcolor_weather_list($background_color);
         	echo '</select></label></p>';
		}
		else{
			echo '<label for="' .$this->get_field_id( 'text_color' ). '">';
			echo '<input type="hidden" id="' .$this->get_field_id( 'text_color' ). '" name="' .$this->get_field_name( 'text_color' ) .'" value="#000000" /> </label>';

        	echo '<label for="' .$this->get_field_id( 'background_color' ). '">';
			echo '<input type="hidden" id="' .$this->get_field_id( 'background_color' ). '" name="' .$this->get_field_name( 'background_color' ) .'" value="#FFFFFF" /> </label>';
		}




		//	Title header option	

		$title = UCWords($city) . " Weather";

        echo '<label for="' .$this->get_field_id( 'title' ). '"> <input type="hidden" id="' .$this->get_field_id( 'title' ). '" name="' .$this->get_field_name( 'title' ). '" value="'.$title.'" /> </label>';



		//	Fahrenheit option	


		//   Fahrenheit option

		$fahrenheit_checked = "";
		if ($fahrenheit_flag =="1")
			$fahrenheit_checked = "CHECKED";

		echo "\n";
        echo '<p><label for="' .$this->get_field_id( 'fahrenheitflag' ). '"> Centigrade/Fahrenheit: 
	<input type="checkbox" id="' .$this->get_field_id( 'fahrenheitflag' ). '" name="' .$this->get_field_name( 'fahrenheitflag' ). '" value=1 '.$fahrenheit_checked.' /> 
	</label></p>';

		$title_checked = "";
		if ($tflag =="1")
	     	$title_checked = "CHECKED";

		echo "\n";
		echo '<p><label for="' .$this->get_field_id( 'tflag' ). '">  Title/Link to '. $city .' weather :
	     <input type="checkbox" id="' .$this->get_field_id( 'tflag' ). '" name="' .$this->get_field_name( 'tflag' ). '" value=1 '.$title_checked.' /> 
	     </label></p>';


		echo '<div style="font-size:9px">* save after selection</div>';



    }


    /////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    //	OUTPUT CLOCK WIDGET
    //
    /////////////////////////////////////////////////////////////////////////////////////////////////////

	function widget($args , $instance) 
	{

		// Get values 
      	extract($args);


		// Get Title,Location,Size,

      	$title = htmlspecialchars($instance['title'], ENT_QUOTES);
      	$tflag = htmlspecialchars($instance['tflag'], ENT_QUOTES);
      	$transparentflag = htmlspecialchars($instance['transparentflag'], ENT_QUOTES);
      	$fahrenheitflag = htmlspecialchars($instance['fahrenheitflag'], ENT_QUOTES);
      	$country = htmlspecialchars($instance['country'], ENT_QUOTES);
      	$state = htmlspecialchars($instance['state'], ENT_QUOTES);
      	$country_name = htmlspecialchars($instance['country_name'], ENT_QUOTES);
      	$state_name = htmlspecialchars($instance['state_name'], ENT_QUOTES);
      	$city = htmlspecialchars($instance['city'], ENT_QUOTES);
      	$type = htmlspecialchars($instance['type'], ENT_QUOTES);
      	$typeflag = htmlspecialchars($instance['typeflag'], ENT_QUOTES);
      	$text_color = htmlspecialchars($instance['text_color'], ENT_QUOTES);
      	$border_color = htmlspecialchars($instance['border_color'], ENT_QUOTES);
      	$background_color = htmlspecialchars($instance['background_color'], ENT_QUOTES);


		echo $before_widget; 




		// Output title
		#echo $before_title . $title . $after_title; 
		echo $before_title .  $after_title; 


		// Output weather
		$country_name0 = $country_name;
		if($country_name == "United Kingdom") $country_name = "england";
		$country_code = strtolower($country);


		$target_url= "http://openweather.com/$country_name/";
		$target_url .= $city ."/";
		$target_url= str_replace(" ", "_", $target_url);
		$target_url = strtolower($target_url);


		if($tflag != 1){
			$noscript_start = "<noscript>";
			$noscript_end = "</noscript>";
		}

		if($typeflag == "weather2000") $width = "130px";
		elseif($typeflag == "weather2") $width = "180px";
		elseif($typeflag == "weather100") $width = "175px";
		elseif($typeflag == "weather1") $width = "480px";
		elseif($typeflag == "weather3") $width = "150px";
		elseif($typeflag == "weather1000") $width = "150px";

		echo'<!--Weather in '. $city . ' ' . $country_name0.' widget - HTML code - openweather.com --><center>';


		if($typeflag == "weather2000" || $typeflag == "weather1000")
		{

			if($transparentflag != 1){
				$header_html = '<div align="center" style="width:'.$width . ';border:1px solid #ccc;background:#fff;font-color:#ddd;font-weight:bold;margin:15px 0px 0px 0px;">';
				$header_html .= $noscript_start ;
				$header_html .= '<a title="'. $title. '" style="font-size:12px;text-decoration:none;color:#000" href="'.$target_url.'">&nbsp;&nbsp;'.$title.'</a>';
				$header_html .= $noscript_end ;
			}
			else{
				$header_html = '<div align="center" style="width:'.$width . ';border:1px solid #ccc;;font-weight:bold;margin:15px 0px 0px 0px;';
				$header_html .= 'background:'.$background_color.';text-color:'.$text_color.'">';
				$header_html .= $noscript_start ;				
				$header_html .= '<a title="'. $title. '" style="font-size:12px;text-decoration:none;color:'.$text_color.'" href="'.$target_url.'">&nbsp;&nbsp;'.$title.'</a>' ;
				$header_html .= $noscript_end ;
			}
		}
		elseif($typeflag == "weather2" || $typeflag == "weather100" || $typeflag == "weather1"  || $typeflag == "weather3"){

			$header_html = '<div align="center" style ="font-size:12px!important;margin:10px 0px 0px 0px;line-height:18px;width:' . $width . ';padding-top:5px;padding-bottom:0px;';
			if($transparentflag ==1)
				$header_html .= 'border:1px solid #ccc;';
			$header_html .= 'background:'.$background_color.';text-color:'.$text_color.';color:'.$text_color.'">';

			$title2= $city . " Weather Forecast";
			if($typeflag == "weather1")
				$title2= "Current Weather in " . $city;

			$footer_html = $noscript_start;
			$footer_html .= '<a title="'. $title. '" style="font-weight:bold;align:center!important;text-align:center!important;font-size:10px;text-decoration:none;margin:0px!important;padding:0px!important;';
			$footer_html .= 'color:' . $text_color . ';" href="'.$target_url.'">'.$title2.'</a>';
			$footer_html .= $noscript_end ;

		}

		$footer_html .= '</div>';


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
  

}




?>