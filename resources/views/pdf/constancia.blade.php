@php
	$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
@endphp

<style>
	table, th, td {
	  border: 1px solid black;
	  border-collapse: collapse;
	}
	th, td {
	  padding: 5px;
	}
</style>

<img src="http://rec.vtelca.gob.ve/img/cintillo-i.png" style="width: 400px; float: left; position: absolute;">
<img src="http://rec.vtelca.gob.ve/img/cintillo-c.png" style="width: 150px; float: right; position: absolute;">

<hr style="border: 2px solid red; margin-top: 60px;">

<h3 style="text-align: center;">CONSTANCIA DE TRABAJO</h3>


	
	<p style="margin-left: 15px;"><strong>Dirigido a:</strong> Sres. {{ $dirigido }}</p>

	<p>          Quien suscribe, Gerente de Organización del Trabajo, de Venezolana de Telecomunicaciones C.A., por medio de
la presente hace constar la exactitud de la información especificada a continuación:
	</p>

	<table style="width:100%">
	  <tr>
	    <th colspan="4" style="background-color: #eee; text-align: center;">DATOS DEL TRABAJO</th>
	  </tr>
	  <tr>
	    <th colspan="2" style="text-align: center; font-weight: bold;">APELLIDOS Y NOMBRES</th>
	    <th colspan="2" style="text-align: center; font-weight: bold;">CEDULA DE IDENTIDAD</th>
	  </tr>
	  <tr>
	    <td colspan="2" style="text-align: center">{{ $data->nombres }}</td>
	    <td colspan="2" style="text-align: center">{{ $data->cedula }}</td>
	  </tr>
	  <tr>
	    <th colspan="2" style="text-align: center; font-weight: bold;">DEPARTAMENTO</th>
	    <th colspan="2" style="text-align: center; font-weight: bold;">UNIDAD DE ADSCRIPCIÓn</th>
	  </tr>
	  <tr>
	    <td colspan="2" style="text-align: center">{{ $data->dendep }}</td>
	    <td colspan="2" style="text-align: center">{{ $data->denger }}</td>
	  </tr>
	  <tr>
	    <td style="text-align: center; font-weight: bold;">
	    	CARGO
	    </td>
	    <td style="text-align: center; font-weight: bold;">
	    	ESTATUS
	    </td>
	    <td style="text-align: center; font-weight: bold;">
	    	FECHA DE INGRESO
	    </td>
	    <td style="text-align: center; font-weight: bold;">
	    	FECHA DE EGRESO
	    </td>
	  </tr>
	  <tr>
	    <td style="text-align: center">{{ $data->denasicar }}</td>
	    <td style="text-align: center">{{ $data->desded }}</td>
	    <td style="text-align: center">{{ \Carbon\Carbon::parse($data->fecingper)->format('d/m/Y') }}</td>
	    <td style="text-align: center">@if($data->fecegrper == '1900-01-01') ACTIVO @endif</td>
	  </tr>
	  <tr>
	  	<td colspan="4" style="text-align: center; background-color: #eee;">Ingresos Mensuales</td>
	  </tr>
	  <tr>
	    <th colspan="2" style="text-align: center; font-weight: bold;">CONCEPTO</th>
	    <th colspan="2" style="text-align: center; font-weight: bold;">MONTO MENSUAL Bs.</th>
	  </tr>
	  <tr>
	    <th colspan="2" style="font-weight: bold;">Sueldo Básico</th>
	    <th colspan="2" style="font-weight: bold;">{{ number_format($data->sueper, 2, ',', '.') }}</th>
	  </tr>
	  <tr>
	    <th colspan="2" style="font-weight: bold;">Prima por profesionalización</th>
	    <th colspan="2" style="font-weight: bold;">{{ number_format($pagos['profesion'], 2, ',', '.') }}</th>
	  </tr>
	  <tr>
	    <th colspan="2" style="font-weight: bold;">Prima de antiguedad</th>
	    <th colspan="2" style="font-weight: bold;">{{ number_format($pagos['antiguedad'], 2, ',', '.') }}</th>
	  </tr>
	  <tr>
	  	<td colspan="4" style="text-align: center; background-color: #eee;">TOTAL SUELDO</td>
	  </tr>
	  <tr>
	  	<td colspan="3" style="font-weight: bold;">{{ $letras }}</td>
	  	<td>{{ number_format($data->sueper + $pagos['profesion'] + $pagos['antiguedad'], 2, ',', '.') }}</td>
	  </tr>
</table>

<p>Constancia que se expide a solicitud de la parte interesada en Punto Fijo a los {{ date("d") }} días del mes de {{ $meses[(int)date('m')-1] }} del año {{ date("Y") }}.</p>

<div align="center" style="margin-left: 40px; margin-top: 15px;  width:700px;">Atentamente;</div>

<div align="center" style="margin-left: 40px; margin-top: 60px; margin-bottom: 10px; width:700px;"><b>Abiezer García<br>Gerente (E) de Organización del Trabajo</b></div>
 <div align="center" style="margin-left: 40px; margin-top: 15px; margin-bottom: 5px; width:700px;"><b>Esta Constancia tiene una vigencia de noventa (90) días a partir de la presente fecha de su emisión.</b></div>
 <div align="center" style="margin-left: 10px; margin-top: 15px; margin-bottom: 5px; width:755px;text-align: justify;"><b>Nota:</b> La presente constancia de trabajo, puede ser certificada a través de la página:<br> http://validar.documentos.vtelca.gob.ve/</div>

<div align="right" style="position: absolute; right: 80px; bottom: 40px;">
<div style="position: absolute; right: 10px; bottom: 40px;"> 
			<img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(100)->generate('Make me into an QrCode!')) }} ">
			<qrcode
            value='{{ $data->cedula .",". $data->nombres . ", " . (($data->sueper + $pagos['profesion'] + $pagos['antiguedad'])/ 100) . ", " . date("d").date("m").date("Y") }}'
            ec="L" style="width: 15mm;"></qrcode>
    </div>
         <div style="position: absolute; bottom: 0px; font-size: 11px; width: 770px;" align="center">
            <hr style=" border:2px; border-color: red;" >
            Av. Bolívar, calle de servicio 4, Meseta de Guaranao, galpones 5-5, 5-6, zona Franca Industrial de Paraguaná, estado Falcón<br><b>Teléfono: </b> 0269-2463909
         </div>

       
