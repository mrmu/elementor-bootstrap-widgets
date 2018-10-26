(function(window, document, $, undefined){
    
    'use strict';

    window.bootstrapWidgetsModal = {};

    bootstrapWidgetsModal.init = function() {
		$('.thumbs').each(function(){
			var wid = $(this).data('wid');
			bootstrapWidgetsModal.loadGallery('[data-wid="'+wid+'"]', 'a.thumbnail');
		});
	}
	
	bootstrapWidgetsModal.updateGallery = function(galleryWrap, galleryLength, selElement) {
		$(galleryWrap +' .image-gallery-caption').text(selElement.data('caption'));
		$(galleryWrap +' .image-gallery-title').text(selElement.data('title'));
		$(galleryWrap +' .image-gallery-image').attr('src', selElement.data('image'));
		bootstrapWidgetsModal.updateButtons(galleryWrap, galleryLength, selElement.data('image-id'));
	}

	bootstrapWidgetsModal.updateButtons = function(galleryWrap, galleryLength, currentImgId){
		$(galleryWrap+' .btn_prev, '+galleryWrap+' .btn_next').show();
		if(galleryLength == currentImgId){
			$(galleryWrap+' .btn_next').hide();
		} else if (currentImgId == 1){
			$(galleryWrap+' .btn_prev').hide();
		}
	}

	bootstrapWidgetsModal.loadGallery = function(galleryWrap, triggerElements){
		var curImgId = 0,
			currentElement,
			galleryLength = 0;

		galleryLength = $(galleryWrap +' '+ triggerElements).length;

		// click next / prev
		$(galleryWrap+' .btn_next, '+galleryWrap+' .btn_prev').on('click', function(e){
			if($(this).data('id') == 'show-previous-image'){
				curImgId--;
			} else {
				curImgId++;
			}
			currentElement = $(galleryWrap+' [data-image-id="' + curImgId + '"]');
			bootstrapWidgetsModal.updateGallery(galleryWrap, galleryLength, currentElement);
		});

		// click specific image
		$(triggerElements).on('click',function(){
			curImgId = $(this).data('image-id');
			bootstrapWidgetsModal.updateGallery(galleryWrap, galleryLength, $(this));
		});
	}

    $( bootstrapWidgetsModal.init );

})(window, document, jQuery);
