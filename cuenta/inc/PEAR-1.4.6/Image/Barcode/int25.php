<?php
/* vim: set expandtab tabstop=4 softtabstop=4 shiftwidth=4: */

/**
 * Image_Barcode_int25 class
 *
 * Renders Interleaved 2 of 5 barcodes
 *
 * PHP versions 4
 *
 * LICENSE: This source file is subject to version 3.0 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_0.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   Image
 * @package    Image_Barcode
 * @author     Marcelo Subtil Marcal <msmarcal@php.net>
 * @copyright  2005 The PHP Group
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    CVS: $Id: int25.php,v 1.2 2005/05/30 04:31:41 msmarcal Exp $
 * @link       http://pear.php.net/package/Image_Barcode
 */

require_once INCLUDE_PATH . "PEAR/PEAR.php";
require_once INCLUDE_PATH . "PEAR/Image/Barcode.php";


/**
 * Image_Barcode_int25 class
 *
 * Package which provides a method to create Interleaved 2 of 5 barcode using GD library.
 *
 * @category   Image
 * @package    Image_Barcode
 * @author     Marcelo Subtil Marcal <msmarcal@php.net>
 * @copyright  2005 The PHP Group
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    Release: @package_version@
 * @link       http://pear.php.net/package/Image_Barcode
 */
class Image_Barcode_int25 extends Image_Barcode
{
    /**
     * Barcode type
     * @var string
     */
    var $_type = 'int25';

    /**
     * Barcode height
     *
     * @var integer
     */
    var $_barcodeheight = 38;

    /**
     * Font use to display text
     *
     * @var integer
     */
    var $_font = 2;  // gd internal small font
    
    /**
     * Bar thin width
     *
     * @var integer
     */
    var $_barthinwidth = 1;

    /**
     * Bar thick width
     *
     * @var integer
     */
    var $_barthickwidth = 3;

    /**
     * Coding map
     * @var array
     */
    var $_coding_map = array(
           '0' => '00110',
           '1' => '10001',
           '2' => '01001',
           '3' => '11000',
           '4' => '00101',
           '5' => '10100',
           '6' => '01100',
           '7' => '00011',
           '8' => '10010',
           '9' => '01010'
        );

    /**
     * Draws a Interleaved 2 of 5 image barcode
     *
     * @param  string $text     A text that should be in the image barcode
     * @param  string $imgtype  The image type that will be generated
     *
     * @return image            The corresponding Interleaved 2 of 5 image barcode
     *
     * @access public
     *
     * @author Marcelo Subtil Marcal <msmarcal@php.net>
     * @since  Image_Barcode 0.3
     */

    function draw($text, $imgtype = 'png')
    {

        $text = trim($text);

        if (!preg_match("/[0-9]/",$text)) return;

        // if odd $text lenght adds a '0' at string beginning
        $text = strlen($text) % 2 ? '0' . $text : $text;

        // Calculate the barcode width
/*
        $barcodewidth = (strlen($text)) * (3 * $this->_barthinwidth + 2 * $this->_barthickwidth) +
            (strlen($text)) * 2.5 +
            (7 * $this->_barthinwidth + $this->_barthickwidth) + 3;
*/

        $barcodewidth = 600;
        $barcodefullheight = ( ( int)( imagefontheight( $this->_font))) + $this->_barcodeheight;
            
        // Create the image
        $img = ImageCreate($barcodewidth, $barcodefullheight);

        // Alocate the black and white colors
        $black = ImageColorAllocate($img, 0, 0, 0);
        $white = ImageColorAllocate($img, 255, 255, 255);

        // Fill image with white color
        imagefill($img, 0, 0, $white);

        // Initiate x position
        $xpos = 0;

        // Draws the leader
        for ($i=0; $i < 2; $i++) {
            $elementwidth = $this->_barthinwidth;
            imagefilledrectangle($img, $xpos, 0, $xpos + $elementwidth - 1, $this->_barcodeheight, $black);
            $xpos += $elementwidth -1;  // Patch by Fdx: Orig line: $xpos += $elementwidth;
            $xpos += $this->_barthinwidth;
            $xpos ++;
        }

        // Draw $text contents
        for ($idx = 0; $idx < strlen($text); $idx += 2) {       // Draw 2 chars at a time
            $oddchar  = substr($text, $idx, 1);                 // get odd char
            $evenchar = substr($text, $idx + 1, 1);             // get even char

            // interleave
            for ($baridx = 0; $baridx < 5; $baridx++) {

                // Draws odd char corresponding bar (black)
                $elementwidth = (substr($this->_coding_map[$oddchar], $baridx, 1)) ?  $this->_barthickwidth : $this->_barthinwidth;
                imagefilledrectangle($img, $xpos, 0, $xpos + $elementwidth - 1, $this->_barcodeheight, $black);
                $xpos += $elementwidth; // Patch by Fdx: Orig line: $xpos += $elementwidth;

                // Left enought space to draw even char (white)
                $elementwidth = (substr($this->_coding_map[$evenchar], $baridx, 1)) ?  $this->_barthickwidth : $this->_barthinwidth;
                $xpos += $elementwidth -1; 
                $xpos ++;
            }
        }


        // Draws the trailer
        $elementwidth = $this->_barthickwidth;
        imagefilledrectangle($img, $xpos, 0, $xpos + $elementwidth - 1, $this->_barcodeheight, $black);
        $xpos += $elementwidth -1;  // Patch by Fdx: Orig line: $xpos += $elementwidth;
        $xpos += $this->_barthinwidth;
        $xpos ++;
        $elementwidth = $this->_barthinwidth;
        imagefilledrectangle($img, $xpos, 0, $xpos + $elementwidth - 1, $this->_barcodeheight, $black);

        
        // Calculating the real width.
        $realwidth = $xpos +1;

        // Croping the image to the real size.
        $cropimg = imagecreate( $realwidth, $barcodefullheight);
        imagecopyresized( $cropimg, $img, 0, 0, 0, 0, $realwidth, $barcodefullheight, $realwidth, $barcodefullheight);
        imagedestroy( $img);

        // Draws the digits
        $txtwidth = ( ( int)strlen( $text)) * imagefontwidth( $this->_font);
        imagestring( $cropimg, $this->_font, ( int)(( $realwidth - $txtwidth) / 2), $this->_barcodeheight, $text, $black);
        
        // Send image to browser
        switch($imgtype) {

            case 'gif':
                header("Content-type: image/gif");
                imagegif($cropimg);
                imagedestroy($cropimg);
            break;

            case 'jpg':
                header("Content-type: image/jpg");
                imagejpeg($cropimg);
                imagedestroy($cropimg);
            break;

            default:
                header("Content-type: image/png");
                imagepng($cropimg);
                imagedestroy($cropimg);
            break;

        }

        return;

    } // function create

} // class
