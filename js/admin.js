jQuery(function(){
      
       jQuery("a.posts-selected").click(function(e){
             
            var val = jQuery(this).find('input').val(); 
            
            jQuery("input#social_text").attr('value',val);
            
            return false;
       });
       
       jQuery("div.posts-select-item").click(function(e){
             
            var val = jQuery(this).find('input').val(); 
            
            jQuery("input#social_text").attr('value',val);
            
            return false;
       });
       
});