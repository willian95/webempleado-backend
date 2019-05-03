<style type="text/css">
	
	#sidebar{
		position: absolute;
		width: 400px;
		top: 61px;
		height: 100%;
		padding: 1.5rem;
		z-index: 9;
	    margin-top: -61px;
    	padding-top: 61px;
	}

	.rounded-border{
        border-radius: .5rem;
    }

	#sidebar .container{
		background-color: #fff;
		height: 100%;
    	margin-top: 1.5rem;
	}

	#sidebar .user-icon{
		font-size: 60px;
	}

	#sidebar .col-12{
		padding-top: 2rem;
	}

	#sidebar .list-group-item a{
		color: #212529;
		text-decoration: none;
	}

	#sidebar .list-group-item a:hover{
		font-weight: bold;
	}

	#sidebar .list-group-item .active{
		font-weight: bold;
	}	

	#sidebar .list-group-item{
		color: #212529;
	}

	#sidebar .list-group-item:first-child{
		border-top: none;
	}

	#sidebar .list-group-item:hover{
		z-index: unset;
	}

	#sidebar .list-group-item{
		border-bottom: none;
		border-right: none;
		border-left: none;
		padding-top: 1rem;
		padding-bottom: 1rem;
	}

	.mg-t-4-rem{
		margin-top: 4rem;
	}

</style>

<div id="sidebar">
	<div class="container rounded-border shadow fadeInLeft animated">
		<div class="row">
			<div class="col-12">
				<p class="text-center">
					<i class="fas fa-user user-icon"></i>
					<h3 class="text-center">{{ Auth::user()->nombre_usuario }}</h3>
				</p>
				<div class="mg-t-4-rem">
					<ul class="list-group text-center">
						<li class="list-group-item"><a href="{{ url('/admin/dashboard') }}" class="active">Inicio</a></li>
						<li class="list-group-item"><a href="{{ url('/admin/usuarios') }}">Usuarios</a></li>
						<li class="list-group-item"><a href="#">Cerrar sesión</a></li>			
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>