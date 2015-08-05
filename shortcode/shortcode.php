<?php
if(!class_exists('Shortcode_Social')){
    
    class Shortcode_Social{
        
        public function __construct(){
              parent::__construct();
        }
        
        public static function social_output($a){
            
              $html  = null;
              $path  = trim($a['path']);
              $type  = trim($a['type']);
              $layout  = trim($a['layout']);
              $title = trim($a['title']);
              
              $html .= '<div id="fb-root"></div>
                        <script>(function(d, s, id) {
                          var js, fjs = d.getElementsByTagName(s)[0];
                          if (d.getElementById(id)) return;
                          js = d.createElement(s); js.id = id;
                          js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
                          fjs.parentNode.insertBefore(js, fjs);
                        }(document, "script", "facebook-jssdk"));</script>
                        <div class="fb-like" data-href="'.$path.'" data-layout="'.$layout.'" data-action="'.$type.'" data-show-faces="true" data-share="true"></div>';
                        
              return $html;  
        }
        
        public static function social_post_filter($a){
              
              $html = null;
              $path = get_permalink($a->ID);
              
              $html .= '<div class="border-fb-wrapper">';
              $html .= '<div id="fb-root"></div>
                        <script>(function(d, s, id) {
                          var js, fjs = d.getElementsByTagName(s)[0];
                          if (d.getElementById(id)) return;
                          js = d.createElement(s); js.id = id;
                          js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
                          fjs.parentNode.insertBefore(js, fjs);
                        }(document, "script", "facebook-jssdk"));</script>
                        <div class="fb-like" data-href="'.$path.'" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>';
              $html .= '</div>';
                     
              echo $html;
               
        }
        
        public static function social_page_filter($a){
              
              $html = null;
              $path = get_permalink($a->ID);
              
              $html .= '<div class="border-fb-wrapper">';
              
              $html .= '<div id="fb-root"></div>
                        <script>(function(d, s, id) {
                          var js, fjs = d.getElementsByTagName(s)[0];
                          if (d.getElementById(id)) return;
                          js = d.createElement(s); js.id = id;
                          js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
                          fjs.parentNode.insertBefore(js, fjs);
                        }(document, "script", "facebook-jssdk"));
                        </script>
                        <div class="fb-like" data-href="'.$path.'" data-layout="button" data-action="like" data-show-faces="false" data-share="true"></div>';
              
              $html .= '</div>';
                     
              echo $html;
               
        }
        
    }

}