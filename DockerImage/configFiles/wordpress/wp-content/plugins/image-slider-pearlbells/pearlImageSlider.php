<?php
/*
Plugin Name: Image Slider / Slideshow Pearlbells
Plugin URI: http://pearlbells.co.uk/
Description: Image Slider Pearlbells
Version:  4.0
Author:Pearlbells
Author URI: http://pearlbells.co.uk/contact-page
License: GPL2
*/
/*
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version. 

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details. 

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.

*/
namespace imagesliderpearlbells;
include_once 'includes/form.php';
include_once 'includes/data.php';
include_once 'includes/optionsValues.php';
include_once 'includes/style.php';

class pearlImageSlider {
    
     private $objOptions;
     public function __construct() {
         add_action( 'admin_menu', array( $this, 'menu' ) );
         $this->objOptions = new pearlImageOptionsValues;
         $this->objOptions->add_options();
         new pearlImageSliderData;
         new pearlImageStyleData;
         register_deactivation_hook(__FILE__, array( $this, 'pearl_uninstall' ));
         
     }
     
     public function pearl_uninstall() {
         $this->objOptions->delete_options();
     }
     
     public function menu() {
        add_options_page('Image Slider','Image Slider','manage_options',__FILE__,array($this,'opt_page')); 
         
     }
  
     public function opt_page() {
         
         $this->postData();
     }
     
     public function postData() {
         
        if($_REQUEST['submit']) {
            $this->objOptions->update_options();
           
        }
        
        new pearlDisplayForm;
    }
     
}

new pearlImageSlider;
?>