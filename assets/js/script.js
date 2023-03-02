

$(document).ready(function(){
    $(".select2").select2({
        placeholder: "Select one",
      allowClear: true
    });
    $(".select2_non_clear").select2({
        placeholder: "Select one"
    });
                 
         $( '.daterange' ).daterangepicker({
		locale: {
			format: 'DD/MM/YYYY'
		}
	});
        $('.datepicker').datetimepicker({
		//viewMode: 'years',
		format: 'dd-mm-yyyy',
                todayHighlight: !0, autoclose: !0, startView: 2, minView: 2, forceParse: 0, pickerPosition: "bottom-left"
	});
        $('.datetimepicker').datetimepicker({
		//viewMode: 'years',
		format: 'DD-MM-YYYY HH:mm:ss'
	});
    
    $('.reminder-link').on('click', function(){
        //e.preventDefault();
        var me = $(this);
        var kd = me.attr('data-id');
        var uri = me.attr("data-uri");
        var link = me.attr("href");
        //alert(kd);
        $.ajax({
               url: uri+"/"+kd,
               type: 'post',
               dataType: 'json'
           });
    });
        
});
function myFileBrowser (field_name, url, type, win) {

    // alert("Field_Name: " + field_name + "nURL: " + url + "nType: " + type + "nWin: " + win); // debug/testing

    /* If you work with sessions in PHP and your client doesn't accept cookies you might need to carry
       the session name and session ID in the request string (can look like this: "?PHPSESSID=88p0n70s9dsknra96qhuk6etm5").
       These lines of code extract the necessary parameters and add them back to the filebrowser URL again. */

    var cmsURL = window.location.toString();    // script URL - use an absolute path!
    if (cmsURL.indexOf("?") < 0) {
        //add the type as the only query parameter
        cmsURL = cmsURL + "?type=" + type;
    }
    else {
        //add the type as an additional query parameter
        // (PHP session ID is now included if there is one at all)
        cmsURL = cmsURL + "&type=" + type;
    }

    tinyMCE.activeEditor.windowManager.open({
        file : cmsURL,
        title : 'My File Browser',
        width : 420,  // Your dimensions may differ - toy around with them!
        height : 400,
        resizable : "yes",
        inline : "yes",  // This parameter only has an effect if you use the inlinepopups plugin!
        close_previous : "no"
    }, {
        window : win,
        input : field_name
    });
    return false;
  }  
//NumberToMoneyId untuk konversi angka ke bentuk uang yg datanya berasal dari text dan diubah dalam bentuk format uang indonesia
function NumberToMoneyId(Str){
    var Data=Str.replace(/[^0-9-,]/g, '');
    var nilai;
    var temp;
    var temp2;
    if (Data.indexOf(',') > -1) {
        temp=Data.split(',') ;
        nilai=temp[0];
    }else if (Data.indexOf('-') > -1) {
        temp2="1" ;
        nilai=Data;
    }else{
        nilai=Data;
    }
    
    if(nilai!='-'){
        nilai=parseFloat(nilai);
    }
    if(!isNaN(nilai)){
//        alert('tes');
        var num = nilai.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
        if(temp!== undefined){
            temp[0]=num;
            num=temp.join();
            
        }
    }else{
        if(temp2=='1'){
            num=nilai;
        }else{
            num='';
        }
    }
    
    return num;
}
//NumberToMoney untuk konversi angka ke bentuk uang yg datanya berasal dari text dan diubah dalam bentuk format uang luar negeri
function NumberToMoney(Str){
    var Data=Str.replace(/[^0-9-.]/g, '');
    var nilai;
    var temp;
    var temp2;
    if (Data.indexOf('.') > -1) {
        temp=Data.split('.') ;
        nilai=temp[0];
    }else if (Data.indexOf('-') > -1) {
        temp2="1" ;
        nilai=Data;
    }else{
        nilai=Data;
    }
    nilai=parseFloat(nilai);
    if(!isNaN(nilai)){
        var num = nilai.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        if(temp!== undefined){
            temp[0]=num;
            num=temp.join('.');
        }
    }else{
        if(temp2=='1'){
            num=nilai;
        }else{
            num='';
        }
    }
    return num;
}
//NumberToMoney2 untuk konversi angka ke bentuk uang yg datanya berasal dari tipe data float
function NumberToMoney2(Str){
    var Data=Str.toString().replace(/[^0-9-.]/g, '');
    var nilai;
    var temp;
    var temp2;
    if (Data.indexOf('.') > -1) {
        temp=Data.split('.') ;
        nilai=temp[0];
    }else if (Data.indexOf('-') > -1) {
        temp2="1" ;
        nilai=Data;
    }else{
        nilai=Data;
    }
    nilai=parseFloat(nilai);
    if(!isNaN(nilai)){
        var num = nilai.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
        if(temp!== undefined){
            temp[0]=num;
            num=temp.join();
        }
    }else{
        if(temp2=='1'){
            num=nilai;
        }else{
            num='';
        }
    }
    return num;
}

function MoneyToNumber(Str){
    var Data=Str.replace(/[^0-9-,]/g, '');
    var nilai;
    var temp;
    if (Data.indexOf(',') > -1) {
        temp=Data.split(',') ;
        nilai=temp.join('.');
    }else{
        nilai=Data;
    }
    nilai=parseFloat(nilai);
    return nilai;
}
//function deleteData(Id,UriDelete,DelMessage,UriRedirect) {
//        swal({
//          title: "Apakah anda yakin?", 
//          text: "Apakah anda yakin untuk menghapus data ini?", 
//          type: "warning",
//          showCancelButton: true,
//          closeOnConfirm: false,
//          confirmButtonText: "Yes, delete it!",
//          confirmButtonColor: "#ec6c62"
//        }, function() {
//          $.ajax({
//            url: UriDelete +"/"+ Id,
//            type: "DELETE"
//          })
//          .done(function(data) {
//            swal({
//                title: "Deleted!",
//                text: DelMessage,
//                type: "success",
//                confirmButtonText: "OK"
//            },
//            function(isConfirm){
//              if (isConfirm) {
//                window.location = UriRedirect;
//              }
//            });
//          })
//          .error(function(data) {
//            swal("Oops", "We couldn't connect to the server!", "error");
//          });
//        });
//      }
function get_nama_bulan(bulan){
    var nm_bulan='';
    switch (bulan) {
        case "1" : nm_bulan = "January";break;
	case "01" : nm_bulan = "January";break;
	case "2" : nm_bulan = "February";break;
	case "02" : nm_bulan = "February";break;
	case "3" : nm_bulan = "March";break;
	case "03" : nm_bulan = "March";break;
	case "4" : nm_bulan = "April";break;
	case "04" : nm_bulan = "April";break;
	case "5" : nm_bulan = "May";break;
	case "05" : nm_bulan = "May";break;
	case "6" : nm_bulan = "June";break;
	case "06" : nm_bulan = "June";break;
	case "7" : nm_bulan = "July";break;
	case "07" : nm_bulan = "July";break;
	case "8" : nm_bulan = "August";break;
	case "08" : nm_bulan = "August";break;
	case "9" : nm_bulan = "September";break;
	case "09" : nm_bulan = "September";break;
	case "10" : nm_bulan = "October";break;
	case "11" : nm_bulan = "November";break;
	case "12" : nm_bulan = "December";break;
        default :nm_bulan = "";break;
       
      }
      return nm_bulan;
}
function deleteData(Id,UriDelete,DelMessage,UriRedirect,title,TextMessage) {
    swal({
          title: title, 
          text: TextMessage, 
          type: "warning",
          showCancelButton: true,
          //closeOnConfirm: false,
          confirmButtonText: "Yes, delete it!",
          confirmButtonColor: "#ec6c62",
          preConfirm: function() {
              return new Promise(function(resolve) {
                $.ajax({
                    url: UriDelete +"/"+ Id,
                    type: "POST"
                  })
                  .done(function(data) {

                    swal({
                        title: "Deleted!",
                        text: DelMessage,
                        type: "success",
                        confirmButtonText: "OK"
                    }).then(function(){
                        window.location = UriRedirect;
                    });
                  })
                  .fail(function(data) {
                    swal("Oops", "We couldn't connect to the server!", "error");
                  });
                });
          }
    });
        
      }

function WarningAlert(Message)
{
    swal("Warning!",Message, "warning");
}

var mQuickSidebar2 = function() {
    var t = $("#m_quick_sidebar2"),
        e = $("#m_quick_sidebar_tabs2"),
        a = t.find(".m-quick-sidebar__content2"),
        n = function() {
            var a, n, o, i;
            a = mUtil.find(mUtil.get("m_quick_sidebar_tabs_messenger"), ".m-messenger__messages"), n = $("#m_quick_sidebar_tabs_messenger .m-messenger__form"), mUtil.scrollerInit(a, {
                disableForMobile: !0,
                resetHeightOnDestroy: !1,
                handleWindowResize: !0,
                height: function() {
                    return t.outerHeight(!0) - e.outerHeight(!0) - n.outerHeight(!0) - 120
                }
            }), (o = mUtil.find(mUtil.get("m_quick_sidebar_tabs_settings"), ".m-list-settings")) && mUtil.scrollerInit(o, {
                disableForMobile: !0,
                resetHeightOnDestroy: !1,
                handleWindowResize: !0,
                height: function() {
                    return mUtil.getViewPort().height - e.outerHeight(!0) - 60
                }
            }), (i = mUtil.find(mUtil.get("m_quick_sidebar_tabs_logs"), ".m-list-timeline")) && mUtil.scrollerInit(i, {
                disableForMobile: !0,
                resetHeightOnDestroy: !1,
                handleWindowResize: !0,
                height: function() {
                    return mUtil.getViewPort().height - e.outerHeight(!0) - 60
                }
            })
        };
    return {
        init: function() {
            0 !== t.length && new mOffcanvas("m_quick_sidebar2", {
                overlay: !0,
                baseClass: "m-quick-sidebar2",
                closeBy: "m_quick_sidebar_close2",
                toggleBy: "m_quick_sidebar_toggle2"
            }).one("afterShow", function() {
                mApp.block(t), setTimeout(function() {
                    mApp.unblock(t), a.removeClass("m--hide"), n()
                }, 1e3)
            })
        }
    }
}();
$(document).ready(function() {
    mQuickSidebar2.init()
});