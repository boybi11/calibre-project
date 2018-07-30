var notify;
function showNotify(title, message, timer) {
	var message = (_.isUndefined(message) ? '' : message);
	var timer = (_.isUndefined(timer) ? 3000 : timer);
	if (! _.isUndefined(notify)) {
		notify.close();
	}
	notify = $.notify({
		icon: '',
		title: title,
		message: message,
	}, {
		type: "primary",
		animate: {
			enter: 'animated fadeInUp',
			exit: 'animated fadeOutDown'
		},
		placement: {
			from: "bottom",
			align: "right"
		},
		timer: timer
	});
};
function hideLoader(hideIt) {
	var loader = $('#page-loader');
	loader.toggleClass('hide', hideIt);
};
function toSlug(str) {
	return str.toString().toLowerCase()
    .replace(/\s+/g, '-')
    .replace(/[^\w\-]+/g, '')
    .replace(/\-\-+/g, '-')
    .replace(/^-+/, '');
};

(function(){
	var navbar = $('.navbar');
	var parselyForm = $('.form-parsley');
	var seoForm = $('.form-seo');

	//===== SIDEBAR MANAGEMENT
	$('aside>ul>li>a').on('click', function() {
		$('aside>ul>li').removeClass('open');
		var link = $(this);
		var list = link.closest('li');
		if (list.hasClass('has-list')) {
			list.toggleClass('open');
		}
	});
	navbar.find('.menu-btn').on('click', function() {
		$('body').toggleClass('hide-menu');
	});
	$(window).resize(function() {
		checkWindowWidth();
	});
	function checkWindowWidth() {
		if ($(window).width() < 768) {
			hideMenu();
		} else {
			showMenu();
		}
	}
	function showMenu() {
		$('body').removeClass('hide-menu');
	}
	function hideMenu() {
		$('body').addClass('hide-menu');
	}

	//===== ADMIN INIT
	checkWindowWidth();
	$('.datatable').dataTable({
		oLanguage: {
	      	sLengthMenu: "_MENU_",
	      	oPaginate: {
		      	"sPrevious": "«",
				"sNext": "»"
	      	}
	    }
	});
	$(".select2").select2();
	$('[data-toggle="popover"]').popover();

	$('.toggle-delete-all').on('click', function() {
		var checkbox = $(this);
		var toggle = (checkbox.is(':checked')) ? true : false;
		$('input[name="ids[]"]').prop('checked', toggle);
	});
	$('#delete-modal .btn-delete').on('click', function() {
		$('.form-delete').submit();
	});

	//===== CRUD AJAX 
	if (parselyForm.length > 0) {
		parselyForm.submit(function(e) {
			e.preventDefault();
		});
		parselyForm.parsley().on('form:submit', function() {
			hideLoader(false);
			showNotify('Saving data.');

			var url = parselyForm.attr('action');
			var data = parselyForm.serialize();
			var method = $('input[name="_method"]').val();
			var type = (_.isUndefined(method) ? 'POST' : method);
			submitForm(url, data, type);

	    return false;
	  });
	}
	function submitForm(url, data, type) {
		$.ajax({
			type : type,
			url: url,
			data : data,
			dataType : 'json',
			processData: false,
			success : function(data) {
				hideLoader(true);
				var title = data.notifTitle;
				var message = (_.isUndefined(data.notifMessage) ? '' : data.notifMessage);
				showNotify(title, message);

				if (data.resetForm) {
					resetForm(parselyForm);
				}

				if (! _.isUndefined(data.redirect)) {
					setTimeout(function() {
						window.location = data.redirect;
					}, 2500);
				}
			},
			error : function(data, text, error) {
				hideLoader(true);
				var message = '';
				_.each(data.responseJSON, function(val) {
					message += val + ' ';
				});
				showNotify('Error saving.', message);
			}
		});
	};
	function resetForm(form) {
		form.find('input').val('');
		form.find('textarea').val('');
	}

	//===== CRUD SLUG
	if ($('.to-slug').length > 0) {
		var slug = $('.to-slug');
		var form = $('.form');
		slug.attr('readonly', 'true');

		if (form.hasClass('form-create')) {
			var input = $('.form-create .to-slug').data('from');
			$('#'+input).keyup(function() {
				slug.val(toSlug($(this).val()))
			});
		} else if (form.hasClass('form-edit')) {
			slug.parent().append('<a class="edit-slug" href="#">Edit</a>');
			$('.edit-slug').on('click', function() {
				slug.removeAttr('readonly').focus();
				$(slug).keyup(function() {
					slug.val(toSlug($(this).val()))
				});
			});
		}
	}

	//===== SEO AJAX
	seoForm.submit(function(e) {
		e.preventDefault();

		var url = seoForm.attr('action');
		var data = seoForm.serialize();
		submitSeoFrom(url, data);
	});
	function submitSeoFrom(url, data) {
		hideLoader(false);
		showNotify('Saving SEO.');
		$.ajax({
			type : 'POST',
			url: url,
			data : data,
			dataType : 'json',
			processData: false,
			success : function(data) {
				hideLoader(true);
				var title = data.notifTitle;
				var message = (_.isUndefined(data.notifMessage) ? '' : data.notifMessage);
				showNotify(title, message);
			},
			error : function(data, text, error) {
				hideLoader(true);
				var message = '';
				_.each(data.responseJSON, function(val) {
					message += val + ' ';
				});
				showNotify('Error saving.', message);
			}
		});
	}

	//===== CROPPING IMAGES
	var formCrop = $('.form-crop');
	var cropTarget = formCrop.find('#crop-target');
	var cropDimensions = {
		'width': formCrop.find('input[name="target_width"]').val(),
		'height': formCrop.find('input[name="target_height"]').val()
	}
	cropTarget.Jcrop({
		onSelect: changeCoords,
		onChange: changeCoords,
		aspectRatio: cropDimensions.width / cropDimensions.height
	});
	function changeCoords(c) {
		formCrop.find('input[name="crop_width"]').val(c.w);
		formCrop.find('input[name="crop_height"]').val(c.h);
		formCrop.find('input[name="x"]').val(c.x);
		formCrop.find('input[name="y"]').val(c.y);
		// showPreview(c);
	}
	// function showPreview(c) {
	// 	var rx = 100 / c.w;
	// 	var ry = 100 / c.h;
	// 	$('#crop-preview').css({
	// 		width: Math.round(rx * 500) + 'px',
	// 		height: Math.round(ry * 370) + 'px',
	// 		marginLeft: '-' + Math.round(rx * c.x) + 'px',
	// 		marginTop: '-' + Math.round(ry * c.y) + 'px'
	// 	});
	// }

	//===== REDACTOR
	var redactor = $('.redactor');
	if (redactor.length > 0) {
		var redactorUpload = redactor.data('redactor-upload');
		var token = redactor.closest('form').find('input[name="_token"]').val();
		redactor.redactor({
			minHeight: 200,
			imageUpload: redactorUpload + '?_token=' + token,
			imageUploadCallback: function(image, json) {}
		});
	}
	
	//===== OPTIONS
	var optionsForm = $('.options-form');
	var optionsTypeInput = optionsForm.find('#option-type');
	optionsTypeInput.change(function() {
		showOptionType(optionsTypeInput.val());
	});
	showOptionType(optionsTypeInput.val());
	function showOptionType(type) {
		optionsForm.find('.option-type').addClass('hide');
		optionsForm.find('.option-type-'+type).removeClass('hide');
	}

})();