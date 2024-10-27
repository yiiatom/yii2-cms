(function($) {
	$('#media-library .btn-upload').on('click', function() {
		$('#media-library #medialibraryform-file').click();
	});
	$('#media-library #medialibraryform-file').on('change', function() {
		$(this).closest('#media-library').submit();
	});
})(jQuery);
