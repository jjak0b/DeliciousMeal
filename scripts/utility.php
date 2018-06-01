<?php
// se manca o è vuoto un elmento di un array, rimuove il relativo elemento dell'altro array con lo stesso indice
            
            function debug_print( $str )
            {
                if( isset( $_SESSION["debug"] )&& $_SESSION["debug"] )
                {
                    echo "<code>$str</code><br>\n";
                }
            }
            function remove_useless_elems( &$attributes, &$values )
            {
                foreach ($values as $key => $value) {
                    if( $value == "" || $attributes[ $key ] == "")
                    {
                        unset(  $values[ $key ] );
                        unset(  $attributes[ $key ] );
                    }
                }
            }
            function getIdList( $array ) {
                $ids = [];
                foreach ($array as $key => $value) {
                    $ids[] = $value['id'];
                }
                return $ids;
            }
            function indecizzaArray( $array, $index )
            {
                $new_array = [];
                foreach ($array as $key => $value) {
                    $key = $value[ $index ];
                    $new_array[ $key ] = $value;
                }
                return $new_array;
            }   
            
            function indecizzaArrayPerId( $array )
            {
                 // return indecizzaArray( $array, "id" );
                $new_array = [];
                foreach ($array as $key => $value) {
                    $id = $value['id'];
                    $new_array[ $id ] = $value;
                }
                return $new_array;
            }    
            function get_login_query( $tableName, $str_email, $str_password )
            {
                $tableName = "utenti u";
                $query = "SELECT * FROM $tableName";
                $sql = array();
                
                if ($str_email!= "") {
                    $sql[] = "u.email = '$str_email' ";
                }
                if ($str_password!= "") {
                    $sql[] = " u.password = '$str_password' ";
                }
                if ( !empty($sql) )
                {
                    $query .= ' WHERE ' . implode(' AND ', $sql);
                }
                 $query .=";";
                 return $query;
            }
            
            // costruisce una select semplice avendo i parametri settati, le condizioni vengono fatte in ugualianza in sequenza tra i $attributes e $values nello stesso indice
            function quick_select2( $select_list, $table_list, $attributes, $values)// i valori non vengono messi tra ''
            {
                $query = "SELECT ";
                if ( !empty($select_list) )
                {
                    $query .= implode(', ', $select_list);
                }
                else {
                    $query .= '*';
                }
                
                $query .=" FROM ";
                if ( !empty($table_list) )
                {
                    $query .= implode(', ', $table_list);
                }
                
                if ( !empty($attributes) && !empty( $values ) )
                {
                    for ($index = 0; $index < count($attributes); $index++) {
                        $keys_attributes = array_keys($attributes);
                        $keys_values = array_keys($values);
                        
                        $value = $values[ $keys_values[ $index ] ];
                        $attribute= $attributes[ $keys_attributes[ $index ] ];
                        $sql[] = " $attribute = $value";
                    }
                }
                if ( !empty($sql) )
                {
                    $query .= ' WHERE ' . implode(' AND ', $sql);
                }
                
                // $query .= ';';
                return $query;
            }
            
            // costruisce una select semplice avendo i parametri settati,
            // le condizioni vengono fatte in ugualianza
            // in sequenza tra i $attributes e $values nello stesso indice
            function quick_select( $select_list, $table_list, $attributes, $values)
            {
                $query = "SELECT ";
                if ( !empty($select_list) )
                {
                    $query .= implode(', ', $select_list);
                }
                else {
                    $query .= '*';
                }
                
                $query .=" FROM ";
                if ( !empty($table_list) )
                {
                    $query .= implode(', ', $table_list);
                }
                
                if ( !empty($attributes) && !empty( $values ) )
                {
                    for ($index = 0; $index < count($attributes); $index++) {
                        $keys_attributes = array_keys($attributes);
                        $keys_values = array_keys($values);
                        
                        $value = $values[ $keys_values[ $index ] ];
                        $attribute= $attributes[ $keys_attributes[ $index ] ];
                        $sql[] = " $attribute = '$value'";
                    }
                }
                if ( !empty($sql) )
                {
                    $query .= ' WHERE ' . implode(' AND ', $sql);
                }
                
                // $query .= ';';
                return $query;
            }
            
            function select_any( $select_list, $table_list, $str_attribute, $values)
            {
                $query = "SELECT ";
                if ( !empty($select_list) )
                {
                    $query .= implode(', ', $select_list);
                }
                else {
                    $query .= '*';
                }
                
                $query .=" FROM ";
                if ( !empty($table_list) )
                {
                    $query .= implode(', ', $table_list);
                }
                
                if ( !empty($str_attribute) && !empty( $values ) )
                {
                    foreach ($values as $key => $value) {
                        $sql[] = " $str_attribute = '$value'";
                    }
                }
                if ( !empty($sql) )
                {
                    $query .= ' WHERE (' . implode(' OR ', $sql) . ')';
                }
                
                // query .= ';';
                return $query;
            }
            
            function search_like( $select_list, $table_list, $str_attribute, $values){
                $query = "SELECT ";
                if ( !empty($select_list) )
                {
                    $query .= implode(', ', $select_list);
                }
                else {
                    $query .= '*';
                }
                
                $query .=" FROM ";
                if ( !empty($table_list) )
                {
                    $query .= implode(', ', $table_list);
                }
                
                if ( !empty($str_attribute) && !empty( $values ) )
                {
                    foreach ($values as $key => $value) {
                        $sql[] = " $str_attribute LIKE \"%$value%\"";
                    }
                }
                if ( !empty($sql) )
                {
                    $query .= ' WHERE (' . implode(' OR ', $sql) . ')';
                }
                
                // query .= ';';
                return $query;
            }
            
            function insert($str_table, $attributes, $values, $b_update = TRUE )
            {
                foreach ($values as $key => $value) {
                    if( empty( $value ) ){
                        $values[$key] = "NULL";
                    }
                    else{
                        $values[ $key ] = "\"$value\"";
                    }
                }
                $query = "INSERT INTO $str_table(";
                
                // attributi
                if ( !empty( $values ) ){
                    $query .= implode(', ', $attributes );
                }
                
                $query .=" ) VALUES ( ";
                // attributi
                if ( !empty( $values ) )
                {
                    $query .= implode(', ', $values );
                }
                $query .=")";
                
                if( $b_update ){
                    $a_keys = array_keys( $attributes );
                    $v_keys = array_keys( $values );
                    $sql = array();
                    $query .=" ON DUPLICATE KEY UPDATE ";
                    for ($i = 0; $i < count($a_keys); $i++) {
                        $sql[] = " ".$attributes[$a_keys[$i]]."=".$values[$v_keys[$i]]." ";
                    }
                    $query .= implode(', ', $sql );
                }
                
                return $query;
            }
            
            function empty_filter( $value )
            {
                if($value == "" || $value == NULL)
                {
                    return FALSE;
                }
                return TRUE;
            }
            
            function attribute_value_filter( $array )
            {
                $attribute = $array[ 0 ];
                $value = $array[ 1 ];
                if( $attribute == NULL || value == "" )
                {
                    return false;
                }
                return true;
            }