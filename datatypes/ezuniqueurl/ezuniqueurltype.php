<?php

/**
 * eZ Unique Datatypes extension for eZ Publish 4.0
 * Written by Piotrek Karas, Copyright (C) SELF s.c.
 * http://www.mediaself.pl, http://ryba.eu
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; version 2 of the License.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 */


class eZUniqueURLType extends eZURLType
{

    const EZUNIQUEURL_DEBUG = 0;
    const DATA_TYPE_STRING = 'ezuniqueurl';


    /**
     * Construct
     *
     */
    public function __construct()
    {
        $this->eZDataType( self::DATA_TYPE_STRING, ezi18n( 'extension/ezuniquedatatypes', "Unique URL"  ),
        array( 'serialize_supported' => true ) );
        $this->MaxLenValidator = new eZIntegerValidator();
    }


    /**
     * Almost identical with the one in extended class, just injects
     * call for uniqness validation method
     *
     * @param unknown_type $http
     * @param unknown_type $base
     * @param unknown_type $contentObjectAttribute
     * @return unknown
     */
    function validateObjectAttributeHTTPInput( $http, $base, $contentObjectAttribute )
    {
        if ( $http->hasPostVariable( $base . "_ezurl_url_" . $contentObjectAttribute->attribute( "id" ) )  and $http->hasPostVariable( $base . "_ezurl_text_" . $contentObjectAttribute->attribute( "id" ) ) )
        {
            $url = $http->PostVariable( $base . "_ezurl_url_" . $contentObjectAttribute->attribute( "id" ) );
            $text = $http->PostVariable( $base . "_ezurl_text_" . $contentObjectAttribute->attribute( "id" ) );
            if ( $contentObjectAttribute->validateIsRequired() )
            {
                if ( ( $url == "" ) or ( $text == "" ) )
                {
                    $contentObjectAttribute->setValidationError( ezi18n( 'kernel/classes/datatypes',
                                                                         'Input required.' ) );
                    return eZInputValidator::STATE_INVALID;
                }
            }

            return self::validateUniqueURLHTTPInput( $url, $contentObjectAttribute );

            // Remove all url-object links to this attribute.
            eZURLObjectLink::removeURLlinkList( $contentObjectAttribute->attribute( "id" ), $contentObjectAttribute->attribute('version') );

        }
        return eZInputValidator::STATE_ACCEPTED;
    }


    /**
     * This method validates unique URL.
     *
     * @param string $data
     * @param object $contentObjectAttribute
     * @return boolean
     */
    public static function validateUniqueURLHTTPInput( $data, $contentObjectAttribute )
    {

        $ini = eZINI::instance( 'uniquedatatypes.ini' );
        $uniqueURLINI = $ini->group( 'UniqueURLSettings' );

        if( count( $uniqueURLINI['AllowedSchemaList'] ) )
        {
            if( !eregi( "^(".implode( '|', $uniqueURLINI['AllowedSchemaList'] ).")", $data ) )
            {
                $contentObjectAttribute->setValidationError( ezi18n( 'extension/ezuniquedatatypes', 'Only URLs beginning with  "%schemas" are accepted!' , '', array( '%schemas' => implode( '", "', $uniqueURLINI['AllowedSchemaList'] ) ) ) );
                return eZInputValidator::STATE_INVALID;
            }
        }

        $url = eZURL::urlByURL( $data );
        if( is_object( $url ) )
        {
            $contentObjectID = $contentObjectAttribute->ContentObjectID;
            $contentClassAttributeID = $contentObjectAttribute->ContentClassAttributeID;
            $db = eZDB::instance();

            if( $uniqueURLINI['CurrentVersionOnly'] == 'true' )
            {
                $query = "SELECT COUNT(*) AS row_counter
					FROM ezcontentobject co, ezcontentobject_attribute coa
					WHERE co.id = coa.contentobject_id
					AND co.current_version = coa.version
					AND coa.contentclassattribute_id = ".$db->escapeString( $contentClassAttributeID )."
					AND coa.contentobject_id <> ".$db->escapeString( $contentObjectID )."
                    AND coa.data_int = ".$db->escapeString( $url->ID );
            }
            else
            {
                $query = "SELECT COUNT(*) AS row_counter
					FROM ezcontentobject_attribute coa
					WHERE coa.contentclassattribute_id = ".$db->escapeString( $contentClassAttributeID )."
					AND coa.contentobject_id <> ".$db->escapeString( $contentObjectID )."
                    AND coa.data_int = ".$db->escapeString( $url->ID );
            }

            if( self::EZUNIQUEURL_DEBUG )
            eZDebug::writeDebug('Query: '.$query, 'eZUniqueURLType::validateUniqueURLHTTPInput');

            $rows = $db->arrayQuery( $query );
            $rowCount = (int)$rows[0]['row_counter'];

            if( $rowCount >= 1 )
            {
                $contentObjectAttribute->setValidationError( ezi18n( 'extension/ezuniquedatatypes', 'Given URL alread exists in another content object of this type!' ) );
                return eZInputValidator::STATE_INVALID;
            }
        }
        return eZInputValidator::STATE_ACCEPTED;
    }


}

eZDataType::register( eZUniqueURLType::DATA_TYPE_STRING, "eZUniqueURLType" );

?>
