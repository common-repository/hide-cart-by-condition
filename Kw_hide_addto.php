<?php
/**
 * @package Kw_hide_addto
 * @version 1.0.0
 */
/*
Plugin Name: Hide Cart By Condition.
Plugin URI: https://srinathdevinfo.github.io/Kw_hide_addto.html
Description: Disable Add to Cart Conditionally
Author: Srinath Madusanka
Version: 1.0.0
Author URI: https://srinathdevinfo.github.io/
License: GPLv2 or later
Text Domain: Kw_hide_addto
 */

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.


 */

// Exit if accessed directly.
defined('ABSPATH') or die();

if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    if (!class_exists('Kw_hide_addto')) {

        class Kw_hide_addto
        {



            protected $plugin_name;
   




            public function __construct()
            {
                 $this->plugin_name = 'Hide Cart';
                 add_filter('woocommerce_is_purchasable', array( $this, 'hidebycondition'), 10, 2);
                 add_filter('woocommerce_settings_tabs_array', array($this,'add_settings_tab'), 50);
                 add_action('woocommerce_settings_hide_cart', array($this,'add_settings'), 50);
                     add_action('woocommerce_update_options_hide_cart', array($this,'update_settings'), 50);
            }



           
 
            public function add_settings_tab($settings_tabs)
            {
                $settings_tabs['hide_cart']=__('Hide Cart', 'Kw_hide_addto');


                return $settings_tabs;
            }

            
            public function add_settings()
            {
                woocommerce_admin_fields(self::get_settings());
            }

            public function update_settings()
            {

                woocommerce_update_options(self::get_settings());
            }
          


            public static function get_settings()
            {

                $settings=array(
                    'section_title'=>array(
                        'name'=>__('Hide Cart', 'Kw_hide_addto'),
                        'type'=>'title',
                        'desc'=>'',
                        'id'=>''

                    ),

                  'hide_on_always'=>array(
                       'name'=>__('Hide Cart button Always', 'Kw_hide_addto'),
                        'type'=>'checkbox',
                        'desc'=>__('Hide Cart Button Always', 'Kw_hide_addto'),
                        'id'=>'Kw_hide_addto_hide_allways'

                    ),


                    
                      'hide_on_weekends'=>array(
                       'name'=>__('Hide Cart on Weekends', 'Kw_hide_addto'),
                        'type'=>'checkbox',
                        'desc'=>__('Hide Cart Button on Weekends', 'Kw_hide_addto'),
                        'id'=>'Kw_hide_addto_hide_end'

                    ),



                'hide_on'=>array(
                'name' => __('Hide Cart on'),
                'type' => 'select',
                'desc' => __('hide cart on selected day'),
                'desc_tip' => true,
                'id'    => 'hide_on',
                'options' => array(
                           'show' => __('Please Select '),
                          'monday' => __('Monday'),
                          'tuesday' => __('Tuesday'),
                           'wednesday' => __('Wednesday'),
                          'thursday' => __('Thursday'),
                           'friday' => __('Friday'),
                           'saturday' => __('Saturday'),
                          'sunday' => __('Sunday'),

                )

                ),











                      'section_end'=>array(
                        'type'=>'sectionend',
                         'id'=>'Kw_hide_addto_hide_weekends'
                        

                    )




                );
                return $settings;
            }



            function hidebycondition()
            {
             
            
                $Kw_hide_addto_hide_allways=get_option('Kw_hide_addto_hide_allways');
                $Kw_hide_addto_hide_end=get_option('Kw_hide_addto_hide_end');
                $hide_on=get_option('hide_on');
                $current_date= date('l');
                if ($Kw_hide_addto_hide_allways=='yes') {
                         return false;
                } elseif ($Kw_hide_addto_hide_end =='yes') {
                         return false;
                } elseif ($hide_on== strtolower($current_date)) {
                    return false;
                } else {
                    return true;
                }
            }
        }
    }
}
if (class_exists('Kw_hide_addto')) {
    $Kw_hide_addto = new Kw_hide_addto();
}
