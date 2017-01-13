var EPosUiBlock = {
 show_loading : function (){
      App.startPageLoading({animate: true});
},
  hide_loading : function (){
      App.stopPageLoading();
}
};
var sort_by = function(field, reverse, primer){

   var key = primer ? 
       function(x) {return primer(x[field])} : 
       function(x) {return x[field]};

   reverse = !reverse ? 1 : -1;

   return function (a, b) {
       return a = key(a), b = key(b), reverse * ((a > b) - (b > a));
     } 
}
jQuery.fn.EPosMessage = function(type, message){
    type = type==''?'success':type;
    jQuery(this).html('');
    if(type == "success"){
        var messageElem = jQuery("<div class=\"alert alert-success\"><button class='close' data-close='alert'></button>&nbsp;&nbsp;"+message+"</div>");
    }else{
        var messageElem = jQuery("<div class=\"alert alert-danger\"><button class='close' data-close='alert'></button>&nbsp;&nbsp;"+message+"</div>");
    }
    jQuery(this).append(messageElem);
    messageElem.fadeIn(500).delay(5000).fadeOut(500);
};
function GetAllValueForm (elem){
    var map = {};
    jQuery(elem+' input').each(function() {
        if(jQuery(this).attr("type")=='radio'){
           map[jQuery(this).attr("name")] = jQuery('input[name=radio]:checked', '#radio').val();
        }else{
           map[jQuery(this).attr("name")] = jQuery(this).val();
        }
    });
    jQuery(elem+' textarea').each(function() {
        map[jQuery(this).attr("name")] = jQuery(this).val();
    });
    jQuery(elem+' select').each(function() {
        map[jQuery(this).attr("name")] = jQuery(this).find('option:selected').val();
    });
        return map;
}




function RequestURLWaiting(url, returnType, postData,callback,displayLoading) {
    if(displayLoading){
        EPosUiBlock.show_loading();
    }
    jQuery.ajax({
        url: url,
        type: "POST",
        data: postData,
        dataType: returnType,
        success: function (result) {
            callback(result); 
            if(displayLoading) {
                EPosUiBlock.hide_loading();
            }
        },
        error: function(){
            jQuery.ajax({
                url: url,
                type: "POST",
                data: postData,
                async: true,
                dataType: returnType,
                success: function (result) {
                    callback(result); 
                    if(displayLoading) {
                       EPosUiBlock.hide_loading();
                    }
                },
                error: function(){
                    EPosUiBlock.hide_loading();
                }
            });
        }
    });
}
function GetAllValue(elem){
    var arr = {};
    jQuery(elem+" input[type='text']").each(function() {
        arr[jQuery(this).attr("name")] = jQuery(this).val();
    });
    jQuery(elem+" input[type='checkbox']").each(function() {
        arr[jQuery(this).attr("name")] = jQuery(this).bootstrapSwitch('state') == true ? 1 : 0;
    });
    return arr;
}

  function formatMultiImage(img){
    var iP;var result='';var iC;var results ='';var image; 
    if(img==null){
        image = '';    
    }else if (img.length>1){
      $.each(img, function(k, v) {            
             if(k==1){
             iC = "<li data-target='#myCarousel' data-slide-to="+k+" class='active'></li>";
             iP = "<div class='item active'><img height='250' width='200' src='"+App.getHostPath()+v.thumb+"'></div>";
             }else{
             iC = "<li data-target='#myCarousel' data-slide-to="+k+"></li>";
             iP = "<div class='item'><img height='250' width='200' src='"+App.getHostPath()+v.thumb+"' class='img-responsive' alt=''></div>";
            }
             result += iP;
             results += iC;
                });
    image = '<button class="btn btn-icon-only yellow popovers" data-container="body" data-trigger="hover" data-placement="top"><div class="content hide"><div id="myCarousel" class="carousel slide" data-ride="carousel"><ol class="carousel-indicators">'+results+'</ol><div class="carousel-inner">'+result+'</div></div></div><i class="icon-camera"></i></button>';
    }else if(img.length==1){
    image = '<button class="btn btn-icon-only yellow popovers" data-container="body" data-trigger="hover" data-placement="top" data-content="<img height='+"250"+' width='+"200"+' src='+"'"+App.getHostPath()+img[0].thumb+"'"+'>" ><i class="icon-camera"></i></button>';    
    }else{
    image = '';    
    }
    return image;
 }
  function formatImage(img){
    var image = '<button class="btn btn-icon-only yellow popovers" data-container="body" data-trigger="hover" data-placement="top" data-content="<img height='+"150"+' width='+"150"+' src='+"'"+App.getHostPath()+img+"'"+'>" ><i class="icon-camera"></i></button>';
    return image;
 }
 function formatDate(date){
     if(date){
     var from = date.substr(0,10).split("-");
     var date_string = from[2]+ "/" +from[1]+ "/" + from[0];
    return date_string;
     }else{
     var date_string = '00/00/0000';
      return date_string;
     }
 }
  function formatDateDefault(date){
     if(date){
     var from = date.substr(0,10).split("/");
     var date_string = from[2]+ "-" +from[1]+ "-" + from[0];
    return date_string;
     }else{
     var date_string = '0000-00-00';
      return date_string;
     }
 }
  function formatDateTime(date){
     var from = date.substr(0,10).split("-");
     var time = date.substr(11);
     var date_string = from[2]+ "-" +from[1]+ "-" + from[0]+" "+time;
    return date_string;
 }
 function formatNumber(data){
     var number = $.number(data, 0,',','.');
     return number;
 }
 function formatDecimal(data,dec){
     var number = $.number(data, dec ,',','.');
     return number;
 }
  function formatText(data){
      var text;
     if(data&&data.length >30){
         text = data.substr(0,30)+' ...';
     }else{
         text = data;
     }
     return text;
 }
 function formatGroup(api,column){      
            var rows = api.rows( {page:'current'} ).nodes();
            var last = null;
            api.column(column, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group" group="'+group.split(' ').join('-')+'"><td colspan = "12"><a href="javascript:;"><i class="fa fa-minus"></i> '+group+'</a></td></tr>'
                    );
 
                    last = group;
                }
            } );
 } 
 
 
 function formatAddText(data,text){
                 var result = text+data;
                 return result;
             };
 function formatGetValue(data,elem,type){
          var result = '';
           if(type==1){
             result = jQuery(elem).find('span#'+data).text();   
           }else if(type==2){//select
             result = jQuery(elem).find('option[value='+data+']').text();   
           }else if(type==3){//checkbox
               var arr = jQuery.trim(data).split(' ');
               for(var i = 0 ; i < arr.length; i++){
               result += jQuery(elem).find('span#'+arr[i]).text()+' ';         
               }             
           }else if(type==4){//multi select2
              var arr = jQuery.trim(data).split(',');
               for(var i = 0 ; i < arr.length; i++){
               result += jQuery(elem).find('option[value='+arr[i]+']').text()+',';        
               }              
           }else if(type==5){//radio bootstrap
               result = jQuery(elem).find('input[value='+data+']').parent().text(); 
           }
             return result;
 };

 function formatActive(data){
                 var result = '';
                 if(data==1){
                    result = '<span class="label label-sm label-success">'+transText["active"]+'</span>';
                 }else{
                    result = '<span class="label label-sm label-danger"> '+transText["none_active"]+' </span>';
                 }
                 return result;
             };
             
  function formatSecurity(data){
                var result = '';
                 for ( var i = 0; i < data.length; i++) { 
                    result += "*";
                }
                 return result;
             };           
  function formatColor(data){
                 var result = '';
                 if(data){
                    result = '<span style="background-color: '+data+';">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>';
                 }
                 return result;
             };
 function runningFormatter(value, row, index) {
        return (index+1);
        }

function totalTextFormatter(data) {
    return 'Total';
}

function totalFormatter(data) {
    return data.length;
}

function sumFormatter(data) {
    var field = this.field;
    var total = data.reduce(function(sum, row) { 
        return sum + (+row[field]);
    }, 0);
    return $.number(total, 0,',','.');
}

function avgFormatter(data) {
    return $.number(sumFormatter.call(this, data).split('.').join('') / data.length, 0,',','.');
}
function priceFomatter(value){
    return $.number(value, 0,',','.');
}
function GetValueFomatter(value, row){
    var data = jQuery('#'+this.field).find('option[value='+value+']').text();   
    return data;
}
 function getWeekDay(d){
    var weekday = new Array(7);
    weekday[0] = "Sun";
    weekday[1] = "Mon";
    weekday[2] = "Tue";
    weekday[3] = "Wed";
    weekday[4] = "Thu";
    weekday[5] = "Fri";
    weekday[6] = "Sat";

    var n = weekday[d.getDay()];
    return n;
 };
                 //Month is 1 based
function daysInMonth(month,year) {
    return new Date(year, month, 0).getDate();
}