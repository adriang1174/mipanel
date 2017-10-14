<?
 /************************************************************************
 *       Copyright (C) 2000, by SUB1 SA . All rights reserved.			 *
 *       No part of this software may be reproduced                      *
 *       in any form or by any means - graphic, electronic or            *
 *       mechanical, including photocopying, recording, taping           *
 *       or information storage and retrieval systems - except           *
 *       with the written permission of SUB1 SA.                         *
 *************************************************************************
 *       Copyright (C) 2000, SUB1 SA . Todos los derechos reservados.	 *
 *       Prohibida la reproduccion total o parcial de este software,     *
 *       cualquiera sea el medio - grafico, electronico o mecanico -     *
 *       salvo expreso permiso escrito de SUB1 SA                        *
 *																		 *
 *************************************************************************/

//	00/11/20	Gaston	Modificacion para compatiblizarlo con el COM

function CRY_Encrypt ( $Msg, $Key )
{
	if( strlen( $Key ) != 48 )
	{
		return( -1 );
	}

    $MsgLen		= strlen ( $Msg ) ;
    $Ctrl		= 0 ;
	$MsgFinal	= "";

    for ( $i = 0; $i < $MsgLen; $i++ )
    {
        $Pos = $i % 16 ;

        if ( $Pos == 0 )
        {
            if ( $i > 0 )
            {
				$Part = $Ctrl ^ ord ( substr( $Key , 32 , 1 ) ); // 16 + 17 - 1
                $MsgFinal = $MsgFinal . sprintf ( "%02x", $Part ) ;
            }

            $Ctrl = 0 ;

        }

        $Part    = ord ( substr( $Msg , $i , 1 ) ) ^ ord ( substr( $Key , $Pos , 1 ) );
		$Ctrl    = $Ctrl ^ $Part ;

        $Part    = $Part ^ ord ( substr( $Key , ( 16 + $Pos ) , 1 ) );

		$MsgFinal = $MsgFinal . sprintf ( "%02x", $Part ) ;

    }

    $Part = $Ctrl ^ ord ( substr( $Key , 32 , 1 ) ); // 16 + 17 - 1
    $MsgFinal = $MsgFinal . sprintf ( "%02x" , $Part  ) ;

	return ( $MsgFinal ) ;
}


function CRY_Decrypt ( $Msg, $Key )
{

	if( strlen( $Key ) != 48 )
	{
		return( -1 );
	}

    $MsgLen		= strlen ( $Msg ) ;
    $Ctrl		= 0 ;
	$MsgFinal	= "";

    for ( $i = 0; $i < ( ( $MsgLen / 2 ) - 1 ) ; $i++ )
    {
        $Pos = $i % 17 ;

        if ( $Pos == 16 )
        {
            if ( $i > 0 )
            {
                $Part = hexdec ( substr( $Msg  , ( $i * 2 ) , 2 ) ) ;
                $Ctrl = $Ctrl ^ ord ( substr ( $Key , 32 , 1 ) ) ;

                if ( $Ctrl != $Part )
                {
                    return ( -1 ) ;
                }
            }

            $Ctrl = 0 ;

            continue ;

        }

        $Part = hexdec ( substr( $Msg  , ( $i * 2 ) , 2 ) ) ;

        $Part    = $Part ^ ord ( substr ( $Key , ( 16 + $Pos ) , 1 ) ) ;
        $Ctrl    = $Ctrl ^ $Part ;
        $Part    = $Part ^ ord ( substr ( $Key , $Pos , 1 ) ) ;

        if ( $i < ( ( $MsgLen / 2 ) - 1 ) )
        {
			$MsgFinal = $MsgFinal . chr ($Part ) ;
	    }
    }

    // Tomo el Ultimo Elemento para descartarlo del CTRL
    $Part = hexdec ( substr( $Msg  , ( $MsgLen - 2 )  , 2 ) ) ;

	$Ctrl = $Ctrl ^ ord ( substr ( $Key , 32 , 1 ) ) ;

	if ( $Ctrl != $Part )
	{
		return ( -1 ) ;
	}

	return ( $MsgFinal ) ;

}

?>
