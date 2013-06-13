<?php t_startHead( 'Especialidades' ); ?>
	<style>
		label {
			cursor: default;
		}
		.is2-grid-header th:last-child {
			width: 150px;
		}
		.is2-grid td:last-child {
			width: 110px;
			vertical-align: middle;
			white-space: nowrap;
		}
	</style>
<?php t_endHead(); ?>
<?php t_startBody( $username, 'specialities'  ); ?>
	
		<?php t_startWrapper(); ?>
		
			<?php if( $createSuccess ): ?>
			<div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				¡La nueva especialidad ha sido creada satisfactoriamente!
			</div>
			<?php elseif( $createError ): ?>
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				<strong>¡No se ha podido crear la nueva especialidad!</strong> Capaz ya exista una con el mismo nombre en el sistema.
			</div>
			<?php elseif( $editSuccess ): ?>
			<div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				¡La especialidad ha sido editada satisfactoriamente!
			</div>
			<?php elseif( $editError ): ?>
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				<strong>¡No se ha podido editar la especialidad!</strong> Capaz ya exista una con el mismo nombre en el sistema.
			</div>
			<?php elseif( $removeSuccess ): ?>
			<div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				¡La especialidad ha sido borrada satisfactoriamente!
			</div>
			<?php elseif( $removeError ): ?>
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				<strong>¡No se ha podido borrar la especialidad!</strong> Intentelo nuevamente.
			</div>
			<?php endif; ?>
		
			<div class="is2-pagetitle clearfix">
				<h3>Especialidades</h3>
				<a class="is2-trigger-new btn pull-right btn-warning" href="#is2-modal-theform" data-toggle="modal"><i class="icon-plus"></i> Crear una nueva especialidad</a>
			</div>

			<div class="alert">
				A continuación se muestran todas las especialidades cargadas en el sistema
			</div>
			
			<div class="is2-grid-header-wrapper">
				<table class="table is2-grid-header btn-inverse">
					<tr>
						<th>Nombre</th>
						<th>Acciones</th>
					</tr>
				</table>
			</div>
			<div class="is2-grid-wrapper">
				<table class="table is2-grid">
				<?php foreach( $specialities as $speciality ): ?>
					<tr data-speciality-id="<?php echo $speciality['id']; ?>">
						<td class="is2-speciality-name"><?php echo $speciality['nombre']; ?></td>
						<td>
						<?php if( $speciality['id'] != 1 ): ?>
							<a class="btn btn-small is2-trigger-edit" href="#is2-modal-edit" data-toggle="modal" data-speciality-id="<?php echo $speciality['id']; ?>">Editar</a>
							<a class="btn btn-small btn-danger is2-trigger-remove" href="#is2-modal-remove" data-toggle="modal" data-speciality-id="<?php echo $speciality['id']; ?>">Borrar</a>
						</td>
						<?php endif; ?>
					</tr>
				<?php endforeach; ?>
				</table>
			</div>
		
			<!-- los modals -->
			<form method="post" action="/especialidades/editar" id="is2-modal-edit" class="modal hide fade">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<strong>Editar especialidad</strong>
				</div>
				<div class="modal-body">
					<fieldset class="form-inline">
						<label>Nombre de la especialidad:
							<input type="text" class="input-xlarge" name="speciality">
						</label>
					</fieldset>
				</div>
				<div class="modal-footer">
					<button class="btn" data-dismiss="modal">Cancelar</button>
					<button class="btn btn-primary" type="submit">Editar</button>
				</div>
				<input type="hidden" name="id">
			</form>
			
			<form method="post" action="/especialidades/borrar" id="is2-modal-remove" class="modal hide fade">
				<div class="modal-body">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<span><strong>¿Estás seguro que desea borrar esta especialidad del sistema?</strong></span>
				</div>
				<div class="modal-footer">
					<button class="btn" data-dismiss="modal">Cancelar</button>
					<button class="btn btn-primary" type="submit">Borrar</button>
				</div>
				<input type="hidden" name="id">
			</form>
		
		<?php t_endWrapper(); ?>
		
<?php t_endBody(); ?>

<script>
(function() {
	$( '.is2-grid' ).delegate( '.is2-trigger-edit', 'click', function( e ) {
		var specialtyID = $( this ).attr( 'data-speciality-id' );
		$( '#is2-modal-edit input[name=id]' ).val( specialtyID );
		$( '#is2-modal-edit input[name=speciality]' ).val( $( 'tr[data-speciality-id=' + specialtyID + '] .is2-speciality-name'  ).html() );
	} );
	$( '.is2-grid' ).delegate( '.is2-trigger-remove', 'click', function( e ) {
		$( '#is2-modal-remove input[name=id]' ).val( $( this ).attr( 'data-speciality-id' ) );
	} );
})();
</script>