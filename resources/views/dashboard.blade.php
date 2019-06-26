@extends('layouts.dashboard')

@section('title')
    Dashboard
@endsection

@section('content')
	
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-4">
				<div class="card custom-card shadow fadeIn animated">
						<div class="card-body">
						<h5 class="text-center bold-font">Total de constancias emitidas</h5>
						<h2 class="text-center blue-font">350</h2>
						</div>
				</div>
			</div>

			<div class="col-lg-4">
				<div class="card custom-card shadow fadeIn animated">
						<div class="card-body">
						<h5 class="text-center bold-font">Total de recibos pagados</h5>
						<h2 class="text-center blue-font">1020</h2>
						</div>
				</div>
			</div>

			<div class="col-lg-4">
				<div class="card custom-card shadow fadeIn animated">
						<div class="card-body">
						<h5 class="text-center bold-font">Total de personal</h5>
						<h2 class="text-center blue-font">245</h2>
						</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-8">
				<div class="card custom-card shadow fadeIn animated">
					<div class="card-body">
						<h4 class="text-center bold-font">Cantidad pagado por mes</h4>
						<canvas id="myChart"></canvas>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="row full-height">
					<div class="col-lg-12 padding-card mg-top-neg-1-5-rem">
						<div class="card custom-card shadow full-height fadeIn animated">
	  						<div class="card-body custom-card-body">
	    						<div>
	    							<h5 class="text-center bold-font">Total de usuarios bloqueados</h5>
	    							<div class="donut-center-div">
	    								<div id="activeBorder" class="active-border">
									        <div id="circle" class="circle">
									            <span class="prec 340" id="prec">0%</span>
									        </div>
									    </div>
	    							</div>
	    						</div>
	  						</div>
						</div>
					</div>
					<div class="col-lg-12 padding-card">
						<div class="card custom-card shadow full-height fadeIn animated">
	  						<div class="card-body custom-card-body">
	    						<div>
	    							<h5 class="text-center bold-font">Total acumulado en fondo de ahorro</h5>
	    							<div class="donut-center-div">
	    								<div id="activeBorder2" class="active-border2">
									        <div id="circle2" class="circle2">
									            <span class="prec2 280" id="prec2">0%</span>
									        </div>
									    </div>
	    							</div>
	    						</div>
	  						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

@section('css')
	
	<style type="text/css">
		body{
			background-color: #f2f2f2;
		}

		.custom-card{
			margin-top: 1.5rem;
			border-radius: .5rem;
		}

		.custom-card-body{
			display: flex;
    		justify-content: center;
    		align-items: center;
		}

		.blue-font{
			color: #60b3fe;
			font-weight: bold;
		}

		.full-height{
			height: 100%;
		}

		.padding-card{
			padding-top: 1.5rem;
			padding-bottom: 1.5rem;
		}

		.mg-top-neg-1-5-rem{
			margin-top: -1.5rem;
		}

		.bold-font{
			font-weight: bold;
		}

		/* donut chart */

		.prec{
		    top: 30px;
		    position: relative;
		    font-size: 30px;

		}

		.circle{
		    position: relative;
		    top: 5px;
		    left: 5px;
		    text-align: center;
		    width: 100px;
		    height: 100px;
		    border-radius: 100%;
		    background-color: #E6F4F7;
		}

		.active-border{
		    position: relative;
		    text-align: center;
		    width: 110px;
		    height: 110px;
		    border-radius: 100%;

		    background-color:#39B4CC;
		    background-image:
		        linear-gradient(91deg, transparent 50%, #A2ECFB 50%),
		        linear-gradient(90deg, #A2ECFB 50%, transparent 50%);
		    
		}

		.prec2{
		    top: 30px;
		    position: relative;
		    font-size: 30px;

		}

		.circle2{
		    position: relative;
		    top: 5px;
		    left: 5px;
		    text-align: center;
		    width: 100px;
		    height: 100px;
		    border-radius: 100%;
		    background-color: #E6F4F7;
		}

		.active-border2{
		    position: relative;
		    text-align: center;
		    width: 110px;
		    height: 110px;
		    border-radius: 100%;

		    background-color:#39B4CC;
		    background-image:
		        linear-gradient(91deg, transparent 50%, #A2ECFB 50%),
		        linear-gradient(90deg, #A2ECFB 50%, transparent 50%);
		    
		}

		.donut-center-div{
		    display: flex;
		    align-items: center;
		    justify-content: center;
		}

		/* donut chart */

	</style>

@endsection

@section('scripts')
	<script type="text/javascript">
		
		var ctx = document.getElementById('myChart').getContext('2d');
		var myChart = new Chart(ctx, {
		    type: 'line',
		    data: {
		        labels: ["ENE", "FEB", "MAR", "ABR", "MAY", "JUN"],
				datasets: [
				  {
				    label: "Bs.",
				    fill: false,
				    backgroundColor: "rgba(96, 179, 254, 0.2)",
				    borderColor: "rgb(96, 179, 254)",
				    data: [200000, 90000, 210000, 280000, 240000, 29000],
				    lineTension: 0,
				    fill: "origin"
				  },
				]
		    }
		});

		/* Donut */

		var i = 0 , prec;
		var degs = $("#prec").attr("class").split(' ')[1];
		var activeBorder = $("#activeBorder");

		setTimeout(function(){
		    if($("#circle").is(":hover"))
		       loopit("c");
		    else
		       loopit("nc");
		},1);

		function loopit(dir){
		    if (dir == "c")
		        i++
		    else
		        i--;
		    if (i < 0)
		        i = 0;
		    if (i > degs)
		        i = degs;
		    prec = (100*i)/360;   
		    $(".prec").html(Math.round(prec)+"%");
		    
		    if (i<=180){
		        activeBorder.css('background-image','linear-gradient(' + (90+i) + 'deg, transparent 50%, #A2ECFB 50%),linear-gradient(90deg, #A2ECFB 50%, transparent 50%)');
		    }
		    else{
		        activeBorder.css('background-image','linear-gradient(' + (i-90) + 'deg, transparent 50%, #39B4CC 50%),linear-gradient(90deg, #A2ECFB 50%, transparent 50%)');
		    }
		    
		    
		    setTimeout(function(){
		  
		            loopit("c");

		    },1);
		    
		}


		var i2 = 0 , prec2;
		var degs2 = $("#prec2").attr("class").split(' ')[1];
		var activeBorder2 = $("#activeBorder2");

		setTimeout(function(){
		    if($("#circle2").is(":hover"))
		       loopit2("c");
		    else
		       loopit2("nc");
		},1);

		function loopit2(dir2){
		    if (dir2 == "c")
		        i2++
		    else
		        i2--;
		    if (i2 < 0)
		        i2 = 0;
		    if (i2 > degs2)
		        i2 = degs2;
		    prec2 = (100*i2)/360;   
		    $(".prec2").html(Math.round(prec2)+"%");
		    
		    if (i2<=180){
		        activeBorder2.css('background-image','linear-gradient(' + (90+i2) + 'deg, transparent 50%, #A2ECFB 50%),linear-gradient(90deg, #A2ECFB 50%, transparent 50%)');
		    }
		    else{
		        activeBorder2.css('background-image','linear-gradient(' + (i2-90) + 'deg, transparent 50%, #39B4CC 50%),linear-gradient(90deg, #A2ECFB 50%, transparent 50%)');
		    }
		    
		    
		    setTimeout(function(){
		  
		            loopit2("c");

		    },1);
		    
		}




		/* Donut */

	</script>
@endsection