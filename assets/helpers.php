<?php

	function __redirect( $url ) {
		$url = trim( $url );
	
		if( preg_match( '/:\/\//', $url ) ) {
			$url = '/404';
			
		} else if( $url{0} != '/' ) {
			$url = '/' . $url;
		}
		
		header( 'location: ' . $url, true );
		die;
	}
	
	function __echoJSON( $data ) {
		header( 'content-type: application/json', true );
		echo json_encode( $data );
		die;
	}
	
	function __throw404Error() {
		header( 'HTTP/1.0 404 Not Found' );
	}

	function __forceUTF8Enconding() {
		header( 'content-type: text/html; charset=utf-8' );
	}
	
// ************** /
// FIREPHP funcionality
// ************* /
	function __initDebugging() {
		global $DEBUG;
		if( $DEBUG ) {
			ob_start();
		}
	}
	
	function ___echoToFirePHP( $type, $args ) {
		require_once './modules/firephp/FirePHP.class.php';
		$firephp = FirePHP::getInstance( true );
		foreach( $args as $arg ) {
			call_user_func_array( array( $firephp, $type ), array( $arg ) );
		}
	}
	
	function __log() {
		global $DEBUG;
		if( $DEBUG ) {
			___echoToFirePHP( 'log', func_get_args() );
		}
	}
	
	function __err() {
		global $DEBUG;
		if( $DEBUG ) {
			___echoToFirePHP( 'error', func_get_args() );
		}
	}
	
// ************** /
// PHPEXCEL funcionality
// ************* /
	function __getPHPExcelInstance() {
		require_once './modules/phpexcel/PHPExcel.php';
		return new PHPExcel();
	}
	
	function __echoPHPExcel( $phpExcel, $filename ) {
		require_once './modules/phpexcel/PHPExcel.php';
		
		header( 'Content-Type: application/vnd.ms-excel' );
		header( 'Content-Disposition: attachment; filename="' . $filename . ' (' . time() . ').xls' . '"' );
		header( 'Cache-Control: max-age=0' );
		
		$excelWriter = PHPExcel_IOFactory::createWriter( $phpExcel, 'Excel5' );
		$excelWriter->setPreCalculateFormulas( false );
		$excelWriter->save( 'php://output' );
		
		die;
	}
	
// ************** /
// DOMPDF funcionality
// ************* /	
	function __getDOMPDFInstance() {
		require_once './modules/dompdf/dompdf_config.inc.php';
		return new DOMPDF();
	}
	
	function __echoDOMPDF( $dompdf, $filename ) {
		$dompdf->render();
		$dompdf->stream( str_replace( ' ', '.', $filename ) . '_' . time() . '_' );
	}
	
// ************** /
// $_GET & $_POST
// ************* /
	function __issetPOST( $fields ) {
		return $_SERVER['REQUEST_METHOD'] == 'POST' && count( $_POST ) > 0 && count( array_diff( $fields, array_keys( $_POST ) ) ) == 0;
	}
	
	// con este function me fijo si en el $_GET, existe $_GET[$name] = $value
	function __issetGETField( $name, $value = false ) {
		return count( $_GET ) > 0 && isset( $_GET[$name] ) && ( ( $value && $_GET[$name] == $value ) || !$value );
	}

	function __GETField( $name ) {
		return count( $_GET ) > 0 && isset( $_GET[$name] ) ? __sanitizeValue( $_GET[$name] ) : false;
	}
	
	/**
	* TODO: may adding some sanitizing process??
	*/
	function __getGETComplete( $skip = '', $append = array() ) {
		$q = array();
		$append = count( $append ) == 2 ? implode( '=', $append ) : '';
		
		if( count( $_GET ) ) {
			foreach( $_GET as $name => $value ) {
				if( $name != $skip ) {
					$q[] = $name . '=' . $value;
				}
			}
			if( $append ) {
				$q[] = $append;
			}
			return count( $q ) ? '?' . implode( '&', $q ) : '';
		}
		
		return $append ? '?' . $append : '';
	}
	
// ************** /
// TODO ESTO HACE USO $_SESSION
// ************* /
	function __initSession() {
		session_start();
	}
	
	function __endSession() {
		session_destroy();
	}
	
	function __isUserLogged() {
		return isset( $_SESSION['is_logged'] ) && $_SESSION['is_logged'];
	}
	
	function __setUserLogin() {
		$_SESSION['is_logged'] = true;
	}
	
	function __setUsername( $username ) {
		$_SESSION['username'] = $username;
	}
	
	function __getUsername() {
		return $_SESSION['username'];
	}
	
// ************** /
// ACA TAN LOS SANITIZERS
// ************* /
	function __toISODate( $value ) {
		$value = explode( '/', trim( $value ) );
		if( count( $value ) != 3 ) {
			return '';
		}
		$year = $value[2];
		if( $year <= 0 || strlen( (int) $year ) != 4 ) {
			return '';
		}
		$month = $value[1];
		if( $month <= 0 || $month > 12 ) {
			return '';
		}
		if( $month < 10 ) {
			$month = '0' . (int) $month;
		}
		$date = $value[0];
		$yearMonth = $year . '-' . $month;
		if( $date <= 0 || $date > date( 't', strtotime( $yearMonth ) ) ) {
			return '';
		}
		if( $date < 10 ) {
			$date = '0' . (int) $date;
		}
		
		return $yearMonth . '-' . $date;
	}
	
	function __dateISOToLocale( $value ) {
		$value = explode( '-', $value );
		if( count( $value ) != 3 ) {
			return '';
		}
		return $value[2] . '/' . $value[1] . '/' . $value[0];
	}
	
	function __toISOTime( $value ) {
		if( !preg_match( '/^(\d{2}):(\d{2})(?: (PM|AM)|(:\d{2})?)$/i', trim( $value ), $m ) ) {
			return '';
		}
		if( count( $m ) < 3 ) {
			return '';
		}
		$hours = $m[1];
		$minutes = $m[2];
		$meridian = isset( $m[3] ) ? $m[3] : false;
		if( $meridian ) {
			if( $hours > 12 || $minutes > 59 ) {
				return '';
			}
			if( $meridian == 'PM' ) {
				$hours += 12;
			}
		}
		
		return $hours . ':' . $minutes . ( isset( $m[4] ) ? $m[4] : ':00' );
	}
	
	function __timeISOToLocale( $value ) {
		$value = explode( ':', $value );
		if( count( $value ) != 3 ) {
			return '';
		}
		$hours = $value[0];
		if( $hours > 12 ) {
			$hours = $hours - 12;
			$meridian = 'PM';
		} else {
			$meridian = 'AM';
		}
		if( $hours < 10 ) {
			$hours = '0' . (int) $hours;
		}
		
		return $hours . ':' . $value[1] . ' ' . $meridian;
	}
	
	function __trimTime( $value ) {
		return substr( $value, 0, 5 );
	}

	function __cleanDNI( $value ) {
		$value = str_replace( '.', '', trim( $value ) );
		return preg_match( '/^\d+$/', $value ) ? $value : '';
	}
	
	function __sanitizeValue( $value ) {
		return htmlspecialchars( $value );
	}
	
	function __validateID( $value ) {
		return $value > 0 ? (int) $value : '';
	}
	
	function __cleanTel( $value ) {
		return ( $m = preg_replace( '/^[^#*\d-()]+$/', '', trim( $value ) ) ) ? $m : '';
	}
	
	function __validateGender( $value ) {
		$value = strtoupper( $value );
		return in_array( $value, array( 'F', 'M' ) ) ? $value : '';
	}
	
	function __validateEmail( $value ) {
		return preg_match( '/^[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]+$/i', trim( $value ) ) ? $value : '';
	}
	
	function __getAppointmentStatus( $value ) {
		if( $value == 'confirmados' ) {
			return 'confirmado';
		} else if( $value == 'cancelados' ) {
			return 'cancelado';
		}
		return '';
	}
	
	function __getDayName( $dayIndex ) {
		$DAYNAME = array( 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo' );
		return isset( $DAYNAME[$dayIndex-1] ) ? $DAYNAME[$dayIndex-1] : false;
	}
	
	function __validateDayIndex( $dayIndex ) {
		return in_array( $dayIndex, array( 1, 2, 3, 4, 5, 6, 7 ) ) ? $dayIndex : false;
	}
	
	function __getPatientOld( $birthDate ) {
		$currentDate = explode( '-', date( 'Y-m-d' ) );
		$birthDate = explode( '-', $birthDate );

		$years = $currentDate[0] - $birthDate[0];
		$months = $currentDate[1] - $birthDate[1];
		$days = $currentDate[2] - $birthDate[2];
		
		if( $days < 0 ) {
			$days += date( 'd', strtotime( $currentDate[0] . '-' . $currentDate[1] . ' next month previous day' ) );
			$months--;
			if( $months < 0 ) {
				$months += 12;
				$years--;
			}
		}
		if( $months < 0 ) {
			$months += 12;
			$years--;
		}
		
		if( !$years && $months ) {
			return $months . ' meses';
		}
		if( !$years && !$months ) {
			return $days . ' días';
		}
		return $years . ' años';
	}
	
// ************** /
// RENDER VIEWS
// ************* /
	function __render( $__filename__, $vars = array() ) {
		
		$__fullPath__ =  './views/' . $__filename__ . '.php';
		if( !file_exists( $__fullPath__ ) ) {
			die( 'Specified view: "' . $__filename__ . '" does not exists at the path: "' . $__fullPath__ . '"' );
		}
		
		extract( $vars );
		require $__fullPath__;
	}
?>
