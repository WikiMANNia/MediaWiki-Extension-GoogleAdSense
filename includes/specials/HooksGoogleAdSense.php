<?php
/**
 * Hooks Class file for the GoogleAdSense extension
 *
 * @file
 * @ingroup Extensions
 * @author Siebrand Mazeland, WikiMANNia
 * @license MIT
 */

use MediaWiki\MediaWikiServices;

class GoogleAdSenseHooks extends Hooks {

	/**
	 * Hook: BeforePageDisplay
	 * @param OutputPage $out
	 * @param Skin $skin
	 * https://www.mediawiki.org/wiki/Manual:Hooks/BeforePageDisplay
	 */
	public static function onBeforePageDisplay( OutputPage &$out, Skin &$skin ) {

		if ( !self::isActive() )  return;

		$skinname = $skin->getSkinName();
		$out->addModuleStyles( 'ext.googleadsense.' . $skinname );
	}

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

		if ( !self::isActive() ) {
			$bar['googleadsense'] = false;
			return;
		}

		global $wgGoogleAdSenseWidth, $wgGoogleAdSenseID,
			$wgGoogleAdSenseHeight, $wgGoogleAdSenseClient,
			$wgGoogleAdSenseLang, $wgGoogleAdSenseEncoding,
			$wgGoogleAdSenseSlot, $wgGoogleAdSenseSrc,
			$wgGoogleAdSenseAnonOnly, $wgLanguageCode;

		// Return $bar unchanged if not all values have been set.
		// @todo Signal incorrect configuration nicely?
		if ( empty( $wgGoogleAdSenseID )
			|| empty( $wgGoogleAdSenseClient ) || ( $wgGoogleAdSenseClient == 'none' )
			|| empty( $wgGoogleAdSenseSlot ) || ( $wgGoogleAdSenseSlot == 'none' )
		) {
			$bar['googleadsense'] = false;
			return;
		}

		if ( $skin->getUser()->isLoggedIn() && $wgGoogleAdSenseAnonOnly ) {
			$bar['googleadsense'] = false;
			return;
		}

		$width  = self::getAndCheckValue( $wgGoogleAdSenseWidth );
		$height = self::getAndCheckValue( $wgGoogleAdSenseHeight );

		if ( ( $width === false ) || ( $height === false ) || empty( $wgGoogleAdSenseSrc ) ) {
			$bar['googleadsense'] = false;
			return;
		}

		$language = empty( $wgGoogleAdSenseLang ) ? $wgLanguageCode : $wgGoogleAdSenseLang;
		$encoding = empty( $wgGoogleAdSenseEncoding ) ? 'utf8' : $wgGoogleAdSenseEncoding;

		$script_pattern = '<script type="text/javascript"><!--
google_ad_client = "%1$s";
/* %2$s */
google_ad_slot = "%3$s";
google_ad_width = %4$d;
google_ad_height = %5$d;
google_language = "%6$s";
google_encoding = "%7$s";
// -->
</script>
<script type="text/javascript" src="%8$s">
</script>';
		$script_code = sprintf( $script_pattern,
				$wgGoogleAdSenseClient,
				$wgGoogleAdSenseID,
				$wgGoogleAdSenseSlot,
				$width,
				$height,
				$language,
				$encoding,
				$wgGoogleAdSenseSrc
			);

		switch ( $skin->getSkinName() ) {
			case 'cologneblue' :
				$script_code = Html::rawElement( 'div', [ 'class' => 'body' ], $script_code );
			break;
			case 'modern' :
			break;
			case 'monobook' :
			break;
			case 'vector' :
			break;
		}

		$bar['googleadsense'] = $script_code;
	}

	private static function isActive() {
		global $wgGoogleAdSense;

		return ( isset( $wgGoogleAdSense ) && ( $wgGoogleAdSense === true ) );
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
