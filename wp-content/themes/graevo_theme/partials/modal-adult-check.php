<!-- Modal adult check -->
<div class="modal fade" id="adult_check" tabindex="-1" role="dialog" aria-labelledby="adult_check_Label" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		<div class="modal-content bg-c_grey_dark">

			<div class="modal-top-line w-100 bg-c_yellow_light"></div>


			<div class=" px-3 pt-6 pb-3 text-center">
				<h3 class="p-2 font-prata d-inline-block modal-title text-center border-bottom border-c_yellow_dark" id="adult_check_Label">
					<?php _e( 'Вам вже є 18?', 'html5blank'); ?>
				</h3>
			</div>

			<div class="modal-body px-3 py-6">

				<div class="modal-body--content"></div>

				<div class="modal-body--actions text-center">
					<button id="adult_check__yes" type="button" class="btn btn-yellow mx-1">
						<?php _e( 'Так', 'html5blank'); ?>
					</button>
					<button id="adult_check__no" type="button" class="btn btn-grey mx-1" data-dismiss="modal">
						<?php _e( 'Ні', 'html5blank'); ?>
					</button>
				</div>

			</div>

		</div>
	</div>
</div>
<!-- -->
