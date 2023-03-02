<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>	

<script language="javascript" type="text/javascript">
   
$(function() {
    var start = moment([]);
    var end = moment([]);

    function cb(start, end) {
        var text;
        if(start.format('MMM D, YYYY') == moment().format('MMM D, YYYY')){
            text='today : '+start.format('MMM D');
        }else if(start.startOf('day').unix() == moment().subtract(1, 'days').startOf('day').unix()){
            text='Yesterday : '+start.format('MMM D');;
        }else{
            text =start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY');
        }
        $('#reportrange span').html(text);
         var dataURL = "<?php echo site_url('akses/Notifikasi/list_notifikasi/')?>"+start.format('YYYY-MM-DD')+"/"+end.format('YYYY-MM-DD');
            $('#list-timeline').load(dataURL);
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        useCurrent:'day',
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);

});

    jQuery(document).ready(function() {
     
 
            
    
});
</script>