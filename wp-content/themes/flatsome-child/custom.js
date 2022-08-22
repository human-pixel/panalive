jQuery(document).ready(function(){
    jQuery("body").on('click','li.has-child a[href="#support"]',function(){
       jQuery(this).parent().find('.toggle').trigger('click');
    });
})