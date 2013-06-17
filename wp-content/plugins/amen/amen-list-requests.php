<?php

/**************************************
* RENDERS SHORTCODE CALLED FROM ADMIN PAGE
**************************************/

function amen_manage_requests_admin() {
	$the_amen = array(
		'author' => '',
		'page' => '',
		'recent' => '',
		'header' => '',
		'title' => '',
		'count' => '',
		'random' => '',
		'type' => 'manage',
		'id' => '',
		'noid' => '',
		'exclude' => '',
		'submit' => '',
		'state1' => '',
		'state2' => '',
		'state3' => '',
		);
	echo amen_list_requests( $the_amen );
}

/**************************************
* ADD SHORTCODE FOR LISTING REQUESTS
**************************************/

function amen_list_requests( $amen_atts ) {
	global $amen_options;
	extract( shortcode_atts( array(
		'author' => '',
		'page' => '',
		'recent' => '',
		'header' => '',
		'title' => '',
		'count' => '',
		'random' => '',
		'type' => 'list',
		'id' => '',
		'noid' => '',
		'exclude' => '',
		'submit' => '',
		'state1' => '',
		'state2' => '',
		'state3' => '',
	), $amen_atts ) );

	// DEFINE SHORTCODE ARG ARRAY
	$the_amen = array(
		'author' => ' ' . $author,
		'page' => $page,
		'recent' => $recent,
		'header' => $header,
		'count' => $count,
		'random' => $random,
		'type' => $type,
		'id' => $id,
		'noid' => $noid,
		'exclude' => ' ' . $exclude,
		'submit' => $submit,
		'state1' => $state1,
		'state2' => $state2,
		'state3' => $state3,
		);
	'' == $header ? $the_amen['header'] = $title : FALSE;
	$the_amen['submit'] = '' == $the_amen['submit'] ? $amen_options['submit_text'] : $the_amen['submit'];
	$the_amen['state1'] = '' == $the_amen['state1'] ? $amen_options['submitted_state_one'] : $the_amen['state1'];
	$the_amen['state2'] = '' == $the_amen['state2'] ? $amen_options['submitted_state_two'] : $the_amen['state2'];
	$the_amen['state3'] = '' == $the_amen['state3'] ? $amen_options['submitted_state_three'] : $the_amen['state3'];
	$the_amen['recent'] = $count;
	$the_amen['type'] = $type;
	$the_amen['id'] = $id;

	$amen_request_list = amen_query_requests( $the_amen );
	return $amen_request_list;
	unset( $the_amen );
}
add_shortcode( 'amen', 'amen_list_requests' );

function amen_query_requests( $the_amen ) {
	global $amen_session;
	global $amen_options;
	global $post;

	ob_start();

/**************************************
* INCLUDE TWEET BUTTON JAVASCRIPT
**************************************/

		if ( !( strpos( $the_amen['exclude'], 'tweet' ) > 0 ) && $amen_options['tweet_public_requests'] ) {
			echo '<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
		}
?>
		
<?php

/**************************************
* DISPLAY SUBMISSION FORM
**************************************/
?>
		<div class="wrap">
<?php
			if ( ( is_user_logged_in() || $amen_options['allow_public_requests'] ) && 'manage' == $the_amen['type'] ) {
				global $amen_session;
				global $wpdb;
				
				if ( isset($_POST['prayer_item']) && !empty($_POST['prayer_item']) ) {
					amen_create_request($_POST['prayer_item'], $_POST['urgency'], $_POST['privacy'], $_POST['praying_tag'], $amen_session );
				} else if ( isset($_POST['toggleUrgency']) && !empty($_POST['toggleUrgency']) && isset($_POST['toggleTo']) && !empty($_POST['toggleTo']) ) {
					if ( $_POST['toggleTo'] == 'urgentize' ) {
						amen_urgentize_request(intval($_POST['toggleUrgency']));
					} else {
						amen_deurgentize_request(intval($_POST['toggleUrgency']));
					}
				} else if ( isset($_POST['toggleRequest']) && !empty($_POST['toggleRequest']) && isset($_POST['toggleTo']) && !empty($_POST['toggleTo']) ) {
					if ( $_POST['toggleTo'] == 'activate' ) {
						amen_activate_request(intval($_POST['toggleRequest']));
					} else { 
						amen_deactivate_request(intval($_POST['toggleRequest']));
					}
				} else if ( isset($_POST['togglePrivacy']) && !empty($_POST['togglePrivacy']) && isset($_POST['toggleTo']) && !empty($_POST['toggleTo']) ) {
					if ( $_POST['toggleTo'] == 'privatize' ) {
						amen_privatize_request(intval($_POST['togglePrivacy']));
					} else {
						amen_deprivatize_request(intval($_POST['togglePrivacy']));
					}
				} else if ( isset($_POST['toggleApproval']) && !empty($_POST['toggleApproval']) && isset($_POST['toggleTo']) && !empty($_POST['toggleTo']) ) {
					if ( $_POST['toggleTo'] == 'approve' ) {
						amen_approve_request(intval($_POST['toggleApproval']));
					} 
				} else if ( isset($_POST['prayer_update']) && !empty( $_POST['prayer_update'] ) ) {
					amen_update_request( intval($_POST['updateRequest']), $_POST['prayer_update'] );
				} else if ( isset($_POST['request_edit']) && !empty( $_POST['request_edit'] ) ) {
					amen_edit_request( intval($_POST['editRequest']), $_POST['request_edit'] );
				} else if ( isset($_POST['deleteRequest']) && !empty($_POST['deleteRequest']) ) {
					amen_delete_request( intval($_POST['deleteRequest'] ) );
				}
				
				echo strpos( $_SERVER['REQUEST_URI'] , 'admin') > 0 ? '<h2>Manage Prayer Requests</h2>' : '';
?>
				<script type="text/javascript">
					var PWUactuallyDelete = function(el) {
						return confirm("Do you really want to delete this request?")
					}
				</script>
<?php 
				if ( isset( $amen_options['submission_title'] ) ) {
?>
					<span style="font-size:16px;font-weight:bold;"><?php echo $amen_options['submission_title']; ?></span>
<?php
					if ( is_user_logged_in() ) {
						switch ( $amen_options['author_display'] ) {
								case 'none':
									$amen_author_display = '';
									break;
								case 'username':
									$amen_author_display = ' (' . wp_get_current_user()->user_login . ')';
									break;
								case 'displayname':
									$amen_author_display = ' (' . wp_get_current_user()->display_name . ')';
									break;
								default:
									$amen_author_display = '';
									break;
						}
					} else {
						$amen_author_display = '' != $amen_options['public_user'] ? ' (' . $amen_options['public_user'] . ')' : '';
					}
					echo $amen_author_display;
				}
?>
				<form action="#manage-my-prayer-requests" method="POST" class="amen-submission">
					<input id="prayer_item" name="prayer_item" style="width:80%;margin-bottom:7px;" placeholder="Add your prayer here." tabindex="1" />
					<input type="submit" value="<?php echo $amen_options['submission_button_text']; ?>" style="display:inline-block;float:right;" tabindex="5" /><br />
<?php
					if ( ( $amen_options[privatize_prayers] || current_user_can( 'delete_users' ) ) && is_user_logged_in() ) {
?>
						<nobr><label for="privacy">Privacy: </label>
						<select id="privacy" name="privacy" tabindex="2" >
							<option value="0">Public</option>
							<option value="1">Private</option>
						</select></nobr>
<?php
					}
?>
						<nobr><label for="urgency">Urgency: </label>
						<select id="urgency" name="urgency" tabindex="3" >
							<option value="0">Standard</option>
							<option value="1">Important!</option>
						</select></nobr>
<?php
					if ( ! (strpos( $amen_options['allowed_users'], wp_get_current_user()->user_login ) === FALSE) || current_user_can( 'delete_users' ) ) {
?>
						<nobr><label for="praying_tag">Tag: </label>
						<select id="praying_tag" name="praying_tag" tabindex="4" >
							<option value=""></option>
<?php
							foreach ( $amen_options[allowed_pages] as $allowed_page => $allowed ) {
?>
								<option value="<?php echo $allowed_page; ?>"><?php echo get_the_title( $allowed_page ); ?></option>
<?php
							}
?>
						</select></nobr>
<?php
					}
?>
				</form>
				<br />
<?php
				if ( isset( $amen_options['submission_note'] ) ) {
?>
					<span style="font-size:11px;"><?php echo $amen_options['submission_note']; ?></span>
<?php
				}
			}

			switch ( $the_amen['type'] ) {
				case 'list':
					$requests = amen_get_active_requests( $amen_session, $the_amen );
					break;
				case 'manage':
					$requests = amen_get_manageable_requests( $amen_session );
					break;
			}

			$i = 0;
			foreach ( $requests as $r ) {
				if ( ' ' != $the_amen['author'] && '' != $the_amen['page'] ) {
					if ( strpos( $the_amen['author'], get_userdata( $r->created_by )->user_login ) > 0 && ( '' != $r->praying_tag && $r->praying_tag == $the_amen['page'] ) ) {
						$amen_list_this_request = TRUE;
					} else { $amen_list_this_request = FALSE; }
				} elseif ( ' ' != $the_amen['author'] && '' == $the_amen['page'] ) {
					if ( strpos( $the_amen['author'], get_userdata( $r->created_by )->user_login ) > 0 ) {
						$amen_list_this_request = TRUE;
					} else { $amen_list_this_request = FALSE; }
				} elseif ( ' ' == $the_amen['author'] && '' != $the_amen['page'] ) {
					if ( '' != $r->praying_tag && $r->praying_tag == $the_amen['page'] ) {
						$amen_list_this_request = TRUE;
					} else { $amen_list_this_request = FALSE; }
				} elseif ( ' ' == $the_amen['author'] && '' == $the_amen['page'] ) {
					$amen_list_this_request = TRUE;
				} else {
					$amen_list_this_request = FALSE;
				}

				if ( $amen_list_this_request ) {
					if ( '' == $the_amen['recent'] || $i < intval( $the_amen['recent'] ) ) {
						$praying = intval($r->praying) == 1;
						$active = intval($r->active) == 1;
						$urgent = intval($r->urgency) == 1;
						$private = intval($r->privacy) == 1;
						$approved = intval($r->approved) == 1;

						$cssClasses = 'pray_request_wrap';
						!$active ? $cssClasses .= $cssClasses .= ' amen-inactive' : '';
						!$urgent ? $cssClasses .= '' : $cssClasses .= ' pray_request_urgent';
						!$private ? $cssClasses .= '' : $cssClasses .= ' pray_request_private';
						$approved ? $cssClasses .= '' : $cssClasses .= ' pray_request_not_approved';

						if ($i == 0 && '' != $the_amen['header']) { amen_header( $the_amen['header'] ); }
?>
						<a name="AmenID-<?php echo $r->id ?>"></a>
						<div class="<?php echo $cssClasses ?>">
							<div class="pray_request_inner_wrap">
<?php
								switch ( $amen_options['author_display'] ) {
									case 'none':
										if ( current_user_can( 'delete_users' ) ) {
											$amen_author_display = get_userdata( $r->created_by ) ? get_userdata( $r->created_by )->user_login : $amen_options['public_user'];
											$amen_author_display .= ( get_userdata( $r->created_by ) && 'manage' == $the_amen['type'] ) ? ' (' . get_userdata( $r->created_by )->display_name . ')' : FALSE;
											$amen_author_display .= ': ';
										} else {
											$amen_author_display = '';
										}
										break;
									case 'username':
										if ( !( strpos( $the_amen['exclude'], 'author' ) > 0 ) ) {
											$amen_author_display = get_userdata( $r->created_by ) ? get_userdata( $r->created_by )->user_login : $amen_options['public_user'];
											if ( current_user_can( 'delete_users' ) ) {
												$amen_author_display .= ( get_userdata( $r->created_by ) && 'manage' == $the_amen['type'] ) ? ' (' . get_userdata( $r->created_by )->display_name . ')' : FALSE;
											}
											$amen_author_display .= ': ';
										}
										break;
									case 'displayname':
										if ( !( strpos( $the_amen['exclude'], 'author' ) > 0 ) ) {
											$amen_author_display = get_userdata( $r->created_by ) ? get_userdata( $r->created_by )->display_name : $amen_options['public_user'];
											if ( current_user_can( 'delete_users' ) ) {
												$amen_author_display .= ( get_userdata( $r->created_by ) && 'manage' == $the_amen['type'] ) ? ' (' . get_userdata( $r->created_by )->user_login . ')' : FALSE;
											}
											$amen_author_display .= ': ';
										}
										break;
									default:
										$amen_author_display = '';
										break;
								}
								if ( current_user_can( 'delete_users' ) && 'manage' == $the_amen['type'] ) { $amen_id = '<strong>[Amen-ID: ' . $r->id . '] '; } else { $amen_id = ''; }
								if ( 'manage' == $the_amen['type'] ) { 
									$amen_id .= $private ? '<span style="color:#A00;">Privately ' : '<span style="color:#070;">Publicly ';
									$amen_id .= $active ? 'Active</span></strong><br />' : 'Inactive</span></strong><br />';
								}	
								echo '<div class="pray_request">' . $amen_id . $amen_author_display . $r->prayer_item;
								if ( 'manage' == $the_amen['type'] ) {
?>
									<br />
									<form action="#AmenID-<?php echo $r->id ?>" method="POST">
<?php
										if ( $r->id != $_POST['editRequest'] ) {
?>
										<input type="submit" value="Edit Request" class="amen-small-button" />
										<input type='hidden' name='editRequest' value='<?php echo $r->id ?>' />
<?php
										} elseif ( isset( $_POST['editRequest'] ) && $r->id == $_POST['editRequest'] ) {
?>
											<input type="submit" value="Submit Edit" class="amen-small-button" />
											<input type='hidden' name='editRequest' value='<?php echo $r->id ?>' />
											<input id="request_edit" name="request_edit" style="width:80%;margin-bottom:7px;" value="<?php echo $r->prayer_item; ?>" />
<?php
										}
?>
									</form>
<?php
								}
								echo '</div>';
								if ( !( strpos( $the_amen['exclude'], 'counter' ) > 0 ) && $amen_options['enable_submit_count'] && $r->approved ) {
									echo '<div class="praying">';
									if ( $praying ) {
										echo count_contents($r->count, $praying, $the_amen);
									} else {
										echo count_contents($r->count, $praying, $the_amen);
										echo ' &ndash; ';
										echo '<a href="#" class="amenButton" onclick="return false;" id="' . $r->id . '" data-amen-submit="' . $the_amen['submit'] . '" data-amen-state1="' . $the_amen['state1'] . '" data-amen-state2="' . $the_amen['state2'] . '" data-amen-state3="' . $the_amen['state3'] . '">' . amen_set_display($r->count, $the_amen['submit']) . '</a>';
									}
									echo '</div>';
								}
								if ( !$r->approved ) {
									echo '<div class="praying"><strong>Pending Approval</strong></div>';
								} elseif ( !( strpos( $the_amen['exclude'], 'tweet' ) > 0 ) && !$r->privacy && $r->approved && $amen_options['tweet_public_requests'] ) {
									echo '<div class="praying">';
									$amen_options['prepend_name_to_tweet'] ? $amen_add_name = $amen_author_display : FALSE;
									if ( 'hashtag' == $amen_options['tweet_type'] ) {
										$amen_options['hashtag_in_button'] ? $amen_display_hashtag = '?button_hashtag=' . $amen_options['custom_hashtag'] : $amen_display_hashtag = '';
										$amen_options['custom_hashtag'] ? $amen_custom_hashtag = ' #' . $amen_options['custom_hashtag'] : $amen_custom_hashtag = '';
										echo '<a href="https://twitter.com/intent/tweet' . $amen_display_hashtag . '" class="twitter-hashtag-button" data-lang="en" data-text="' . $amen_add_name . $r->prayer_item . '" data-via="'. $amen_options['tweet_via'] . '" data-hashtags="' . $amen_options['custom_hashtag'] . '" data-align="right">Tweet' . $amen_custom_hashtag . '</a>';
									} elseif ( 'share_count' == $amen_options['tweet_type'] ) {
										echo '<a href="https://twitter.com/share" class="twitter-share-button" data-lang="en" data-count="horizontal" data-url="' . get_permalink( $post->ID );
										echo !strpos( get_permalink(), '?' ) ? '?' : '&';
										echo 'AmenID=' . $r->id . '" data-text="' . $amen_add_name . $r->prayer_item . '" data-via="'. $amen_options['tweet_via'] . '" data-hashtags="Amen" data-align="right">Tweet</a>';
									}
									echo '</div>';
								} elseif ( $r->privacy ) {
									echo '<div class="praying"><strong>Private Request</strong></div>';
								}
							echo '</div>';
							if ( '' != $r->prayer_updated ) {
								echo '<div class="amen-update"><em>' . $r->prayer_updated . '</em></div>';
							}
							if ( ( is_user_logged_in() || $amen_options['allow_public_requests'] ) && 'manage' == $the_amen['type'] ) {
?>
								<div>
									<span style='font-size:10px;float:right;'>
<?php
										if ( !( strpos( $amen_options['allowed_users'], wp_get_current_user()->user_login ) === FALSE ) || current_user_can( 'delete_users' ) ) {
											
											$tagged_pages = $wpdb->get_results( 
												"
												SELECT meta_value, post_id 
												FROM $wpdb->postmeta
												WHERE meta_key = 'praying'
												"
											);

											foreach ( $tagged_pages as $tagged_page ) {
												if ( $tagged_page->meta_value == get_userdata( $r->created_by )->user_login ) {
												echo get_the_title( $tagged_page->post_id ) . ', ';
												}
											}

											echo $r->praying_tag ? '<i> On Pages: ' . get_the_title( $r->praying_tag ) . '</i> | ' : '';
										}
?>
										[<?php echo $r->created_at; ?>]
									</span>

									<form action="#AmenID-<?php echo $r->id ?>" method="POST">
										<input id="prayer_update" name="prayer_update" style="width:97%;margin-bottom:7px;" placeholder="Add an update to (or change the update for) this prayer request." /><br />
										<input type='hidden' name='updateRequest' value='<?php echo $r->id ?>' />
										<input type="submit" value="Post Update" /> |
									</form>
<?php 
									if ( ( $amen_options[privatize_prayers] && is_user_logged_in() ) || ( current_user_can( 'delete_users' ) && get_userdata( $r->created_by ) ) ) { ?>
										<form action='#AmenID-<?php echo $r->id ?>' method='POST'><input type='hidden' name='togglePrivacy' value='<?php echo $r->id ?>' />
										<?php if ( $private ) { ?>
											<input type='hidden' name='toggleTo' value='deprivatize' />
											<input type='submit' value='Make Public' />
										<?php } else { ?>
											<input type='hidden' name='toggleTo' value='privatize' />
											<input type='submit' value='Make Private' /> 
										<?php } ?>
									</form> | <?php } ?><form action='#AmenID-<?php echo $r->id ?>' method='POST'><input type='hidden' name='toggleUrgency' value='<?php echo $r->id ?>' />
									<?php if ( $urgent ) { ?>
										<input type='hidden' name='toggleTo' value='deurgentize' />
										<input type='submit' value='Set As Not Urgent' />
									<?php } else { ?>
										<input type='hidden' name='toggleTo' value='urgentize' />
										<input type='submit' value='Set As Urgent' />
									<?php } ?>
									</form> | <form action='#AmenID-<?php echo $r->id ?>' method='POST'><input type='hidden' name='toggleRequest' value='<?php echo $r->id ?>' />
									<?php if ( $active ) { ?>
										<input type='hidden' name='toggleTo' value='deactivate' />
										<input type='submit' value='Deactivate' />
									<?php } else { ?>
										<input type='hidden' name='toggleTo' value='activate' />
										<input type='submit' value='Activate' />
									<?php } ?>
									</form>	<?php if ( !$approved && current_user_can( 'delete_users' ) ) { ?>
									| <form action='#AmenID-<?php echo $r->id ?>' method='POST'><input type='hidden' name='toggleApproval' value='<?php echo $r->id ?>' />
										<input type='hidden' name='toggleTo' value='approve' />
										<input type='submit' value='Approve' />
									</form>
									<?php } ?>
									| <form action='#AmenID-<?php echo $r->id ?>' method='POST' onsubmit='return PWUactuallyDelete(this);'><input type='hidden' name='deleteRequest' value='<?php echo $r->id ?>' />
									<input type='submit' value='Delete' />
									</form>
								</div>
<?php
							}
?>
							</div>
<?php
					}
				$i++;
				}
			}
?>
		</div>

	<?php $amen_buffer = ob_get_clean();

	return $amen_buffer;
}

function amen_focus() {
?>
	
	<script type="text/javascript" language="javascript">
		window.onload=amen_moveWindow; 
		function amen_getID(name){
			if(name=(new RegExp('[?&]'+encodeURIComponent(name)+'=([^&]*)')).exec(location.search)) {
				return decodeURIComponent(name[1]);
			} else {
				return '';
			}
		}
		function amen_moveWindow(){
			var AmenID = amen_getID('AmenID');
			if ( '' != AmenID ) {
				window.location.hash='AmenID-'+AmenID;
			}
		}
	</script>
<?php
}
add_action( 'wp_footer', 'amen_focus' );

function amen_header( $amen_header_text ) {
	?>
	<div class="amen-header">
		<div style="padding:10px 0px 10px 20px;float:left;"><?php echo $amen_header_text; ?></div>
	</div>
	<?php
}



function amen_action_from_email() {
	if ( is_user_logged_in() && current_user_can('delete_users') && isset( $_GET['amen-action'] ) ) {
		if ( 'approve' == $_GET['amen-action'] ) {
			amen_approve_request( $_GET['AmenID'] );
		} elseif ( 'delete' == $_GET['amen-action'] ) {
			amen_delete_request( $_GET['AmenID'] );
		}
	}
}
add_action( 'init', 'amen_action_from_email' );

/**************************************
* DISPLAY COUNT FOR REQUEST
**************************************/

function count_contents($count, $praying = 0, $the_amen) {
	global $amen_options;
	$count = intval($count);
	$state_one = '' == $the_amen['state1'] ? $amen_options['submitted_state_one'] : $the_amen['state1'];
	$state_two = '' == $the_amen['state2'] ? $amen_options['submitted_state_two'] : $the_amen['state2'];
	$state_three = '' == $the_amen['state3'] ? $amen_options['submitted_state_three'] : $the_amen['state3'];
	if ( !$praying ) { $amen_final_text = amen_set_display( $count, $state_one ); return $amen_final_text; }
	elseif ( $count == '1' && $praying ) { $amen_final_text = amen_set_display( $count, $state_two ); return $amen_final_text; }
	else { $amen_final_text = amen_set_display( $count, $state_three ); return $amen_final_text; }
}

function amen_set_display( $count, $amen_text ) {
	$amen_text = str_replace( '{count}', $count, $amen_text);
	$amen_text = str_replace( '{count-1}', $count - 1, $amen_text);
	$amen_text = str_replace( '{count+1}', $count + 1, $amen_text);
	( $count > 1 || $count == 0 ) ? $amen_text = str_replace( '{s}', 's', $amen_text ) : $amen_text = str_replace( '{s}', '', $amen_text );
	$count == 1 ? $amen_text = str_replace( '{1s}', 's', $amen_text ) : $amen_text = str_replace( '{1s}', '', $amen_text );
	return $amen_text;
	unset($amen_text);
}
?>