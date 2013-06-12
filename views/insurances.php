<?php t_startHead( 'Obras sociales' ); ?>
	<style>
		label {
			cursor: default;
		}
		.is2-grid-header th:last-child {
			width: 245px;
		}
		.is2-grid td:first-child span {
			display: block;
		}
		.is2-grid td span.is2-insurance-abbrname {
			text-transform: uppercase;
		}
		.is2-grid td span.is2-insurance-fullname {
			color: #777;
			font-size: 12px;
		}
		.is2-grid td:not( :first-child ) {
			text-transform: none;
		}
		.is2-grid td:last-child {
			width: 215px;
			vertical-align: middle;
		}
		.is2-insurances-crud {
			display: inline-block;
			margin: 0 0 0 15px;
		}
	</style>
<?php t_endHead(); ?>
<?php t_startBody( $username, 'insurances'  ); ?>

		<?php t_startWrapper(); ?>
		
			<div class="is2-pagetitle clearfix">
				<h3>Obra sociales</h3>
				<a class="is2-trigger-new btn pull-right btn-warning" href="#is2-modal-theform" data-toggle="modal"><i class="icon-plus"></i> Crear una nueva obra social</a>
			</div>

			<div class="alert">
				A continuación se muestran todas las obra sociales cargadas en el sistema
			</div>

			<div class="is2-insurances-crudmessages">
				<?php if( $createSuccess ): ?>
				<div class="alert alert-success">
					<a class="close" data-dismiss="alert" href="#">&times;</a>
					¡La nueva obra social ha sido creada satisfactoriamente!
				</div>
				<?php elseif( $editSuccess ): ?>
				<div class="alert alert-success">
					<a class="close" data-dismiss="alert" href="#">&times;</a>
					¡La obra social ha sido editada satisfactoriamente!
				</div>
				<?php elseif( $editError ): ?>
				<div class="alert alert-error">
					<a class="close" data-dismiss="alert" href="#">&times;</a>
					<strong>¡No se ha podido editar la obra social!</strong> Capaz ya exista una con el mismo nombre abreviado en el sistema.
				</div>
				<?php elseif( $removeSuccess ): ?>
				<div class="alert alert-success">
					<a class="close" data-dismiss="alert" href="#">&times;</a>
					¡La obra social ha sido borrada satisfactoriamente!
				</div>
				<?php elseif( $removeError ): ?>
				<div class="alert alert-error">
					<a class="close" data-dismiss="alert" href="#">&times;</a>
					<strong>¡No se ha podido borrar la obra social!</strong> Intentelo nuevamente.
				</div>
				<?php endif; ?>
			</div>
			
			<table class="table is2-grid-header btn-inverse">
				<tr>
					<th>Nombre</th>
					<th>Acciones</th>
				</tr>
			</table>
			<div class="is2-grid-wrapper">
				<table class="table is2-grid">
				<?php foreach( $insurances as $insurance ): ?>
					<tr class="is2-grid-row" data-insurance-id="<?php echo $insurance['id']; ?>">
						<td>
							<span class="is2-insurance-abbrname"><?php echo $insurance['nombreCorto']; ?></span>
							<span class="is2-insurance-fullname"><?php echo $insurance['nombreCompleto']; ?></span>
						</td>
						<td>
						<?php if( $insurance['id'] != 1 ): ?>
							<a class="btn btn-small btn-warning">Deshabilitar</a>
							<div class="is2-insurances-crud">
								<a class="btn btn-small is2-trigger-edit" href="#is2-modal-edit" data-toggle="modal" data-insurance-id="<?php echo $insurance['id']; ?>">Editar</a>
								<a class="btn btn-small btn-danger is2-trigger-remove" href="#is2-modal-remove" data-toggle="modal" data-insurance-id="<?php echo $insurance['id']; ?>">Borrar</a>
							</div>
						<?php else: ?>
							&nbsp;
						<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
				</table>
			</div>
			
		<?php t_endWrapper(); ?>

		<!-- los modals -->
		<form id="is2-modal-theform" class="modal hide fade form-horizontal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<strong class="is2-insurance-edit">Editar obra social</strong>
				<strong class="is2-insurance-new">Crear obra social</strong>
			</div>
			<div class="modal-body">
				<div class="alert is2-insurance-new">
					Sepa que no pueden existir dos obras sociales con el mismo nombre abreviado
				</div>
				<div class="alert alert-error is2-ajax-msg is2-ajax-msg-full is2-insurance-new-error" style="display:none">
					<strong>¡No se ha podido crear la nueva obra social!</strong>
					<div>Verifique no exista una con el mismo nombre abreviado ya cargada en el sistema</div>
				</div>
				<div class="control-group is2-insurances-abbr">
					<label class="control-label">Nombre abreviado:</label>
					<div class="controls">
						<input type="text" class="is2-insurances-abbr input-xlarge" name="abbr">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Nombre completo:</label>
					<div class="controls">
						<textarea class="is2-insurances-full input-xlarge" name="full"></textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal">Cancelar</button>
				<button class="btn btn-primary is2-insurance-edit" type="submit">Editar</button>
				<button class="btn btn-primary is2-insurance-new" type="submit">Crear obra social</button>
				<span class="is2-preloader is2-preloader-bg pull-left is2-preloader-newedit"></span>
			</div>
			<input type="hidden" name="id">
		</form>
		
		<form method="post" action="/obras-sociales/borrar" id="is2-modal-remove" class="modal hide fade">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<span><strong>¿Estás seguro que desea borrar esta obra social del sistema?</strong></span>
				<p>Sepa que aquellos pacientes que tenga esta obra social asociada serán asociados a la obra social LIBRE automaticamente.</p>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal">Cancelar</button>
				<button class="btn btn-primary" type="submit">Borrar</button>
			</div>
			<input type="hidden" name="id">
		</form>
		
		
<?php t_endBody(); ?>

<script>
(function() {
	var $theGrid = $( '.is2-grid-wrapper' );
	$theGrid.delegate( '.is2-trigger-edit', 'click', function( e ) {
		var insuranceID = $( this ).attr( 'data-insurance-id' );
		$( '#is2-modal-edit input[name=id]' ).val( insuranceID );
		$( '#is2-modal-edit input[name=shortName]' ).val( $( 'tr[data-insurance-id=' + insuranceID + '] .is2-insurance-shortName'  ).html() );
		$( '#is2-modal-edit input[name=fullName]' ).val( $( 'tr[data-insurance-id=' + insuranceID + '] .is2-insurance-fullName'  ).html() );
		
	} ).delegate( '.is2-trigger-remove', 'click', function( e ) {
		$( '#is2-modal-remove input[name=id]' ).val( $( this ).attr( 'data-insurance-id' ) );
	} );
	
// *** crear obra social *** //
	var $abbrName = $( 'input.is2-insurances-abbr' );
	var $abbrNameControlGroup = $( '.control-group.is2-insurances-abbr' );
	var $fullName = $( '.is2-insurances-full' );
	var $preloader = $( '.is2-preloader-newedit' );
	var $insuranceCreateError = $( '.is2-insurance-new-error' );
	var isWaiting = false;
	
	$( '.is2-trigger-new' ).on( 'click', function( e ) {
		$( '.is2-insurance-edit' ).hide();
		$( '.is2-insurance-new' ).show();
	} );
	
	var createdInsurance = function( dataResponse ) {
		isWaiting = false;
		$preloader.css( 'visibility', 'hidden' );
		
		if( !dataResponse.success ) {
			IS2.showCrudMsg( $insuranceCreateError, 0, 6000 );
			$abbrNameControlGroup.addClass( 'error' );
			return;
		}
		
		window.location = '/obras-sociales?exito=crear-obra-social&id=' + dataResponse.data.id;
	};

	$( '#is2-modal-theform' ).on( 'submit', function( e ) {
		e.preventDefault();
		if( IS2.lookForEmptyFields( $abbrName, true, true ) ) {
			return;
		}
		$abbrNameControlGroup.removeClass( 'error' );

		isWaiting = true;
		$preloader.css( 'visibility', 'visible' );
		
		$.ajax( {
			url: '/obras-sociales/crear',
			dataType: 'json',
			type: 'POST',
			data: {
				abbr: $abbrName.val(),
				full: $fullName.val()
			},
			success: createdInsurance,
			error: createdInsurance
		} );
	} );
	
	var newInsuranceID;
	var $newInsurance;
	if( window.location.search.indexOf( 'exito=crear-obra-social' ) >= 0 && ( newInsuranceID = window.location.search.match( /id=(\d+)/ ) ) ) {
		$( '.is2-insurances-crudmessages' )[0].scrollIntoView();
		$newInsurance = $( '.is2-grid-row[data-insurance-id=' + newInsuranceID[1] + ']' );
		$theGrid.scrollTo( $newInsurance, 1000, { onAfter: function() {
			$newInsurance.addClass( 'is2-record-new' )[0].scrollIntoView();
			window.setTimeout( function() {
				$newInsurance.removeClass( 'is2-record-new' );
			}, 3000 );
		} } );
	}
	
})();
</script>