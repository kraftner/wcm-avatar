<?php
/**
 * This file is part of the WCM Avatar package.
 *
 * © Franz Josef Kaiser / wecodemore
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WCM\User\Avatar\Services;

/**
 * Class AvatarDimensionLimitService
 *
 * @package WCM\User\Avatar
 * @author  Franz Josef Kaiser <franzjosef.kaiser@nzz.at>
 */
class AvatarDimensionLimitService implements ServiceInterface
{

	/**
	 * @param array $file
	 * @return string
	 */
	public function setup( Array $file = [ ] )
	{
		$data = getimagesize( $file['tmp_name'] );
		// Handle cases where we can't get any info:
		if ( ! $data )
			return $file;

		list( $width, $height, $type, $hwstring ) = $data;
		$mime = image_type_to_mime_type( $type );

		// Flash uploader
		/*if (
			'application/octet-stream' === $file['type']
			and isset( $file['tmp_name'] )
			)
		{

		}*/

		if (
			$width > 1024
			or $height > 1024
		)
			$file['error'] = sprintf( _x(
				'Image exceeds maximum size of %spx × %spx',
				'%s are the maximum pixels',
				'clients_domain'
			), number_format_i18n( 1024 ), number_format_i18n( 1024 ) );

		/*$magick = new \Imagick( $file['tmp_name'] );
		$mdata = $magick->identifyImage();
		$ppi = $mdata['resolution'];
		$file['error'] = join( ' | ', array_keys( $ppi ) );*/

		return $file;
	}
}