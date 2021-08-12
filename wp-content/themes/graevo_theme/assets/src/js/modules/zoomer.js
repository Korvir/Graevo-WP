$('img[data-zoomable]').addClass('img-zoomable').click(function() {

	var src = $(this).attr('src');
	var modal;
	$('body').addClass('overflow_this');

	function removeModal() {
		modal.remove();
		$('body').off('keyup.modal-close');
		$('body').removeClass('overflow_this');
	}
	modal = $('<div class="modal-zoom">').css({
		background: 'RGBA(0,0,0,.5) url(' + src + ') no-repeat center',
		backgroundSize: 'contain',
		width: '100%',
		height: '100%',
		position: 'fixed',
		zIndex: '10000',
		top: '0',
		left: '0',
		cursor: 'zoom-out',
		border: '30px solid transparent'
	}).click(function() {
		removeModal();
	}).appendTo('body');

	//handling ESC
	$('body').on('keyup.modal-close', function(e) {
		if (e.key === 'Escape') {
			removeModal();
			$('body').removeClass('overflow_this');
		}
	});

});
