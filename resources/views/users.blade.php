@extends('layouts.dashboard')

@section('title')
	Usuarios
@endsection

@section('css')
	<style type="text/css">
		.custom-card{
			margin-top: 1.5rem;
			border-radius: .5rem;
			border: none;
		}

		.no-border{
			border-radius: 0px !important;
		}

		.no-border-input{
			border-top: none;
			border-left: none;
			border-right: none;
		}

		.no-border-input:focus{
		    color: transparent;
		    background-color: transparent;
		    border-color: none;
		    outline: 0;
		    box-shadow: none;
		}

		.custom-select{
			width: unset !important;
			display: unset !important;
		}

		.custom-input{
			border-radius: .5rem;
		}

		.table td, .table th{
			text-align: center;
		}

	</style>

	<link rel="stylesheet" type="text/css" href="{{ asset('css/datatables.css') }}">

@endsection

@section('content')
	
	<div class="container">
		<div class="row">
			
			<div class="col-lg-12">
				<div class="card custom-card shadow fadeIn animated">
					<div class="card-body">
						<table class="table" id="users-table">
						<thead>
						<tr>
							<th scope="col">Nombres</th>
							<th scope="col">Apellidos</th>
							<th scope="col">Cedula</th>
							<th scope="col">Rol</th>
							<th scope="col">Bloqueado</th>
							<!--<th scope="col">Acciones</th>-->
						</tr>
						</thead>
						<tbody>

						</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- modal -->
	<div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content no-border">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Editar</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	  					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form>
				  		<div class="form-group">
				  			<label for="exampleInputEmail1">Nombres</label>
					    	<input type="text" class="form-control no-border-input no-border" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nombres">
					  	</div>
					  	<div class="form-group">
					  		<label for="exampleInputEmail1">Apellidos</label>
					    	<input type="text" class="form-control no-border-input no-border" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Apellidos">
					  	</div>
					  	<div class="form-group">
					  		<label for="exampleInputEmail1">Cédula</label>
					    	<input type="text" class="form-control no-border-input no-border" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Cedula">
					  	</div>
					  	<div class="form-group">
					  		<label for="exampleInputEmail1">Tipo de usuario</label>
					    	<select class="form-control no-border-input no-border">
					    		<option>Administrador</option>
					    		<option>Usuario</option>
					    	</select>
					  	</div>
					  	<div class="form-group">
					  		<label for="exampleInputEmail1">Bloqueado</label>
					    	<select class="form-control no-border-input no-border">
					    		<option>Sí</option>
					    		<option>No</option>
					    	</select>
					  	</div>
					  	
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary">Save changes</button>
				</div>
			</div>
		</div>
	</div>
	<!-- modal -->

@endsection

@section('scripts')
	<script type="text/javascript" src="{{ asset('js/datatables.js') }}"></script>
	<script type="text/javascript">

		$('#users-table').DataTable({
	        processing: true,
	        serverSide: true,
	        ajax: '{!! url("/admin/usuarios/all") !!}',
	        columns: [
	            { data: 'nombre_usuario', name: 'nombre_usuario' },
	            { data: 'apellido_usuario', name: 'apellido_usuario' },
	            { data: 'cedula_usuario', name: 'cedula_usuario' },
	            { data: 'tipo_usuario', name: 'tipo_usuario' },
	            { data: 'baneado', name: 'baneado' }
	        ],
	        language: {
	            "sProcessing": "Procesando...",
	            "sLengthMenu": "Mostrar _MENU_ registros",
	            "sZeroRecords": "No se encontraron resultados",
	            "sEmptyTable": "Ningún dato disponible en esta tabla",
	            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
	            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
	            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
	            "sInfoPostFix": "",
	            "sSearch": "Buscar:",
	            "sUrl": "",
	            "sInfoThousands": ",",
	            "sLoadingRecords": "Cargando...",
	            "oPaginate": {
	                "sFirst": "Primero",
	                "sLast": "Último",
	                "sNext": "Siguiente",
	                "sPrevious": "Anterior"
	            },
	            "oAria": {
	                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
	                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
	            }
	        }
	    });

		$("#users-table_length select").addClass('form-control custom-select')
		$("#users-table_filter input").addClass('custom-input')

	</script>
@endsection