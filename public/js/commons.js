$(document).ready(function () {
	icheck()
});

// Validation
if ($('.form-validate').length > 0) {
	$('.form-validate').each(function () {
		var id = $(this).attr('id');
		$("#" + id).validate({
			errorElement  : 'span',
			errorClass    : 'help-block has-error',
			errorPlacement: function (error, element) {
				if (element.parents("label").length > 0) {
					element.parents("label").after(error);
				} else {
					element.after(error);
				}
			},
			highlight     : function (label) {
				$(label).closest('.form-group').removeClass('has-error has-success').addClass('has-error');
			},
			success       : function (label) {
				label.addClass('valid').closest('.form-group').removeClass('has-error has-success').addClass('has-success');
			},
			onkeyup       : function (element) {
				$(element).valid();
			},
			onfocusout    : function (element) {
				$(element).valid();
			}
		});
	});
}


function icheck() {
	if ($(".icheck-me").length > 0) {
		$(".icheck-me").each(function () {
			var $el = $(this);
			var skin = ($el.attr('data-skin') !== undefined) ? "_" + $el.attr('data-skin') : "",
				color = ($el.attr('data-color') !== undefined) ? "-" + $el.attr('data-color') : "";

			var opt = {
				checkboxClass: 'icheckbox' + skin + color,
				radioClass   : 'iradio' + skin + color,
				increaseArea : "10%"
			}

			$el.iCheck(opt);
		});
	}
}