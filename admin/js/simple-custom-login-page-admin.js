jQuery(document).ready(function ($) {
	let custom_uploader;
	$('#upload_image_button').click(function (e) {
		e.preventDefault();

		if (custom_uploader) {
			custom_uploader.open();
			return;
		}

		custom_uploader = wp.media.frames.file_frame = wp.media({
			title: 'Choose Image',
			button: {
				text: 'Choose Image'
			},
			multiple: false
		});

		custom_uploader.on('select', function () {
			attachment = custom_uploader.state().get('selection').first().toJSON();
			$('#simple_custom_login_page_image').val(attachment.url);
			$('#upload_image_preview').attr('src', attachment.url);
		});

		custom_uploader.open();
	});

	$('#reset_image_button').click(function (e) {
		e.preventDefault();
		$('#simple_custom_login_page_image').val('');
		$('#upload_image_preview').attr('src', $('#upload_image_preview').data('default'));
	});

	$('#simple_custom_login_page_form_bg').wpColorPicker();
	$('#simple_custom_login_page_background').wpColorPicker();
	$('#simple_custom_login_page_text_color').wpColorPicker();
	$('#simple_custom_login_page_link_color').wpColorPicker();
});


