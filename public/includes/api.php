<?php 
function responsive_background($attachment, $unique_identifier = false) {
	//Provided with the attachment, now get url's for the different sizes.

	$wprb = WP_Responsive_Backgrounds::get_instance();

	if(!$unique_identifier) {
		$unique_identifier = $wprb->get_unique_class();
	}

	for($i = 0; $i < sizeof($wprb->breaks); $i++):
		$attachment_url = wp_get_attachment_image_src( $attachment['id'], 'respond-' . $i );
		$wprb->breaks[$i] .= '.' . $unique_identifier . " { background-image: url('" . $attachment_url[0] . "'); }";
	endfor;

	if($attachment && $unique_identifier) {
		return $unique_identifier;
	} else {
		return "";
	}
}

?>