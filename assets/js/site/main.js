$(document).ready(function() {    setPlan();    setMedioPago();    //validateCupon();    $("a.ax-modal" ).on('click',function(event) {        event.preventDefault();        var url = $(this).attr('href');                frm_send('none',url,'abc');        });       /*        FB.getLoginStatus(function(response) {          if (response.status === 'connected') {            FB.api('/'+response.authResponse.userID, {fields: 'id,about,bio, birthday,email,first_name,last_name,gender,picture'}, function(r) {                console.log(r)                alert(r.email+'--->'+r.first_name+'---->'+r.last_name)                document.getElementById('fbfoto').innerHTML = ('<img src="' + r.picture.data.url + '"> ' + r.first_name+' '+r.last_name);            });             FB.api('/me/feed', 'post', {                                        message: 'Orsonia OMG!',                                        link: _base_url,                                        picture: 'https://fbcdn-photos-e-a.akamaihd.net/hphotos-ak-xpt1/t39.2081-0/12684243_1310447315649004_1895402211_n.jpg'    }, function(response) {                               console.log(response);                /*document.getElementById('publishBtn').innerHTML = 'API response is ' + response.id;                });          }          else {            logInWithFacebook();          }        });  FB.ui({  method: 'share_open_graph',  action_type: 'og.likes',  action_properties: JSON.stringify({	  object: _base_url,  })}, function(response){    console.log(response)});          */        /*          FB.api('/me/feed', 'post', {                                              message: 'Orsonia OMG!',                                              link: _base_url,                                              picture: 'http://demo.omgeventos.com.ar/assets/images/shared_link_fb.jpg'    }, function(response) {                                     console.log(response);                      document.getElementById('publishBtn').innerHTML = 'API response is ' + response.id;                      });                      */          // Now you can redirect the user or do an AJAX request to          // a PHP script that grabs the signed request from the cookie.});function logInWithFacebook(){ FB.getLoginStatus(function(response) {    if (response.status === 'connected') {        FB.api('/'+response.authResponse.userID, {fields: 'id,about,bio, birthday,email,first_name,last_name,gender,picture'}, function(r) {            console.log(r)            jQuery("input[name='fbId']").val(response.authResponse.userID);            jQuery("input[name='nombre']").val(r.first_name);            jQuery("input[name='apellido']").val(r.last_name);            jQuery("input[name='email']").val(r.email);        });    } else {        FB.login(function(response) {        console.log(response);        if (response.authResponse) {            FB.api('/'+response.authResponse.userID, {fields: 'id,about,bio, birthday,email,first_name,last_name,gender,picture'}, function(r) {                console.log(r)                jQuery("input[name='fbId']").val(response.authResponse.userID);                jQuery("input[name='nombre']").val(r.first_name);                jQuery("input[name='apellido']").val(r.last_name);                jQuery("input[name='email']").val(r.email);            });        } else {          return false;        }          }, {scope: 'email,user_likes,user_friends,user_about_me,publish_actions'}, false);    }});}/* FORM FUNCTIONS */function page_block(a, el) {    var b = $("<div/>", {        id: "j-pg_block",        style: "width:100%; height:100%; background:rgba(0,0,0,0.6); position:fixed; z-index:500; top:0px;"    });    var c = $("<div/>", {        id: "",        class: "progress progress-striped active",        style: "height: 30px;  margin-top: -15px; position: absolute; top: 50%; width: 90%; margin-left:5%"    });    var d = $("<div/>", {        id: "",        class: "progress-bar",        style: "width: 100%;  color: #FFFFFF; font-family: 'Asap',sans-serif; font-size: 15px; font-weight: bold; line-height: 30px; text-transform: uppercase;",        text: 'Procesando Información'    });    if (a) {        if (!exists($("#j-pg_block"))) {            d.appendTo(c)            c.appendTo(b)            b.appendTo("body")        }    } else {        if (exists($("#j-pg_block"))) {            $("#j-pg_block").remove()        }    }}function validateLoginForm(form) {        if(typeof form == "string") e = $('#'+form);    var validate = e.validate({               debug: true,        submitHandler: function () {            frm_send($('#' + form));        },        errorPlacement: function(error, element) {            error.prependTo('#jAppendFormErrors');        },        errorLabelContainer: $("#jAppendFormErrors ul"),        onblur: false,        onkeyup: false,        onsubmit: true,        wrapper: "li",        showErrors: function() {            this.defaultShowErrors();        },        rules: {            user:{                            required: true,                email: true            },        },        messages: {            user: {                required: "Ingrese su usuario"            },            password: {                required: "Ingrese su password"            }        }    });    $("#jAppendFormErrors ul").addClass('alert alert-error')}/* FORM FUNCTIONS */function validateForm(form) {    if(typeof form == "string") e = $('#'+form);    if($("select[id*=right]")){        $("select[id*=right]").each(function(n,el){            var id = $(el).attr('id');            $('#'+id+' option').each(function(n,ele){              $(ele).attr('selected','selected');              })        })    }    var validate = e.validate({               debug: true,        submitHandler: function () {            frm_send($('#' + form));        },        errorClass: "help-inline",		errorElement: "span",        onblur: false,        onkeyup: false,        onsubmit: true,          ignore: "",        rules: {            password: {                required: true,                minlength: 7            },            plan: {                required: true,            },            valid_password:{                            required: true,                equalTo: "#password",                minlength: 7            },        },         messages: {            plan : "Debes seleccionar un bono contribución"        },        highlight:function(element, errorClass, validClass) {			$(element).parents('.fieldItemV').addClass('error');		},		unhighlight: function(element, errorClass, validClass) {			$(element).parents('.fieldItemV').removeClass('error');			$(element).parents('.fieldItemV').addClass('success');		},        invalidHandler: function(form, validator) {  //   console.log($(validator.errorList[0].element).offset())        if (!validator.numberOfInvalids())            return;        $('html, body').animate({                        scrollTop: $(validator.errorList[0].element).offset().top-window.navHeight        },  1000);    }    });}function clear_form_elements() {    $(window).find(':input').each(function() {        alert('this');        switch(this.type) {            case 'password':            case 'select-multiple':            case 'select-one':            case 'text':            case 'textarea':                $(this).val('');                break;            case 'checkbox':            case 'radio':                this.checked = false;        }    });}var _frm_progress = false;function frm_send(form, ajaxUrl, ajaxId, extraData) {         if(form=="none"){        if(ajaxUrl==undefined || ajaxId==undefined)  { console.log(102, "frm_send"); return false;}        var form = $("<form/>", {"id" : "frm"+ajaxId, "action":ajaxUrl});    }    if(extraData==undefined)        extraData = new Array();    if (!exists(form) && form != "none") {        console.log(102, "frm_send");        return false;    }    if (_frm_progress) {        console.log(105, "frm_send");        return false;    }    if (extraData.length > 0)        extraData = "&" + extraData.join("&")    _frm_progress = true    if(_frm_progress){        page_block(true);    }    $.ajax({        type : 'POST',        url  : form.attr('action'),        data : form.serialize() + extraData,        success : function(data) {            _frm_progress = false;            page_block(false);            data = frm_jsonDecode(data)                       switch(data.success) {                case "true":                case true:                case 1:                case "1":                    $('#'+form.attr('id')).reset();                break;                case "false":                case false:                case 0:                break;                case "error":                case "-1":                                    break;                default:                    console.log(103, form.attr("id"));                    return false;                break;            }            switch(data.responseType) {                case "function":                    if (data.value == "") {                        console.log(106, form.attr("id"));                    }                    var fn = data.value                    if (window[fn] != undefined) {                        eval(fn)(data)                    } else {                        console.log(108, fn);                    }                break;                case "redirect":                    if (data.value == "") {                        console.log(106, form.attr("id"));                    }                    window.location.href = data.value                break;                default:                    console.log(104, form.attr("id"));                break;            }        },        error : function(data) {            _frm_progress = false;            console.log(101, form.attr("id"));        }    })}function frm_jsonDecode(data) {	try {		data = jQuery.parseJSON(data);	} catch(err) {		console.log(107, err);		data = '{"success":"error"}';		data = jQuery.parseJSON(data);	}	return data}$.fn.reset = function () {  $(this).each (function() { this.reset(); });}function paymentLink(datos){       $MPC.openCheckout ({                url: datos.messages,                mode: "modal",                onreturn: checkoutReturn    });} function lunchLink(datos){       $MPC.openCheckout ({                url: datos.messages,                mode: "modal",                onreturn: lunchReturn    });}function checkoutReturn (data) {   ajaxUrl = _base_url+'payments/close/id/'+data.external_reference+'/collection_id/'+data.collection_id+'/collection_status/'+data.collection_status+'/payment_type/'+data.payment_type+'/preference_id/'+data.preference_id;   frm_send('none', ajaxUrl,'checkout')}function lunchReturn (data) {   ajaxUrl = _base_url+'payments/lunch_close/id/'+data.external_reference+'/collection_id/'+data.collection_id+'/collection_status/'+data.collection_status+'/payment_type/'+data.payment_type+'/preference_id/'+data.preference_id;   frm_send('none', ajaxUrl,'checkout')}function appendFormMessagesModal(data){    console.log(data);    if(data.success==true){        clear_form_elements();    }        open_modal(data);}function afterRegisterUser(data){        if(data.success==true){        clear_form_elements();    }    if(data.userID>0){        FB.api('/me/feed', 'post', {                                    message: data.evento_name,                                    link: _base_url,                                    /*picture: 'https://fbcdn-photos-e-a.akamaihd.net/hphotos-ak-xpt1/t39.2081-0/12684243_1310447315649004_1895402211_n.jpg'*/    }, function(response) {                                    console.log(response);                });    }    open_modal(data);}function validateCupon() {      if(jQuery('input[name=cupons]').length>0){        val = jQuery('input[name=cupons]').val();        if(val.length>0){            ajaxUrl = _base_url+'cupons/validate_cupon/'+val;            frm_send('none', ajaxUrl,'xxx')        }    }}function reloadCart(data){    $(".jCartContent").empty().html(data.html);    $("a.ax-modal" ).on('click',function(event) {        event.preventDefault();        var url = $(this).attr('href');        frm_send('none',url,'abc');        });}function reviewTicketValues(data){    $(".planes.jPlanes .jPlanesCupons").empty().html(data.extra);    if(data.html.length>0){        appendFormMessagesModal(data);    }    setPlan()    if(data.fullDiscount===true){              $('.jMedioPago').addClass('hide');    } else {        $('.jMedioPago').removeClass('hide');    }}function open_modal(data){    var dialog = $("#modal");    if(!exists(('#modal'))) {            dialog = $('<div id="modal" class="modal fade" style="display:hidden"></div>').appendTo('body');    }     dialog.html(data.html).modal();    $(".jPlanes").each(function(index){                    $(this).removeClass('hide');    });    if(data.modal_redirect){        $('#modal').on('hide.bs.modal', function () {            window.location.href = data.modal_redirect         })    } }function setQty(e){    $('input[name=ticket_qty').val(e.val());}function setTickets(e){    $('.jPriceTkt').each(function(){        $(this).removeClass('info')        $(this).find('span.fa-check-square-o').removeClass('fa-check-square-o').addClass('fa-square-o');        $(this).find('select[name="cantidad"]').attr('disabled','disabled');    })    e.addClass('info')    e.find('span.fa-square-o').removeClass('fa-square-o').addClass('fa-check-square-o');    e.find('select[name="cantidad"]').prop('disabled', false);    a = e.find('select[name="cantidad"]');    setQty(a)    sku     = e.attr('data-sku');    ammount = e.attr('data-ammount');    name    = e.attr('data-name');        $('input[name=ticket_sku').val(sku);    $('input[name=ticket_ammount').val(ammount);    $('input[name=ticket_name').val(name);}function setAlzo(e){        $('.jPriceAlzo').each(function(){        $(this).find('span.fa-check-square-o').removeClass('fa-check-square-o').addClass('fa-square-o');    })    e.find('span.fa-square-o').removeClass('fa-square-o').addClass('fa-check-square-o');    sku     = e.attr('data-sku');    ammount = e.attr('data-ammount');    name = e.attr('data-name');    $('input[name=almuerzo_sku').val(sku);    $('input[name=almuerzo_ammount').val(ammount);    $('input[name=almuerzo_name').val(name);}//REMOVE SETPLAN, CLEARPLANfunction clearPlan() {    $(".planes .jPrice").each(function(index){                    $(this).removeClass('active');             $(this).find('span.fa-check-square-o').removeClass('fa-check-square-o').addClass('fa-square-o');         });}function setPlan() {    jQuery(".planes .jPrice").on('click',function(e){       clearPlan();              plan = jQuery(this).attr('data-price');       jQuery(this).addClass('active');       jQuery(this).find('span.fa-square-o').removeClass('fa-square-o').addClass('fa-check-square-o');       jQuery('input[name=plan]').val(plan);    });}function clearMedioPago() {    $(".jMedioPago .jMedio_Pago").each(function(index){                    $(this).removeClass('active');             $(this).find('span.fa-check-square-o').removeClass('fa-check-square-o').addClass('fa-square-o');         });}function setMedioPago() {    jQuery(".jMedioPago .jMedio_Pago").on('click',function(e){       clearMedioPago();              medio_pago = jQuery(this).attr('data-medio');       jQuery(this).addClass('active');       jQuery(this).find('span.fa-square-o').removeClass('fa-square-o').addClass('fa-check-square-o');       jQuery('input[name=medio_pago]').val(medio_pago);    });}