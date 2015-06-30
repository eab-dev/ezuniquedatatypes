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


class eZUniqueStringType extends eZStringType
{

    const EZUNIQUESTRING_DEBUG = 0;
    const DATA_TYPE_STRING = 'ezuniquestring';


    /**
     * Construct
     *
     */
    public function __construct()
    {
        $this->eZDataType( self::DATA_TYPE_STRING, ezi18n( 'extension/ezuniquedatatypes', 'Unique string' ),
        array( 'serialize_supported' => true,
                                  'object_serialize_map' => array( 'data_text' => 'text' ) ) );
        $this->MaxLenValidator = new eZIntegerValidator();
    }


    /**
     * This method is almost identical with the one from extended class,
     * It simply adds a call to a method dedicated to uniqueness validation
     *
     * @param unknown_type $data
     * @param unknown_type $contentObjectAttribute
     * @param unknown_type $classAttribute
     * @return unknown
     */
    function validateStringHTTPInput( $data, $contentObjectAttribute, $classAttribute )
    {
        $maxLen = $classAttribute->attribute( self::MAX_LEN_FIELD );
        $textCodec = eZTextCodec::instance( false );
        if ( $textCodec->strlen( $data ) > $maxLen && $maxLen > 0 )
        {
            $contentObjectAttribute->setValidationError( ezi18n( 'kernel/classes/datatypes', 'The input text is too long. The maximum number of characters allowed is %1.' ), $maxLen );
            return eZInputValidator::STATE_INVALID;
        }
        return self::validateUniqueStringHTTPInput( $data, $contentObjectAttribute );
    }


    /**
     * This method checks if given string does exist in any content object
     * attributes with the same id, with the exception for those being versions
     * of the same content object. If given string exists anywhere, in published
     * or unpublished versions, drafts, trash, this string will be excluded.
     *
     * More information in the ini file uniquedatatypes.ini.append.php
     *
     * @param string $data
     * @param object $contentObjectAttribute
     * @return integer
     */
    private static function validateUniqueStringHTTPInput( $data, $contentObjectAttribute )
    {
        $contentObjectID = $contentObjectAttribute->ContentObjectID;
        $contentClassAttributeID = $contentObjectAttribute->ContentClassAttributeID;
        $db = eZDB::instance();

        $ini = eZINI::instance( 'uniquedatatypes.ini' );
        $uniqueStringINI = $ini->group( 'UniqueStringSettings' );

        if( $uniqueStringINI['CurrentVersionOnly'] == 'true' )
        {
            $query = "SELECT COUNT(*) AS datacounter
				FROM ezcontentobject co, ezcontentobject_attribute coa
				WHERE co.id = coa.contentobject_id
				AND co.current_version = coa.version
				AND coa.contentobject_id <> ".$db->escapeString( $contentObjectID )."
				AND coa.contentclassattribute_id = ".$db->escapeString( $contentClassAttributeID )."
				AND coa.data_text = '".$db->escapeString( $data )."'";
        }
        else
        {
            $query = "SELECT COUNT(*) AS datacounter
				FROM ezcontentobject_attribute
				WHERE contentobject_id <> ".$db->escapeString( $contentObjectID )."
				AND contentclassattribute_id = ".$db->escapeString( $contentClassAttributeID )."
				AND data_text = '".$db->escapeString( $data )."'";
        }

        if( self::EZUNIQUESTRING_DEBUG )
        {
            eZDebug::writeDebug('Query: '.$query, 'eZUniqueStringType::validateUniqueStringHTTPInput');
        }

        $result = $db->arrayQuery( $query );
        $resultCount = $result[0]['datacounter'];

        if( $resultCount )
        {
            $contentObjectAttribute->setValidationError( ezi18n( 'extension/ezuniquedatatypes', 'Given string alread exists in another content object of this type!' ) );
            return eZInputValidator::STATE_INVALID;
        }

        return eZInputValidator::STATE_ACCEPTED;
    }


}

eZDataType::register( eZUniqueStringType::DATA_TYPE_STRING, "eZUniqueStringType" );

?>
