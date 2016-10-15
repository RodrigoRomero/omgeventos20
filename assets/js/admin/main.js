var _exception      = new RrException();
$(document).ready(function(){    
    initTables();    
    init();
});
function exists(el) {
    return ($(el).length > 0) ? true : false;
}


function init(){
    if(typeof Shadowbox != 'undefined'){
        Shadowbox.init({players:  ['img', 'html', 'iframe', 'qt', 'wmp', 'swf', 'flv']});
    }
    init_tabs();
    $('#j-Menu li').live('click',function(e){
        var setActive = $(this).attr('data-menu');
        setLocalStorage('active',setActive);
        $(this).each(function(){
            removeAcitevesMenu();
            if($(this).attr('data-menu')==localStorage.getItem('active')){
                $(this).addClass('active')    
            }
        });
    });
    $("#j-Menu li").each(function(index){
        $(this).removeClass('active');
        if($(this).attr('data-menu')==localStorage.getItem('active')){
            $(this).addClass('active')    
        }
    });
    if(exists(('.datepicker'))) {
        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            language: 'es'
            });
    }
    if(exists(('.timepicker'))){
        $('.timepicker').timepicker({
            minuteStep: 5,
            showMeridian: false,
            showSeconds: true,        
            });
    }
    $("a.ax-modal" ).live('click',function(event) {
        event.preventDefault();
        var url = $(this).attr('href');        
        frm_send('none',url,'abc');
        });
    if(exists(('#fullcalendar'))) {
        fullCalendar();
    }
    init_tooltips();
    init_upload_manager();
    /*
    $('.j-enter').each(function(index) {
		$(this).keypress(function(event) {
			if (event.which == 13) {
				var onEnter = $(this).attr("data-onenter")
				$("#" + onEnter).click();
			}
		});
	});
    */
}
function shadowbox_open(file, ext){
    var options = {continuous: true, counterType: "skip"};
    switch(ext){
        case "jpg":
        case "gif":
        case "png":
            player = "img"
            break;
        case "flv":
            player = "flv"
            break;
        case "doc":
        case "docx":
        case "xls":
        case "txt":
            window.open(file)
            break;
        default:
            player = "iframe"
        break;
    }
    var img1 = {
        player:     player,
        content:    file,
        options:    options
    };
    Shadowbox.open([img1]);
}
function init_tabs(){    
    $("#jLangs a").each(function(index){
        var dataLang = $(this).attr('data-lang');
        if(dataLang ==_base_lang){
            $(this).removeClass('btn-inverse').addClass('btn-warning');
        } else if(dataLang != _base_lang){           
            $("[name*=_"+dataLang+"]").each(function(){
                $(this).css('display','none');
            })
        }
    });
    init_tabs_panel();
}
function init_tabs_panel(){
    $("#jLangs a").live('click',function(){
       var setLang = $(this).attr('data-lang');
        $("#jLangs a").each(function(index){
            var dataLang = $(this).attr('data-lang');
            if(dataLang != setLang){
                $(this).removeClass('btn-warning').addClass('btn-inverse');
                $("[name*="+dataLang+"]").each(function(){
                    $(this).css('display','none');
                })
            } else if(dataLang == setLang){
                $(this).removeClass('btn-inverse').addClass('btn-warning');
                $("[name*=_"+setLang+"]").each(function(){
                    $(this).css('display','block');
                })
            }
        }) 
    });
}
function removeAcitevesMenu(){
    $('#j-Menu li').each(function(){
        $(this).removeClass('active')
    });
}
function initTables(){
    if(exists(('.jData-table'))){
       listTables = $('.jData-table').dataTable({
    		"bJQueryUI": true,
            "oLanguage": {
    			"sUrl": _base_url+"assets/widgets/tables/language/sp_ES.txt"
    		},
    		"sPaginationType": "full_numbers",
    		"sDom": '<""fl>t<"F"p>',
            "fnInitComplete": function (){     
                $(listTables.fnGetNodes()).mouseover(function(){
                    id = $(this).attr('id');
                    _caballo_id = $(this).attr('id').split("-").pop();
                })
                $('.jData-table.j-caballos_list tbody td').click( function () {
                    var aPos = listTables.fnGetPosition( this );                     
                    if(aPos[1]!=0){                        
                        window.location.href = _base_url+'fichas/detalle/c/'+_categoria_id+'/id/'+_caballo_id    
                    }
                  });
            },
    	});
    }
    if(exists(('.jData-table-dashboard'))){
        $('.jData-table-dashboard').dataTable({
    		"bJQueryUI": true,
            "oLanguage": {
    			"sUrl": _base_url+"assets/widgets/tables/language/sp_ES.txt"
    		},
    		"sDom": 't',
    	});
    }
}
/* FORM FUNCTIONS */
function validateLoginForm(form) {
    if(typeof form == "string") e = $('#'+form);
    var validate = e.validate({       
        debug: true,
        submitHandler: function () {
            frm_send($('#' + form));
        },
        errorPlacement: function(error, element) {
            error.prependTo('#jAppendFormErrors');
        },
        errorLabelContainer: $("#jAppendFormErrors ul"),
        onblur: false,
        onkeyup: false,
        onsubmit: true,
        wrapper: "li",
        showErrors: function() {
            this.defaultShowErrors();
        },
        rules: {
            user:{            
                required: true,
                email: true
            },
        },
        messages: {
            user: {
                required: "Ingrese su usuario"
            },
            password: {
                required: "Ingrese su password"
            }
        }
    });
    $("#jAppendFormErrors ul").addClass('alert alert-error')
}
function validateForm(form) {
    if(typeof form == "string") e = $('#'+form);
    if($("select[id*=right]")){
        $("select[id*=right]").each(function(n,el){
            var id = $(el).attr('id');
            $('#'+id+' option').each(function(n,ele){
              $(ele).attr('selected','selected');  
            })
        })
    }
    var validate = e.validate({       
        debug: true,
        submitHandler: function () {
            frm_send($('#' + form));
        },
        errorClass: "help-inline",
		errorElement: "span",
        onblur: false,
        onkeyup: false,
        onsubmit: true,  
        rules: {
            password: {
                required: true,
                minlength: 7
            },
            valid_password:{            
                required: true,
                equalTo: "#password",
                minlength: 7
            },
        },
        highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
    });
}
function clear_form_elements() {
    $()
    $(window).find(':input').each(function() {
        alert('this');
        switch(this.type) {
            case 'password':
            case 'select-multiple':
            case 'select-one':
            case 'text':
            case 'textarea':
                $(this).val('');
                break;
            case 'checkbox':
            case 'radio':
                this.checked = false;
        }
    });
}
var _frm_progress = false;
function frm_send(form, ajaxUrl, ajaxId, extraData) {
    if(form=="none"){
        if(ajaxUrl==undefined || ajaxId==undefined)  { _exception.show(102, "frm_send"); return false;}
        var form = $("<form/>", {"id" : "frm"+ajaxId, "action":ajaxUrl});
    }
    if(extraData==undefined)
        extraData = new Array();
    if (!exists(form) && form != "none") {
        _exception.show(102, "frm_send");
        return false;
    }
    if (_frm_progress) {
        _exception.show(105, "frm_send");
        return false;
    }
    if (extraData.length > 0)
        extraData = "&" + extraData.join("&")
    _frm_progress = true
    $.ajax({
        type : 'POST',
        url  : form.attr('action'),
        data : form.serialize() + extraData,
        success : function(data) {
            _frm_progress = false;
            data = frm_jsonDecode(data)
            console.log(data)
            switch(data.success) {
                case "true":
                case true:
                case 1:
                case "1":
                    $('#'+form.attr('id')).reset();
                break;
                case "false":
                case false:
                case 0:
                break;
                case "error":
                case "-1":                    
                break;
                default:
                    _exception.show(103, form.attr("id"));
                    return false;
                break;
            }
            switch(data.responseType) {
                case "function":
                    if (data.value == "") {
                        _exception.show(106, form.attr("id"));
                    }
                    var fn = data.value
                    if (window[fn] != undefined) {
                        eval(fn)(data)
                    } else {
                        _exception.show(108, fn);
                    }
                break;
                case "redirect":
                    if (data.value == "") {
                        _exception.show(106, form.attr("id"));
                    }
                        window.location.href = data.value
                break;
                default:
                    _exception.show(104, form.attr("id"));
                break;
            }
        },
        error : function(data) {
            _frm_progress = false;
            _exception.show(101, form.attr("id"));
        }
    })
}
function frm_jsonDecode(data) {
	try {
		data = jQuery.parseJSON(data);
	} catch(err) {
		_exception.show(107, err);
		data = '{"success":"error"}';
		data = jQuery.parseJSON(data);
	}
	return data
}
$.fn.reset = function () {
  $(this).each (function() { this.reset(); });
}
function appendFormMessages(data){
    if(exists(('#jAppendFormErrors'))) {  
        $("#jAppendFormErrors").css('display','block');
        $("#jAppendFormErrors ul").css('display','block').html(data.messages);
    } else {
        console.log('TODO - SI EL ELEMENTO NO EXISTE');
        console.log(data)    
    }
}
function getOpcionesMedicasExtras(val){
        var id  = $('input[name=caballo_id]').val();        
        var url = _base_url+'fichas/setOpcionesMedicas/op/'+val+'/id/'+id
        frm_send('none',url,'fichaMedica');
}
function appendAccionesMedicasExtras(data){
    if(exists(('.jAccionesMedicasExtras'))) {
        $('.jAccionesMedicasExtras').remove();
    }
    $('#jAccionesMedicas').after(data.html);
}
function enableExtraFecha(val){
    if(val=='+n'){
        $('.setFechaMedica').removeAttr('disabled');
    } else {
        $('.setFechaMedica').val('').attr('disabled','disabled');
    };
}
function open_modal(data){    
    var dialog = $("#modal");
    if(!exists(('#modal'))) {    
        dialog = $('<div id="modal" class="modal fade" style="display:hidden"></div>').appendTo('body');
    } 
    dialog.html(data.html).modal();
}
function setActiveMenu(){
}
function setLocalStorage(key,val){
    localStorage.setItem(key,val);
}
function removeLocalStorage(key){
    localStorage.removeItem(key);
}
function change_select_multi_transfer(left,right){
    $("#"+left+" option:selected").remove().appendTo('#'+right);
}
function init_upload_manager(){
    $("[id^='upload_manager']").each(function(n,el){        
        var id   = $(el).attr('id')        
        var json = $(el).html()
        var flashvars = frm_jsonDecode(json);
        var params = {
        		menu: "false",
        		scale: "noScale",
        		allowFullscreen: "true",
        		allowScriptAccess: "always",
        		bgcolor: "#ffffff",
                wmode: "transparent"
        	};
         var attributes = {
        		id:"uploadManager"
        	};
         swfobject.embedSWF(_base_url+"/assets/widgets/uploadManager/uploadManager.swf", id, "400", "25", "9.0.0", "expressInstall.swf", flashvars, params, attributes);
        })
}
function resize_images(id){
    console.log(id)
    var ajax = new Request({
         method: 'post',
		 url:    _base_url+"/assets/widgets/uploadManager/UploadManager.php?a=resize&id="+id,
		 onRequest: function(){},
         onSuccess: function(data){},
         onFailure: function(){alert('Conection error (error: axri-101).');} 
      }).send();
}

function cloneUpload(folder,env){
    var pos = $('#uploadGroup #uploadManager').length
    var url = _base_url+'institucional/getUploads/folder/'+folder+'/pos/'+pos+'/env/'+env
    frm_send('none',url,'cloneUpload');
}

function appendUploadElement(data){
    $('#uploadGroup .controls').append(data.html);
    init_upload_manager();
}
function fullCalendar(){
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
    $('#fullcalendar').fullCalendar({
        monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
        monthNamesShort:['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
        dayNames: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
        dayNamesShort: ['Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab', 'Dom'],
        header: {
            left: 'prev,next',
            center: 'title',
            right: ''
        },
        editable: false,
        droppable: false, // this allows things to be dropped onto the calendar !!!
        eventSources: [{
            url: _base_url+'dashboard/getCalendar',
            type: 'POST',
            error: function() {
                alert('there was an error while fetching events!');
            },                        
            textColor: 'withe' // a non-ajax option
            }],            
    });
}


function init_tooltips(){
    $('.tip').tooltip();	
	$('.tip-left').tooltip({ placement: 'left' });	
	$('.tip-right').tooltip({ placement: 'right' });	
	$('.tip-top').tooltip({ placement: 'top' });	
	$('.tip-bottom').tooltip({ placement: 'bottom' });
}
/* REUTILIZAR FORMS FUNCITONS SEND */
/*
    if(form=="none"){
    if(ajaxUrl==undefined || ajaxId==undefined)  { _exception.show(102, "frm_send"); return false;}
    var form = $("<form/>", {"id" : "frm"+ajaxId, "action":ajaxUrl});
    }
    switch(form.attr("id")) {
    case "frmFilter":
    _hash_arr = new Array();
    frm_setHash("search", form, false);
    break;
    case "frmnewa":
    hash_set("act/new", false);
    break;
    case "frmupdate":
    var frmupdate_id = ajaxUrl.split("/").pop();
    hash_set("act/update/" + frmupdate_id, false);
    break;
    }
    */
 /*
    case "back":
    page_back();
    break;
    case "redirect":
    if (data.value == "") {
    _exception.show(106, form.attr("id"));
    }
    window.location.href = data.value
    break;
    case "alert":
    if (data.value == "") {
    _exception.show(106, form.attr("id"));
    }
    alert(data.value)
    break;
    case "inject":
    if (data.value == "") {
    _exception.show(106, form.attr("id"));
    }
    var target = (data.inject != undefined) ? $("." + data.inject) : form.find(".x-msg")
    target.html(data.value.html)
    switch(data.injectType) {
    case "error":
    target.css("display", "block");
    target.effect("shake", {
    times : 3,
    distance : 3
    }, 70);
    break;
    default:
    frm_onInject()
    break;
    }
    break;
    */
 /*** MODALS ***/
/*
function init_modal() {
    $().modal({
        overlayClose: true,
        onOpen: function (dialog) {
        	dialog.overlay.fadeIn('slow', function () {
        		dialog.container.slideDown('slow', function () {
        			dialog.data.fadeIn('slow');
        		});
        	});
        }
    });
}
function showConfirm(data){
    init_modal();
    $(".simplemodal-wrap").html(data.msg);
} */