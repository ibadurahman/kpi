<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/*
 * Helper functions for building a DataTables server-side processing SQL query
 *
 * The static functions in this class are just helper functions to help build
 * the SQL used in the DataTables demo server-side processing scripts. These
 * functions obviously do not represent all that can be done with server-side
 * processing, they are intentionally simple to show how it works. More complex
 * server-side processing operations will likely require a custom script.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */

class Ssp {

	protected $webDB = null;
	
	/**
	 * Create the data output array for the DataTables rows
	 *
	 *  @param  array $columns Column information array
	 *  @param  array $data    Data from the SQL get
	 *  @return array          Formatted data in a row based format
	 */
	static function data_output ( $columns, $data, $numbering_start)
	{            //var_dump($data);
		$out = array();
		for ( $i=0, $ien=count($data) ; $i<$ien ; $i++ ) {
			$row = array();

			for ( $j=0, $jen=count($columns) ; $j<$jen ; $j++ ) {
				$column = $columns[$j];
				$row_data ='';
				//is hidden ?
				if(!isset ($column['hidden'])){
					// Is there a formatter?
					if ( isset( $column['formatter'] ) ) {
						//check whether there's field name alias
						if(strripos($columns[$j]['db'],' as ')!==FALSE)
						{
							//explode and get the most right array as field name
							$clean_field_name = explode(' as ',$columns[$j]['db']);
							$field_name = trim($clean_field_name[1]);
						} 
						else
						{
							//check whether there's . on column name
							if(strripos($columns[$j]['db'],'.')!==FALSE)
							{
								//explode and get the most right array as field name
								$clean_field_name = explode('.',$columns[$j]['db']);
								$field_name = trim($clean_field_name[1]);
							}
							else
							{
								$field_name = $columns[$j]['db'];
							}
						}
						if(!empty($data[$i][ $field_name ]))
						{
							$row[ $column['dt'] ] = $column['formatter']( $data[$i][ $field_name ], $data[$i] );
						}
						else
						{
							$row[ $column['dt'] ] = $columns[$j]['default_value'];
						}
						
					}
					else {
						if($j==0)
						{
							$numbering_start++;
							$row[ $column['dt'] ] = $numbering_start;
						}
						else
						{
							if(isset($columns[$j]['db']))
							{
								//check whether there's field name alias
								if(strripos($columns[$j]['db'],' as ')!==FALSE)
								{
									//explode and get the most right array as field name
									$clean_field_name = explode(' as ',$columns[$j]['db']);
									$field_name = trim($clean_field_name[1]);
								} 
								else
								{
									//check whether there's . on column name
									if(strripos($columns[$j]['db'],'.')!==FALSE)
									{
										//explode and get the most right array as field name
										$clean_field_name = explode('.',$columns[$j]['db']);
										$field_name = trim($clean_field_name[1]);
									}
									else
									{
										$field_name = $columns[$j]['db'];
									}
								}

								//check custom format 
								if(isset($columns[$j]['custom_format']))
								{
									if(isset($columns[$j]['custom_format']['data']))
									{
										$row_data = $columns[$j]['custom_format']['data'][$data[$i][$field_name]];
									}
									if(isset($columns[$j]['custom_format']['custom_link']))
									{
										if(empty($row_data))
										{
											$row_data = '<a href="'.$columns[$j]['custom_format']['custom_link'].'/'.urlencode(str_replace(" ", "%20", $data[$i][$field_name])).'" [style]>'.$data[$i][$field_name].'</a>';
										}
										else
										{
											$row_data = '<a href="'.$columns[$j]['custom_format']['custom_link'].'/'.urlencode(str_replace(" ", "%20", $row_data)).'" [style]>'.$row_data.'</a>';	
										}
										
									}
									if(isset($columns[$j]['custom_format']['image']))
									{
										if(isset($columns[$j]['custom_format']['encrypted']))
										{
											if(file_exists(FCPATH.$columns[$j]['custom_format']['image'].'/'.$data[$i][$field_name]))
											{
												//read image 
												$r_file = file_get_contents($columns[$j]['custom_format']['image'].'/'.$data[$i][$field_name]);
												//decrypt
												$d_file = SSP::hex2bin($r_file);
												$row_data = '<img src="data:image/jpeg;base64,'.base64_encode($d_file).'" width="'.$columns[$j]['custom_format']['image_width'].'" height="'.$columns[$j]['custom_format']['image_height'].'">';
											}
											else
											{
												$row_data = 'File Missing';
											}
										}
										else
										{
											$remote_exists = FALSE;
											$filename= $columns[$j]['custom_format']['image'].'/'.$data[$i][$field_name];
											if(!is_null($data[$i][$field_name]) && isset($columns[$j]['custom_format']['image_ext']))
											{
												$filename = $filename.$columns[$j]['custom_format']['image_ext'];
											}
											$file_headers = @get_headers($filename);
											if($file_headers[0] == 'HTTP/1.0 404 Not Found'){
											     $remote_exists = FALSE;
											} else if ($file_headers[0] == 'HTTP/1.0 302 Found' && $file_headers[7] == 'HTTP/1.0 404 Not Found'){
											    $remote_exists = FALSE;
											} else {
											    $remote_exists = TRUE;
											}
											//$check_file_exists = str_replace(base_url(), FCPATH, $columns[$j]['custom_format']['image'].'/'.$data[$i][$field_name]);
											if($remote_exists)
											{
												
												if(!is_null($data[$i][$field_name] && isset($columns[$j]['custom_format']['image_ext'])))
												{
													$row_data = '<img src="'.$columns[$j]['custom_format']['image'].'/'.$data[$i][$field_name].$columns[$j]['custom_format']['image_ext'].'" width="'.$columns[$j]['custom_format']['image_width'].'" height="'.$columns[$j]['custom_format']['image_height'].'">';	
												}
												else
												{
													$row_data = '<img src="'.$columns[$j]['custom_format']['image'].'/'.$data[$i][$field_name].'" width="'.$columns[$j]['custom_format']['image_width'].'" height="'.$columns[$j]['custom_format']['image_height'].'">';		
												}
											}
											else
											{
												$row_data = 'File Missing';
											}
										}
									}
									if(isset($columns[$j]['custom_format']['ucwords']))
									{
										if(!empty($row_data))
										{
											$row_data = ucwords($row_data);
										}
										else
										{
											$row_data =  ucwords($data[$i][$field_name]);
										}
									}
									if(isset($columns[$j]['custom_format']['def_val']))
									{
										if(empty($data[$i][$field_name]))
										{
											$row_data = $columns[$j]['custom_format']['def_val'];
										}
									}
									if(isset($columns[$j]['custom_format']['center']))
									{
										if(!empty($row_data))
										{
											$row_data = "<center>".$row_data."</center>";
										}
										else
										{
											$row_data =  "<center>".$data[$i][$field_name]."</center>";
										}
									}
									if(isset($columns[$j]['custom_style']['condition']))
									{										
										foreach($columns[$j]['custom_style']['condition'] as $id_col=>$val_col)
										{
											$custom_style = false;
											//check whether there's 'as' on column name
											if(strripos($columns[$id_col]['db'],' as ')!==FALSE)
											{
												$clean_field_name = explode(' as ',$columns[$id_col]['db']);
												$l_field = trim($clean_field_name[1]);
											}
											else
											{
												//check whether there's . on column name
												if(strripos($columns[$id_col]['db'],'.')!==FALSE)
												{
													//explode and get the most right array as field name
													$clean_field_name = explode('.',$columns[$id_col]['db']);
													$l_field = trim($clean_field_name[1]);
													//clear all punctuation
													$l_field = str_replace(",", "", $l_field);
													$l_field = str_replace('"', "", $l_field);
												}
												else
												{
													$l_field = $columns[$id_col]['db'];
												}
											}
											if($data[$i][$l_field] == $val_col)
											{
												$custom_style = true;
												break;	
											}
										}
										if($custom_style)
										{

											$row_data = str_replace('[style]', $columns[$j]['custom_style']['style'], $row_data);
										}
									}

									//check whether tag [style] is not replaced
									if(strripos($row_data, '[style]')!==FALSE)
									{
										//replace with empty
										$row_data = str_replace('[style]', '', $row_data);
									}
								} 
								else
								{
									//check empty
									//$row_data = $data[$i][$field_name];
									
									if(empty($data[$i][$field_name]) && isset($columns[$j]['default_value']))
									{
										$row_data = $columns[$j]['default_value'];
									}
									else
									{
										$row_data = $data[$i][$field_name];
									}
									
								}
							}
							else
							{
								//action
								//print_r($data[$i]);die();
								if(!empty($columns[$j]['action_link']))
								{
									foreach($columns[$j]['action_link'] as $link_title=>$link_data)
									{	
										$create_icon = false;
										$custom_icon = false;
										$hide_icon = false;
										//check condition 
										if(isset($columns[$j]['condition'][$link_title]))
										{
											foreach($columns[$j]['condition'][$link_title] as $f_number=>$c_value)
											{
												//check whether there's . on column name
												if(strripos($columns[$f_number]['db'],'.')!==FALSE)
												{
													//explode and get the most right array as field name
													$clean_field_name = explode('.',$columns[$f_number]['db']);
													$l_field = trim($clean_field_name[1]);
												}
												else
												{
													$l_field = $columns[$f_number]['db'];
												}
												//check action button condition
												if(strripos($c_value, "|")!==FALSE)
												{
													$explode_cond = explode("|",$c_value);
                                                                                                        
													for($ec=0,$n=count($explode_cond);$ec<$n;$ec++)
													{
														if($data[$i][$l_field] == $explode_cond[$ec])
														{
															$create_icon = true;
															break;	
														}
                                                                                                                else if(strripos($explode_cond[$ec], "!")!==FALSE )
                                                                                                                {
                                                                                                                    if(substr($explode_cond[$ec],1)!=$data[$i][$l_field]){
                                                                                                                    
                                                                                                                        $create_icon = true;
															break;
                                                                                                                    }else{
                                                                                                                        $create_icon = false;
                                                                                                                    }
                                                                                                                }
													}
												}
                                                                                                if(strripos($c_value, "!")!==FALSE)
                                                                                                {
                                                                                                    if(substr($c_value,1)==$data[$i][$l_field]){
                                                                                                        $create_icon = false;
                                                                                                    }
                                                                                                    
                                                                                                }
												if(!$create_icon && $data[$i][$l_field] != $c_value)
												{
													if(isset($columns[$j]['condition_type'][$link_title]))
													{
														//check condition 
														if($columns[$j]['condition_type'][$link_title] == 'icon_change')
														{
															$custom_icon = true;
															$create_icon = true;
														}
														else
														{
															//hide when condition not met
															$create_icon = false;
															$hide_icon = true;
														}
													}
													else
													{
														$create_icon = false;
													}
												}
												else
												{
													$create_icon = true;
												}
											}
										}
										else
										{
											$create_icon = true;
										}

										if($create_icon)
										{
                                                                                    
											if(strripos($columns[$j]['action_lock'], ".")!==FALSE)
											{
												$lock_column = explode('.',$columns[$j]['action_lock']);
												$lock_link = '';
												for($lc=0,$nlc=count($lock_column);$lc<$nlc;$lc++)
												{
													$lock_link .=  $data[$i][$lock_column[$lc]].".";
												}
												$lock_link = trim(substr($lock_link,0,strlen($lock_link)-1));
											}
											else
											{
												$lock_link = $data[$i][$columns[$j]['action_lock']];
											}
                                                                                        $lock_link2="";
                                                                                        if(isset($columns[$j]['action_lock_2']) and $columns[$j]['action_lock_2']!=""){
                                                                                            if(strripos($columns[$j]['action_lock_2'], ".")!==FALSE)
                                                                                            {
                                                                                                    $lock_column = explode('.',$columns[$j]['action_lock_2']);
                                                                                                    $lock_link2 = '';
                                                                                                    for($lc=0,$nlc=count($lock_column);$lc<$nlc;$lc++)
                                                                                                    {
                                                                                                            $lock_link2 .=  $data[$i][$lock_column[$lc]].".";
                                                                                                    }
                                                                                                    $lock_link2 = trim(substr($lock_link2,0,strlen($lock_link2)-1));
                                                                                            }
                                                                                            else
                                                                                            {
                                                                                                    $lock_link2 = $data[$i][$columns[$j]['action_lock_2']];
                                                                                            }
                                                                                        }
                                                                                        //die();
											//check html
											if(strripos($link_data, '>')!==FALSE)
											{
												$clean_link = str_replace('#link_title#', $link_title, $link_data);
												$clean_link = str_replace('#link_class#', $columns[$j]['action_src'][$link_title], $clean_link);
												$clean_link = str_replace('#action_lock#', $lock_link,$clean_link);
												$clean_link = str_replace('#action_lock_2#', $lock_link2,$clean_link);
												if(empty($row_data))
												{
													$row_data = $clean_link;
												}
												else
												{
													$row_data .= $clean_link;
												}
                                                                                                
											}
											else
											{
												//check whether link or js
												if (filter_var($link_data, FILTER_VALIDATE_URL)) { 
												  // you're good
													$useHref = $link_data.'/'.$lock_link;
												}
												else
												{
													$useHref = str_replace('#action_lock#', $lock_link, $link_data);
												}

												if(!$custom_icon)
												{
													if(empty($row_data))
													{

														$row_data = '<a href="'.$useHref.'" rel="tooltip-top" title="'.$link_title.'" class="'.$columns[$j]['action_src'][$link_title].'"></a>';
													}
													else
													{	
														$row_data .= ' <a href="'.$useHref.'" rel="tooltip-top" title="'.$link_title.'" class="'.$columns[$j]['action_src'][$link_title].'"></a>';
													}
													
												}
												else
												{
													if(empty($row_data))
													{
														$row_data = '<a href="'.$useHref.'" rel="tooltip-top" title="'.$link_title.'" class="'.$columns[$j]['action_src_change'][$link_title].'"></a>';	
													}
													else
													{
														$row_data .= ' <a href="'.$useHref.'" rel="tooltip-top" title="'.$link_title.'" class="'.$columns[$j]['action_src_change'][$link_title].'"></a>';	
													}
												}
											}
                                                                                        
										}
										else
										{
											if(!$hide_icon)
											{
												
                                                                                                if(empty($row_data))
												{
                                                                                                        //$row_data = '<center>-</center>';
                                                                                                        $row_data = '';
												}
												else
												{
                                                                                                        //$row_data .= '<center>-</center>';
                                                                                                        $row_data .= '';
												}
											}
										}
										
									}                       
                                                                        
								}
								else
								{
									$row_data = '<center>-</center>';
								}
							}
							if(isset($column['dt']))
							{
								$row[ $column['dt'] ] = $row_data;
                                                                
							}
						}
					}
				} 
			}

			$out[] = $row;
		}

		return $out;
	}


	/**
	 * Paging
	 *
	 * Construct the LIMIT clause for server-side processing SQL query
	 *
	 *  @param  array $request Data sent to server by DataTables
	 *  @param  array $columns Column information array
	 *  @return string SQL limit clause
	 */
	static function limit ( $request, $columns )
	{
		$limit = '';

		if ( isset($request['start']) && $request['length'] != -1 ) {
			$limit = "LIMIT ".intval($request['start']).", ".intval($request['length']);
		}

		return $limit;
	}


	/**
	 * Ordering
	 *
	 * Construct the ORDER BY clause for server-side processing SQL query
	 *
	 *  @param  array $request Data sent to server by DataTables
	 *  @param  array $columns Column information array
	 *  @return string SQL order by clause
	 */
	static function order ( $request, $columns, $primaryKey )
	{
		$order = '';
		$flag_order = false;
		if ( isset($request['order']) && count($request['order']) ) {
			$orderBy = array();
			$dtColumns = SSP::pluck( $columns, 'dt' );
			for ( $i=0, $ien=count($request['order']) ; $i<$ien ; $i++ ) {
				// Convert the column index into the column data property
				$columnIdx = intval($request['order'][$i]['column']);
				$requestColumn = $request['columns'][$columnIdx];
				$columnIdx = array_search( $requestColumn['data'], $dtColumns );
				$column = $columns[ $columnIdx ];

				if ( $requestColumn['orderable'] == 'true' ) {
					$dir = $request['order'][$i]['dir'] === 'asc' ?
						'ASC' :
						'DESC';
					if(isset($column['db']))
					{
						//check whether there's field name alias
						if(strripos($column['db'],' as ')!==FALSE)
						{
							//explode and get the most right array as field name
							$clean_field_name = explode(' as ',$column['db']);
							$field_name = trim($clean_field_name[1]);
						} 
						else
						{
							//check whether there's . on column name
							if(strripos($column['db'],'.')!==FALSE)
							{
								//explode and get the most right array as field name
								$clean_field_name = explode('.',$column['db']);
								$field_name = trim($clean_field_name[1]);
							}
							else
							{
								$field_name =$column['db'];
							}
						}
						$orderBy[] = $field_name.' '.$dir;
						$flag_order = true;
					}
					else
					{
						//check whether column index is 0
						if($columnIdx == 0)
						{
							//order by primary key
							$orderBy[] = $primaryKey.' '.$dir;
							$flag_order = true;
						}
					}
					
				}
			}
			if($flag_order)
			{
				
				$order = 'ORDER BY '.implode(', ', $orderBy);
			}
		}
		return $order;
	}


	/**
	 * Searching / Filtering
	 *
	 * Construct the WHERE clause for server-side processing SQL query.
	 *
	 * NOTE this does not match the built-in DataTables filtering which does it
	 * word by word on any field. It's possible to do here performance on large
	 * databases would be very poor
	 *
	 *  @param  array $request Data sent to server by DataTables
	 *  @param  array $columns Column information array
	 *  @param  array $bindings Array of values for PDO bindings, used in the
	 *    sql_exec() function
	 *  @return string SQL where clause
	 */
	static function filter ( $request, $columns, &$bindings, $custom_where)
	{

		$globalSearch = array();
		$columnSearch = array();
		$dtColumns = SSP::pluck( $columns, 'dt' );

		if ( isset($request['search']) && $request['search']['value'] != '' ) {
			$str = $request['search']['value'];

			for ( $i=0, $ien=count($request['columns']) ; $i<$ien ; $i++ ) {
				$requestColumn = $request['columns'][$i];
				$columnIdx = array_search( $requestColumn['data'], $dtColumns );
				$column = $columns[ $columnIdx ];

				if ( $requestColumn['searchable'] == 'true' ) {
					if(!isset($column['searchable']) || $column['searchable'])
						$binding = SSP::bind( $bindings, '%'.$str.'%', PDO::PARAM_STR );
					if(isset($column['db']))
					{
						if(strripos($column['db'], "count") === FALSE)
						{
							//check whether there's field name alias
							if(strripos($column['db'],' as ')!==FALSE)
							{
								//explode and get the most right array as field name
								$clean_field_name = explode(' as ',$column['db']);
								$field_name = trim($clean_field_name[0]);
							} 
							else
							{
								
									$field_name =$column['db'];
								
							}
							$globalSearch[] = $field_name." LIKE ".$binding;
						}
						else
						{
							
						}
					}
				}
			}
		}

		// Individual column filtering
		for ( $i=0, $ien=count($request['columns']) ; $i<$ien ; $i++ ) {
			$requestColumn = $request['columns'][$i];
			$columnIdx = array_search( $requestColumn['data'], $dtColumns );
			$column = $columns[ $columnIdx ];

			$str = $requestColumn['search']['value'];
			if ( $requestColumn['searchable'] == 'true' &&
			 $str != '' ) {
				if(!isset($column['searchable']) || $column['searchable'])
					$binding = SSP::bind( $bindings, '%'.$str.'%', PDO::PARAM_STR );
				if(isset($column['db']))
				{
					//check whether there's field name alias
					if(strripos($column['db'],' as ')!==FALSE)
					{
						//explode and get the most right array as field name
						$clean_field_name = explode(' as ',$column['db']);
						$field_name = trim($clean_field_name[0]);
					} 
					else
					{
						
							$field_name =$column['db'];
						
					}
					$columnSearch[] = $field_name." LIKE ".$binding;
				}
			}
		}

		// Combine the filters into a single string
		$where = '';

		if ( count( $globalSearch ) ) {
			$where = '('.implode(' OR ', $globalSearch).')';
		}

		if ( count( $columnSearch ) ) {
			$where = $where === '' ?
				implode(' AND ', $columnSearch) :
				$where .' AND '. implode(' AND ', $columnSearch);
		}

		if ( $where !== '' ) {
			if(empty($custom_where))
			{
				$where = 'WHERE '.$where;
			}
			else
			{
				$where = 'WHERE '.$custom_where.' AND '.$where;
			}
		}
		else
		{
			if(!empty($custom_where))
			{
				$where = 'WHERE '.$custom_where;
			}
		}
		return $where;
	}


	/**
	 * Perform the SQL queries needed for an server-side processing requested,
	 * utilising the helper functions of this class, limit(), order() and
	 * filter() among others. The returned array is ready to be encoded as JSON
	 * in response to an SSP request, or can be modified if needed before
	 * sending back to the client.
	 *
	 *  @param  array $request Data sent to server by DataTables
	 *  @param  array $sql_details SQL connection details - see sql_connect()
	 *  @param  string $table SQL table to query
	 *  @param  string $primaryKey Primary key of the table
	 *  @param  array $columns Column information array
	 *  @return array          Server-side processing response array
	 */
	static function simple ( $request, $table, $primaryKey, $columns, $custom_where='', $secondary_database='', $group_cond='')
	{
		$bindings = array();
		//$db = SSP::sql_connect( $sql_details );
		$db='';
		// Build the SQL query string from the request
		$limit = SSP::limit( $request, $columns );
		$order = SSP::order( $request, $columns, $primaryKey );
		$where = SSP::filter( $request, $columns, $bindings, $custom_where );

		// Main query to actually get the data

		$data = SSP::sql_exec( $bindings,
			"SELECT SQL_CALC_FOUND_ROWS ".implode(", ", SSP::pluck($columns, 'db'))."
			 FROM $table
			 $where
			 $group_cond
			 $order
			 $limit"
			 ,$secondary_database
		);

		// Data set length after filtering
		$resFilterLength = SSP::sql_exec( 
			"SELECT FOUND_ROWS() as found_row",null,$secondary_database
		);
		//print_r($resFilterLength);die();
		$recordsFiltered = $resFilterLength[0]['found_row'];

		// Total data set length
		$resTotalLength = SSP::sql_exec( 
			"SELECT COUNT({$primaryKey}) as count_primary
			 FROM   $table",null,$secondary_database
		);
		$recordsTotal = $resTotalLength[0]['count_primary'];


		/*
		 * Output
		 */
		return array(
			"draw"            => intval( $request['draw'] ),
			"recordsTotal"    => intval( $recordsTotal ),
			"recordsFiltered" => intval( $recordsFiltered ),
			"data"            => SSP::data_output( $columns, $data, $request['start'])
		);
	}


	/**
	 * Connect to the database
	 *
	 * @param  array $sql_details SQL server connection details array, with the
	 *   properties:
	 *     * host - host name
	 *     * db   - database name
	 *     * user - user name
	 *     * pass - user password
	 * @return resource Database connection handle
	 */
	static function sql_connect ( $sql_details )
	{
		try {
			$db = @new PDO(
				"mysql:host={$sql_details['host']};dbname={$sql_details['db']}",
				$sql_details['user'],
				$sql_details['pass'],
				array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION )
			);
		}
		catch (PDOException $e) {
			SSP::fatal(
				"An error occurred while connecting to the database. ".
				"The error reported by the server was: ".$e->getMessage()
			);
		}

		return $db;
	}


	/**
	 * Execute an SQL query on the database
	 *
	 * @param  resource $db  Database handler
	 * @param  array    $bindings Array of PDO binding values from bind() to be
	 *   used for safely escaping strings. Note that this can be given as the
	 *   SQL query string if no bindings are required.
	 * @param  string   $sql SQL query to execute.
	 * @return array         Result from the query (all rows)
	 */
	static function sql_exec ( $bindings, $sql=null,$secondary_database)
	{
		global $webDB;
		// Argument shifting
		if ( $sql === null ) {
			$sql = $bindings;
		}

		//dataTables ORIGINAL !
		/*
		$stmt = $db->prepare( $sql );
		//echo $sql;

		// Bind parameters
		if ( is_array( $bindings ) ) {
			for ( $i=0, $ien=count($bindings) ; $i<$ien ; $i++ ) {
				$binding = $bindings[$i];
				$stmt->bindValue( $binding['key'], $binding['val'], $binding['type'] );
			}
		}

		// Execute
		try {
			$stmt->execute();
		}
		catch (PDOException $e) {
			SSP::fatal( "An SQL error occurred: ".$e->getMessage() );
		}

		// Return all
		return $stmt->fetchAll();
		*/

		/**
		*	Acid CodeIgniter Modification 
		*	
		*	Modification to meet CodeIgniter (CI) Structure
		*	
		**/
		$CI =& get_instance();
		if(empty($secondary_database))
		{
			if(is_array($bindings)){
				return $CI->db->query($sql,$bindings)->result_array();
			} 
			else
			{
				return $CI->db->query($sql)->result_array();
			}
		}
		else
		{
			if(is_null($webDB))
			{
				$webDB = $CI->load->database($secondary_database, TRUE);
			}
			if(is_array($bindings)){
				//print_r($bindings);die();
				return $webDB->query($sql,$bindings)->result_array();
			} 
			else
			{
				return $webDB->query($sql)->result_array();
			}
		}
		

	}


	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Internal methods
	 */

	/**
	 * Throw a fatal error.
	 *
	 * This writes out an error message in a JSON string which DataTables will
	 * see and show to the user in the browser.
	 *
	 * @param  string $msg Message to send to the client
	 */
	static function fatal ( $msg )
	{
		echo json_encode( array( 
			"error" => $msg
		) );

		exit(0);
	}

	/**
	 * Create a PDO binding key which can be used for escaping variables safely
	 * when executing a query with sql_exec()
	 *
	 * @param  array &$a    Array of bindings
	 * @param  *      $val  Value to bind
	 * @param  int    $type PDO field type
	 * @return string       Bound key to be used in the SQL where this parameter
	 *   would be used.
	 */
	static function bind ( &$a, $val, $type )
	{
		//$key = ':binding_'.count( $a );
		$key = '?';
		$a[]=$val;
		/*
		$a[] = array(
			'key' => $key,
			'val' => $val,
			'type' => $type
		);
		*/
		return $key;
	}


	/**
	 * Pull a particular property from each assoc. array in a numeric array, 
	 * returning and array of the property values from each item.
	 *
	 *  @param  array  $a    Array to get data from
	 *  @param  string $prop Property to read
	 *  @return array        Array of property values
	 */
	static function pluck ( $a, $prop )
	{
		$out = array();

		for ( $i=0, $len=count($a) ; $i<$len ; $i++ ) {
			if(isset($a[$i][$prop])){
				$out[] = $a[$i][$prop];	
			}
		}

		return $out;
	}
	
}
