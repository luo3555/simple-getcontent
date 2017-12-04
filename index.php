<?php
require_once('vendor/autoload.php');

function isChecked($num)
{
    if (isset($_GET['prefix'])) {
        return $_GET['prefix'] == $num ? 'checked="checked"' : '';
    } else {
        return $num == 1 ? 'checked="checked"' : '' ;
    }
    return false;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>PHP Get Content</title>
<meta name="description" content="">
<meta name="keywords" content="">
<style>
html,body {
    position: relative;
    height: 100%;
}
iframe {
    width: 100%;
    height: 99%;
}
#mysubmit {
    width: 75px;
    height: 50px;
}
</style>
<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
jQuery(function(){
    jQuery('form').submit(function(event){
        event.preventDefault();
        // input domain
        if (jQuery('#domain').val().length<1) {
            jQuery('#domain').val(jQuery('#url').val());
            console.log('domain:' + jQuery('#url').val());
        }

        jQuery.ajax('/content.php',{
            type:'post',
            dataType:'html',
            data: jQuery('form').serialize(),
            success: function(url){
                jQuery('iframe').attr('src', url);
            }
        });
        return false;
    });
});
</script>
</head>
<body>
<form id="form" method="get" action="#">
    <input name="prefix" <?php echo isChecked(1) ?> type="radio" value="1" />HTTP
    <input name="prefix" <?php echo isChecked(2) ?> type="radio" value="2" />HTTPS
    Domain:<input id="domain" name="domain" value="<?php echo $_GET['domain'] ?>"/>
    URL:<input id="url" name="url" value="<?php echo $_GET['url'] ?>"/>
    <button id="mysubmit" type="submit">Submit</button>
</form>
<iframe src=""/>
</body>
</html>