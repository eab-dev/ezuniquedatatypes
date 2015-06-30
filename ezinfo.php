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

class ezuniquedatatypesInfo {


    /**
     * Who when what where why how come
     *
     * @return array
     */
    function info()
    {
        return array( 'Name' => 'eZ Unique Datatypes',
                      'Version' => '0.5 beta',
                      'Copyright' => 'Copyright (C) 2007-'.date("Y").' <a href="http://www.mediaself.pl/" target="_blank">mediaSELF.pl</a>',
                      'Author' => 'Piotr Karaś',
                      'License' => 'GNU General Public License v2.0'
                    );
    }


}

?>
