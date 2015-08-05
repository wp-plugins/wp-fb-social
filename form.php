<?php
if(!class_exists('Form_Social')){
    
    class Form_Social{
        
        public function __construct(){
              parent::__construct();
        }
        
        public static function social_code(){
               return '<code>[social]</code>';
        }
        
        public static function view_like_button($path,$type,$layout){
               
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
        
        public static function social_type_array(){
            
               $html = null;
               
               $social_type = get_option( 'social_type' );
                
               $type = array(
                                 'like' => 'Like',
                                 'recommend' => 'Recommend'
                             );
                             
               foreach($type as $type_key => $type_result){
                    
                    $isf_value = $type_key == $social_type ? "selected=''" : false;
                    
                    $key_value = trim($type_key);
                    $res_value = trim($type_result);
                    
                    $html .= '<option value="'.$key_value.'" '.$isf_value.'>'.$res_value.'</option>';
                    
               }
               
               return $html;
               
        }
        
        public static function social_layout_array(){
               
               $html = null;
               
               $social_layout = get_option( 'social_layout' );
               
               $layout = array(
                                     'standard' => 'Standard',
                                     'box_count' => 'Box Count',
                                     'button_count' => 'Button Count',
                                     'button' => 'Button',   
                               );
                               
                foreach($layout as $layout_key => $layout_result ){
                    
                    $isf_value = $layout_key == $social_layout ? "selected=''" : false;
                    
                    $key_value = trim($layout_key);
                    $res_value = trim($layout_result);
                    
                    $html .= '<option value="'.$key_value.'" '.$isf_value.'>'.$res_value.'</option>';
                    
               }
               
               return $html;
                    
        } 
        
        public static function form_page_social($type=null){
           global $wpdb;
              
              $type_match = array( 'post', 'page' );
              $taxonomies = get_taxonomies(); 
              
              if( !empty($type)){
                   if( in_array($type, $type_match)){
                       $and = "AND post_type='".$type."'";
                   } else {
                       $and = null; 
                   }
              } else {
                   $and = null;
              }
               
              $html        = null;
              
              $social_path = get_option( 'social_path' );
              $social_type = get_option( 'social_type' );
              $social_lay  = get_option( 'social_layout' );
              
              $prefix      = $wpdb->prefix;
              $tbl         = $prefix.'posts';    
              $query       = $wpdb->get_results("SELECT * FROM $tbl WHERE post_status='publish' $and" );
              
              $html .= '<h2>FB Social Option'.__(Form_Social::social_code()).'</h2>'; 
              if( empty( $social_path ) ) {
                  $html .= "<div class='fb-social-warning'>Please . input path field for your path filter page .</div>";
              }

              $html .= '<p>Save a option for your selected facebook page url(path) .</p>';
              
              $html .= '<form method="post" id="form-social">';
              
              //<div id="post-select-items">'.Form_Social::query_posts($query).'</div>

              $html .= '<table class="form-table">
                            <tbody>
                                <tr class="form-field form-required">
                                    <th scope="row">
                                        <label for="user_login">Path<span class="description">(required)</span></label>
                                    </th>
                                    <td>
                                        <input id="social_text" type="text" aria-required="true" value="'.$social_path.'" name="social_text">
                                    </td>
                                </tr>
                                <tr class="form-field form-required">
                                    <th scope="row">
                                        <label for="user_login">Action Type</label>
                                    </th>
                                    <td>
                                        <select id="social_type" class="social_type" name="social_type">'.Form_Social::social_type_array().'</select>
                                    </td>
                                </tr>
                                <tr class="form-field form-required">
                                    <th scope="row">
                                        <label for="user_login">Layout</label>
                                    </th>
                                    <td>
                                        <select id="social_layout" class="social_layout" name="social_layout">'.Form_Social::social_layout_array().'</select>
                                    </td>
                                </tr>
                                <tr class="form-field form-required output">
                                    <th scope="row">
                                        <label for="user_login"></label>
                                    </th>
                                    <td colspan="2">'.Form_Social::view_like_button($social_path,$social_type,$social_lay).'</td>
                                </tr>
                            </tbody>
                        </table>';
                        
              $html .= '<p class="submit"><input id="socialsubmit" class="button button-primary" type="submit" value="Save Changes" name="socialsubmit"></p>';
              
              $html .= '</form>';
              
              echo $html;
        }
        
        public static function query_posts($query=null){
              $html = null;
              
              if(!empty($query)){
                  
                  foreach($query as $query_keys => $query_vals ){
                        
                        $pID    = intval($query_vals->ID);
                        $pTitle = get_the_title($pID);
                        $pPath  = get_permalink($pID);
                        
                        if( !empty($pTitle) AND strlen($pTitle) >= 1 ){
                        
                            $html .= '<div class="posts-select-item">';
                            $html .= '<a href="#" class="posts-selected">'.$pTitle.'<input type="hidden" value="'.$pPath.'"></a>';
                            $html .= '</div>';
                        
                        }
                        
                  }
                   
              } 
              
              return $html;
        }
    
    }

}