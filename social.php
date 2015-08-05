<?php
/**
  * Plugin Name: FB Social
  * Plugin URI: http://plontacreative.com/wp-plugins/zip/
  * Description: Allows admin to inject a social type of a post to display
  * Version: 1.0.1
  * Author: Charly Capillanes
  * Author URI: https://charlycapillanes.wordpress.com/
*/

include_once 'shortcode/shortcode.php';
include_once 'form.php';

if( !class_exists('Social')){
    
    class Social{
        
        public function __construct(){
             
             if( !is_admin()){
                wp_enqueue_style( 'social-front', plugins_url('social/css/front.css') );
                
             } else {
                
                wp_enqueue_style( 'social-admin', plugins_url('social/css/admin.css') );
                wp_enqueue_script( 'social-script-admin', plugins_url('social/js/admin.js'), array( 'jquery' ) ); 
             }
             
             add_action( 'admin_menu', array($this,'social_page_menu'));
             
             add_action( 'admin_init', array($this,'social_add')); 
             
             add_shortcode( 'social', array($this,'social_function'));
             
             add_action('genesis_post_meta', array($this,'custom_post_meta') );
             
             //add_filter( 'the_content', array($this,'fb_the_content_function') );
             add_action( 'genesis_after_post_content', array($this,'custom_page_meta') );
             
             add_filter('site_transient_update_plugins', array($this,'remove_update_notification') );
        }
        
        public function remove_update_notification($value) {
             unset($value->response[plugin_basename(__FILE__)]);
             return $value;
        }
        
        public function social_page_menu(){
             add_options_page( 'FB Social Options', 'FB Social Plugin', 'manage_options', 'social_options_handler', array($this,'social_options') );
        }
        
        public function social_options(){
             Form_Social::form_page_social();
        }
        
        public function social_function($atts){
             global $wpdb, $post;
              
             $social_path = get_option( 'social_path' );
             $social_type = get_option( 'social_type' );
             $social_layout = get_option( 'social_layout' );
             
             $a = shortcode_atts( array(
                                          'path'   => $social_path,
                                          'type'   => $social_type,
                                          'layout' => $social_layout,
                                          'title'  => 'Gwen Pullman',
                                ), $atts );
                                
             return Shortcode_Social::social_output($a);
        }
    
        public function custom_post_meta(){
            global $post;
    
            if(is_single()) {
                
                //Shortcode_Social::social_post_filter($post);
            
            } 
    
        }
        
        public function custom_page_meta(){
            global $post;
            
            $not_default = array( 15 );
            
            if( isset($post->ID)){
            
                if( is_page() AND !in_array($post->ID, $not_default)) {
                    
                    //Shortcode_Social::social_post_filter($post);
                
                } 
            
            }    
            
        }
        
        public function social_add(){
            
            $_post       = isset($_POST) ? $_POST : null;
            $_get        = isset($_GET) ? $_GET : null;
            $this->input = (object)array( 'post' => (object)$_post, 'get' => (object)$_get );
            $social_path = get_option( 'social_path' );
            $autoload    = 'yes';
            $deprecated  = null;
              
            if( isset( $this->input->post->socialsubmit ) ){
                 
                $path   = trim( $this->input->post->social_text );
                $type   = trim( $this->input->post->social_type );
                $layout = trim( $this->input->post->social_layout );
                 
                if(!empty($path)){
                     
                        if( $social_path !== false  ){
                            
                            update_option( 'social_path', $path );
                            update_option( 'social_type', $type );
                            update_option( 'social_layout', $layout );
                             
                        } else {
                            
                            add_option( 'social_path', $path, $deprecated, $autoload ); 
                            add_option( 'social_type', $type, $deprecated, $autoload ); 
                            add_option( 'social_layout', $layout, $deprecated, $autoload ); 
                        }
                 
                }
    
            }
              
        }
    
    }

}

$Social = new Social();
