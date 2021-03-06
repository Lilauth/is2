<?php

	// both edit and create patients funtionality share some common things
	global $PWD;
	require_once $PWD . '/models/_patients.new.edit.php';

	// get the id seg from /pacientes/122/editar
	$patientID = Router::seg( 2 );

/* {{{ */
	if( m_issetPOST() ){
		$fields = array();
		$errors = array();
		if( !m_processPOST( $fields, $errors ) ) {
			__redirect( '/pacientes/' . $patientID . '/editar?error=editar-paciente&campos=' . base64_encode( implode( '|', $errors ) ) );
		}
		
		$fields[] = $patientID;
		$rowsAffected = DB::update( 
			'
				UPDATE
					pacientes
				SET
					apellidos = ?,
					nombres = ?,
					sexo = ?,
					dni = ?,
					fechaNacimiento = ?,
					telefono = ?,
					direccion = ?,
					idObraSocial = ?,
					nroAfiliado = ?
				WHERE
					id = ?
			',
			$fields
		);
		// puede pasar que submitee el form tal cual esta, no pasa nada, y por el < 0
		if( $rowsAffected < 0 ) {
			__redirect( '/pacientes/' . $patientID . '/editar?error=editar-paciente&campos=' . base64_encode( implode( '|', DB::getErrorList() ) ) );
		}
		
		__redirect( '/pacientes/' . $patientID . '/editar?exito=editar-paciente' );
	}
/* }}} */

/* {{{ DEBO PEDIR EL PACIENTE QUE ESTA EN LA URL */
	$patients = DB::select(
		'
			SELECT
				p.id, p.apellidos, p.nombres, p.sexo, p.dni, p.idObraSocial, p.fechaNacimiento, p.telefono, p.direccion, p.nroAfiliado,
				os.nombreCorto AS obraSocialNombre
			FROM
				pacientes AS p
				INNER JOIN obrasSociales AS os
					ON os.id = p.idObraSocial
			WHERE 
				p.id = ?
		',
		array( $patientID )
	);
	if( !$patients->rowCount() ) {
		__redirect( '/pacientes?error=editar-paciente' );
	}
	$patient = $patients->fetch();
/* }}} */

/* {{{ */
	$insurances = q_getAllInsurances();

	$username = __getUsername();
	
	$page = 'Editar';
	$buttonLabel = 'Editar paciente';
	
	if( __GETField( 'error' ) ) {
		$editError = true;
	} else {
		$editError = false;
	}
	
	$editSuccess = false;
	$editError = false;
	if( __issetGETField( 'exito', 'editar-paciente' ) ) {
		$editSuccess = true;
	} else if( __issetGETField( 'error', 'editar-paciente' ) ) {
		$editError = true;
	}

	__render( 
		'patients.new.edit', 
		array(
			'username' => $username,
			'editSuccess' => $editSuccess,
			'editError' => $editError,
			'insurances' => $insurances,
			'patient' => $patient,
			'page' => $page,
			'buttonLabel' => $buttonLabel,
// estas son las varaibles que son edit, y que debo
// conocer para no que '_patients.new.edit' no se rompa
			'createError' => false
		)
	);
/* }}} */
	
?>