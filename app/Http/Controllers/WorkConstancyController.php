<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;
use DB;

class WorkConstancyController extends Controller
{

	function create(Request $request){
		
		$currentYear = date("Y");
		$cedula = \Auth::user()->cedula_usuario;
		$addressedTo = $request->addressedTo;
		$months = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
		$sql = "select sno_personalnomina.staper,
						sno_personalnomina.codnom,
						sno_personal.estper,
						sno_personal.codper,
                        sno_personal.cedper,
                        sno_personal.nacper || '-'  ||   sno_personal.cedper as cedula,
						sno_personal.apeper || ', ' ||  sno_personal.nomper  as nombres,
						sno_personal.nacper,

						sno_personalnomina.coddep,
						sno_personalnomina.salnorper,
						srh_departamento.dendep,
						sno_cargo.descar as denasicar,
						sno_unidadadmin.desuniadm as denger,
						sno_personal.fecingper,
						sno_personal.fecegrper,
						sno_personalnomina.sueper,
						(sno_personalnomina.sueintper*2)as sueintper,
						sno_dedicacion.desded,
                        sno_personalnomina.codcueban
							from sno_personal
						INNER JOIN sno_personalnomina ON sno_personal.codemp = sno_personalnomina.codemp
							and sno_personal.codper = sno_personalnomina.codper
							and sno_personalnomina.codnom IN ('0001','0002','0003','0004')

						INNER JOIN srh_gerencia ON sno_personal.codemp = srh_gerencia.codemp
							and sno_personal.codger = srh_gerencia.codger

						LEFT JOIN srh_departamento ON sno_personalnomina.codemp = srh_departamento.codemp
							and sno_personalnomina.coddep = srh_departamento.coddep
							and sno_personalnomina.codnom IN ('0001','0002','0003','0004')

						INNER JOIN sno_cargo ON sno_personalnomina.codemp = sno_cargo.codemp
							and sno_personalnomina.codcar = sno_cargo.codcar
							and sno_personalnomina.codnom = sno_cargo.codnom
							and sno_personalnomina.codnom IN ('0001','0002','0003','0004')

						INNER JOIN sno_unidadadmin ON sno_unidadadmin.codemp=sno_personalnomina.codemp
							and sno_unidadadmin.minorguniadm=sno_personalnomina.minorguniadm
							and sno_unidadadmin.ofiuniadm=sno_personalnomina.ofiuniadm
							and sno_unidadadmin.uniuniadm=sno_personalnomina.uniuniadm
							and sno_unidadadmin.depuniadm=sno_personalnomina.depuniadm
							and sno_unidadadmin.prouniadm=sno_personalnomina.prouniadm
							and sno_personalnomina.codnom IN ('0001','0002','0003','0004')

						INNER JOIN sno_asignacioncargo ON sno_personalnomina.codemp = sno_asignacioncargo.codemp
							and sno_personalnomina.codasicar = sno_asignacioncargo.codasicar
							and sno_personalnomina.codnom = sno_asignacioncargo.codnom
							and sno_personalnomina.codnom IN ('0001','0002','0003','0004')

						INNER JOIN sno_dedicacion ON sno_dedicacion.codemp = sno_personalnomina.codemp
							and sno_dedicacion.codded = sno_personalnomina.codded
                     and sno_personalnomina.codnom IN ('0001','0002','0003','0004')  where sno_personal.cedper IN ('" . $cedula . "') and sno_personalnomina.staper='1'";


        $query = DB::connection('sigesp'.$currentYear)->select(DB::raw($sql));
        $user = [];

        foreach($query as $query){
        	$user = $query;
        }

		return response()->json($user);

	}

}
