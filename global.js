jQuery(function(){
    jQuery('a').click(function(){
        var $parent = jQuery(window.parent.document);
        // change url
        var url = jQuery(this).attr('href');
        jQuery('#url', $parent).val(url);
        console.log(url);
        return false;
    });
});