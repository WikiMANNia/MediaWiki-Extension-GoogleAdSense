<?php
/**
 * Hooks Class file for the GoogleAdSense extension
 *
 * @file
 * @ingroup Extensions
 * @author Siebrand Mazeland
 * @license MIT
 */

class GoogleAdSenseHooks extends Hooks {

	/**
	 * Hook: SkinBuildSidebar
	 * @param Skin $skin
	 * @param array $bar
	 * https://www.mediawiki.org/wiki/Manual:Hooks/SkinBuildSidebar
	 */
	public static function onSkinBuildSidebar(
		Skin $skin,
		array &$bar
	) {
		global $wgGoogleAdSenseWidth, $wgGoogleAdSenseID,
			$wgGoogleAdSenseHeight, $wgGoogleAdSenseClient,
			$wgGoogleAdSenseLang, $wgGoogleAdSenseEncoding,
			$wgGoogleAdSenseSlot, $wgGoogleAdSenseSrc,
			$wgGoogleAdSenseAnonOnly;

		// Return $bar unchanged if not all values have been set.
		// @todo Signal incorrect configuration nicely?
		if ( empty( $wgGoogleAdSenseID )
			|| empty( $wgGoogleAdSenseClient ) || ( $wgGoogleAdSenseClient == 'none' )
			|| empty( $wgGoogleAdSenseSlot ) || ( $wgGoogleAdSenseSlot == 'none' )
		) {
			return $bar;
		}

		if ( $skin->getUser()->isLoggedIn() && $wgGoogleAdSenseAnonOnly ) {
			return $bar;
		}

		$width  = self::getAndCheckValue( $wgGoogleAdSenseWidth );
		$height = self::getAndCheckValue( $wgGoogleAdSenseHeight );

		if ( ( $width === false ) || ( $height === false ) || empty( $wgGoogleAdSenseSrc ) ) {
			return $bar;
		}

		// Add CSS
		$skin->getOutput()->addModules( 'ext.googleadsense' );

		$bar['googleadsense-portletlabel'] = "<script type=\"text/javascript\"><!--
google_ad_client = \"$wgGoogleAdSenseClient\";
/* $wgGoogleAdSenseID */
google_ad_slot = \"$wgGoogleAdSenseSlot\";
google_ad_width = " . $width . ";
google_ad_height = " . $height . ";
google_language = \"$wgGoogleAdSenseLang\";
google_encoding = \"$wgGoogleAdSenseEncoding\";
// -->
</script>
<script type=\"text/javascript\"
src=\"$wgGoogleAdSenseSrc\">
</script>";

		return true;
	}

	private static function getAndCheckValue( $value ) {

		if ( empty( $value ) ) {
			return false;
		}

		if ( $value === 'auto' ) {
			return 'auto';
		}

		if ( is_int( $value ) ) {
			return intval( $value );
		}

		return false;
	}
}
