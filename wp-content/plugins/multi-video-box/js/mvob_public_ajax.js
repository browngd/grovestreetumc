jQuery(document).ready(function () {
	// If the Multi Video Box output exists, listen for activity
	if ( jQuery('#mvob').length ) {
		// Determine which side the tabs are on
		var $tab_side = jQuery('#tab_side').val();

		// Check for a click on a tab
		jQuery(".mvob-" + $tab_side + "-tab").click( function( event ) {
			// Get the ID of the currently active tab
			var $current_tab = jQuery(".mvob-selected").attr( 'id' );

			// Get the ID of the tab that was clicked
			var $clicked_tab = event.target.id;

			// Get information from hidden variables about Video set
			var $total_videos = parseInt( jQuery('#total_videos').val() );
			var $video_ids = jQuery('#video_ids').val();
			var $video_names = jQuery('#video_names').val();
			var $first_video = parseInt( jQuery('#first_video').val() );
			var $last_video = parseInt( jQuery('#last_video').val() );
			var $selected_video = parseInt( jQuery('#selected_video_id').val() );
			var $group_id = parseInt( jQuery('#group_id').val() );

			// Get the ID of the Video for the clicked_tab
			var $tab_id = $clicked_tab.split("-");
			$tab_id = parseInt( $tab_id[$tab_id.length-1] );

			// Split Video IDs and Video Names into arrays
			var $video_ids = $video_ids.split("_|_");
			var $video_names = $video_names.split("_|_");

			// If the tab that was clicked is not the tab that is currently active and is not the previous or next tab, proceed
			if ( ( $current_tab != $clicked_tab ) && ( $clicked_tab != "mvob-prev-arrow" ) && ( $clicked_tab != "mvob-next-arrow" ) && ( !jQuery('#' + $clicked_tab).hasClass('mvob-empty') ) )  {
				// Show processing image
				jQuery("#mvob-processing").show();

				// Get the ID of the Video that should be loaded
				var $show_video = $tab_id + ( $first_video - 1 );
				var $the_video_id = $video_ids[$show_video];

				video_data =  {
					action: 'mvob_get_video_embed',
					video_id: $the_video_id,
					group_id: $group_id,
					mvob_nonce: mvob_ajax_data.mvob_nonce
				}

				jQuery.post( mvob_ajax_data.ajaxurl , video_data , function( data ) {
					var $new_video = JSON && JSON.parse( data ) || $.parseJSON( data );

					// Load the selected Video title
					jQuery("#mvob-video-title").html( $video_names[$show_video] );

					// Load new video embed into mvob-video-inner
					jQuery("#mvob-video-embed").html( $new_video['video_embed'] );

					// Load description into mvob-video-description
					jQuery("#mvob-video-description").html( $new_video['video_description'] );

					// Hide Processing image
					jQuery("#mvob-processing").hide();
				} );

				// Switch the Selected tab and Selected Video ID
				jQuery("#" + $current_tab).removeClass( 'mvob-selected' );
				jQuery("#" + $clicked_tab).addClass( 'mvob-selected' );
				jQuery('#selected_video_id').val( $the_video_id )
			}
			// If the user wants to scroll backwards in the Video list
			else if ( $clicked_tab == "mvob-prev-arrow" ) {
				if ( !jQuery('#mvob-prev-arrow').hasClass('mvob-inactive') ) {
					// Get information to control tab setting
					var $num_tabs = $last_video - $first_video;

					// Loop the tabs, replacing the value with the name of the previous video in the list
					for ( var $i = 0; $i <= $num_tabs; $i++ ) {
						var $video_index = $first_video + $i - 2;
							
						// Get the Video Name that goes in this tab
						var $video_name = $video_names[$video_index].substring( 0 , 15 );

						// Add or remove the mvob-selected class if this was the selected Video ID
						if ( $video_ids[$video_index] == $selected_video ) {
							jQuery("#mvob-tab-" + $i).addClass( 'mvob-selected' );
						}
						else {
							jQuery("#mvob-tab-" + $i).removeClass( 'mvob-selected' );
						}

						// Set the Video Name into the tab
						jQuery("#mvob-tab-" + $i).html( $video_name );
					}

					// Update First and Last Video
					jQuery('#first_video').val( $first_video - 1 );
					jQuery('#last_video').val( $last_video - 1 );

					// Check to see if Prev or Next should be activated or deactivated
					check_previous_next( $first_video - 1 , $last_video - 1 , $total_videos );
				}
			}
			// If the user wants to scroll forwards in the Video list
			else if ( $clicked_tab == "mvob-next-arrow" ) {
				if ( !jQuery('#mvob-next-arrow').hasClass('mvob-inactive') ) {
					// Get information to control tab setting
					var $num_tabs = $last_video - $first_video;

					// Loop the tabs, replacing the value with the name of the next video in the list
					for ( var $i = 0; $i <= $num_tabs; $i++ ) {
						var $video_index = $first_video + $i;

						// Get the Video Name that goes in this tab
						var $video_name = $video_names[$video_index].substring( 0 , 15 );

						// Add or remove the mvob-selected class if this was the selected Video ID
						if ( $video_ids[$video_index] == $selected_video ) {
							jQuery("#mvob-tab-" + $i).addClass( 'mvob-selected' );
						}
						else {
							jQuery("#mvob-tab-" + $i).removeClass( 'mvob-selected' );
						}

						// Set the Video Name into the tab
						jQuery("#mvob-tab-" + $i).html( $video_name );
					}

					// Update First and Last Video
					jQuery('#first_video').val( $first_video + 1 );
					jQuery('#last_video').val( $last_video + 1 );

					// Check to see if Prev or Next should be activated or deactivated
					check_previous_next( $first_video + 1 , $last_video + 1 , $total_videos );
				}
			}
		} );
	}
} );

function check_previous_next( $first_video , $last_video , $total_videos ) {
	// If the first_video <= 1, deactivate the Previous arrow
	if ( $first_video <= 1 ) {
		jQuery("#mvob-prev-arrow").addClass( 'mvob-inactive' );
		jQuery("#mvob-prev").addClass( 'mvob-tab-inactive' );
	}
	// Otherwise, remove the inactive class to activate the Previous arrow
	else {
		jQuery("#mvob-prev-arrow").removeClass( 'mvob-inactive' );
		jQuery("#mvob-prev").removeClass( 'mvob-tab-inactive' );
	}

	// If $last_video >= $total_videos, deactivate the Next arrow
	if ( $last_video >= $total_videos ) {
		jQuery("#mvob-next-arrow").addClass( 'mvob-inactive' );
		jQuery("#mvob-next").addClass( 'mvob-tab-inactive' );
	}
	// Otherwise, remove the inactive class to activate the Next arrow
	else {
		jQuery("#mvob-next-arrow").removeClass( 'mvob-inactive' );
		jQuery("#mvob-next").removeClass( 'mvob-tab-inactive' );
	}
}