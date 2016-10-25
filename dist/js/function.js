jQuery(document).ready(function () {
    
     if (jQuery("select#example1_length").length > 0) {

                        jQuery("select#example1_length").change(function () {

                            var searchdata = jQuery('form input#search').val();
                            var name = jQuery('form input#search').attr('name');
                            if (searchdata != '' && searchdata !== undefined) {
                                window.location.href = currentUrl + '?' +name + '=' + searchdata + '&limit=' + jQuery(this).val();
                            } else {
                                window.location.href = currentUrl + '?' + 'limit='+ jQuery(this).val();
                            }
                        })
                    }

    
    
    
    /* var win = jQuery(window);
    win.scroll(function () {
        if (jQuery(document).height() - win.height() == win.scrollTop()) {
            var frmdata = jQuery('#frm').serialize();
            //alert(frmdata['pg']);
            var pg = $("input#pg").val();
            pg = Number(pg) + 1;
            $("input#pg").val(pg);
            var show_records = $("input#show_records").val();
            var show = $('input#show').val();
            var totalPages = $("input#totalPages").val();
            totalPages = Number(totalPages);
           
            if (totalPages <= 1) {
                $("div.Expand").html(' ');
            }
            var rand = Math.floor(Math.random() * 999999);
            if (show_records == "true" && oldpg == 1) {
                $.ajax({
                    url: 'ajax/ajax-city.php',
                    data: frmdata,
                    type: "post",
                    async: false,
                    success: function (html) {
                        if (html) {
                            dataload = html;

                        }
                    }


                });
            }
            if (totalPages <= pg) {
                $("input#show_records").val("false");
                //$("div.Expand").html('End of Results');
            }

        }
    });
  */
});