<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class RecibosPagoController extends Controller
{
    
	function create(Request $request){

		$cedula = $request->cedula;
		$year = $request->year;
		$month = $request->month + 1;
		$day = $request->day;
		$connection = DB::connection('sigesp'.$year);
        $codnom = "";
        $codper = "";
        $fechaIngreso = "";
        $sueper = 0;

		if($month < 10){
			$month = "0".$month;
		}


        if($year == '2013')
            $periodo_query = $this->periodoMysql($cedula, $year, $month, $day);
        else
		  $periodo_query = $this->periodo($cedula, $year, $month, $day);

		$codperi = $this->getCodperi($connection, $periodo_query);

        if($year == '2013')
            $datosTrabajadorQuery = $this->datosTrabajadorQueryMysql($cedula, $codperi, $year, $month, $day);
        else
		    $datosTrabajadorQuery = $this->datosTrabajadorQuery($cedula, $codperi, $year, $month, $day);
        
		$datosTrabajador = $this->datosTrabajador($connection, $datosTrabajadorQuery);

        foreach($datosTrabajador as $dato){

            $codnom = $dato->codnom;
            $codper = $dato->codper;
            $fechaIngreso = $dato->fecingper;
            $sueper = $dato->sueper;

        }


        $desgloseQuery = $this->desgloseQuery($codnom, $codperi, $codper);
        $desglose = $this->desglose($connection, $desgloseQuery);



        return response()->json(['datos' => $datosTrabajador, 'desglose' => $desglose]);


	}

	function getCodperi($connection, $periodo_query){

		$cod_periodo = "";
		$codperi = $connection->select(DB::raw($periodo_query));

		foreach($codperi as $cod){
			$cod_periodo = $cod->periodo;
		}

		return $cod_periodo;

	}

	function datosTrabajador($connection, $recibo_query){

		$recibos = $connection->select(DB::raw($recibo_query));
		return $recibos;
	}

    function desglose($connection, $descuentoQuery){

        $descuentos = $connection->select(DB::raw($descuentoQuery));
        return $descuentos;
    }

    function datosTrabajadorQuery($cedula, $codperi, $year, $month, $day){

        $periodo = $year."-".$month."-".$day;

        return "SELECT 
            sno_hpersonalnomina.codnom,
            EXTRACT(MONTH FROM sno_hperiodo.fechasper),
            sno_hpersonalnomina.staper,
            sno_hnomina.ctnom,
            sno_hnomina.desnom,
            sno_hnomina.tippernom,
            sno_hperiodo.codperi,
            sno_personal.cedper,
            sno_personal.codper,
            sno_personal.apeper || ', ' || sno_personal.nomper AS nombres,
            INITCAP(sno_hcargo.descar) AS denasicar,
            INITCAP(srh_departamento.dendep) AS dendep,
            sno_hpersonalnomina.codcueban,
            sno_hperiodo.fecdesper,
            sno_hperiodo.fechasper,
            sno_personal.fecingper,
            sno_personal.fecegrper as fecha_egreso,
            sno_hpersonalnomina.sueper,sno_hpersonalnomina.codnom   
        FROM
            sno_personal
                INNER JOIN
            sno_hpersonalnomina ON sno_personal.codemp = sno_hpersonalnomina.codemp
                AND sno_personal.codper = sno_hpersonalnomina.codper
                AND sno_personal.cedper = '".$cedula."'
                AND sno_hpersonalnomina.staper = '1'
                AND sno_hpersonalnomina.codperi = '".$codperi."'
                INNER JOIN
            sno_hcargo ON sno_hcargo.codemp = sno_personal.codemp
                AND sno_hcargo.codcar = sno_hpersonalnomina.codcar
                AND sno_hcargo.codnom = sno_hpersonalnomina.codnom
                AND sno_hcargo.codperi = '".$codperi."'
                INNER JOIN
            sno_hnomina ON sno_hnomina.codemp = sno_personal.codemp
                AND sno_hpersonalnomina.codnom = sno_hnomina.codnom
                AND sno_hnomina.codbennom != '----------'
                AND sno_hnomina.peractnom = '".$codperi."'
                INNER JOIN
            sno_hperiodo ON sno_hperiodo.codemp = sno_personal.codemp
                AND sno_hperiodo.codnom = sno_hnomina.codnom
                AND sno_hperiodo.codperi = '".$codperi."'
                AND fechasper = '".$periodo."'
            LEFT JOIN
                srh_departamento ON srh_departamento.codemp = sno_hpersonalnomina.codemp
                AND srh_departamento.coddep = sno_hpersonalnomina.coddep
                AND sno_hpersonalnomina.codperi = '".$codperi."'";

    }

    function datosTrabajadorQueryMysql($cedula, $codperi, $year, $month, $day){

        $periodo = $year."-".$month."-".$day;

        return "SELECT 
            sno_hpersonalnomina.codnom,
            month(sno_hperiodo.fechasper),
            sno_hpersonalnomina.staper,
            sno_hnomina.ctnom,
            sno_hnomina.desnom,
            sno_hperiodo.codperi,
            sno_personal.cedper,
            sno_personal.codper,
            concat(sno_personal.apeper,
                    ', ',
                    sno_personal.nomper) as nombres,
            sno_hasignacioncargo.denasicar,
            srh_departamento.dendep,
            sno_hpersonalnomina.codcueban,
            sno_hperiodo.fecdesper,
            sno_hperiodo.fechasper,
            sno_hpersonalnomina.fecingper,
            sno_hpersonalnomina.sueper,sno_hpersonalnomina.codnom   
        FROM
            sno_personal
                INNER JOIN
            sno_hpersonalnomina ON sno_personal.codemp = sno_hpersonalnomina.codemp
                AND sno_personal.codper = sno_hpersonalnomina.codper
                AND sno_personal.cedper = '".$cedula."'
                AND sno_hpersonalnomina.staper = '1'
                AND sno_hpersonalnomina.codperi = '".$codperi."'
                INNER JOIN
            sno_hasignacioncargo ON sno_hasignacioncargo.codemp = sno_personal.codemp
                AND sno_hasignacioncargo.codasicar = sno_hpersonalnomina.codasicar
                AND sno_hasignacioncargo.codnom = sno_hpersonalnomina.codnom
                AND sno_hasignacioncargo.codperi = '".$codperi."'
                INNER JOIN
            sno_hnomina ON sno_hnomina.codemp = sno_personal.codemp
                AND sno_hpersonalnomina.codnom = sno_hnomina.codnom
                AND sno_hnomina.codbennom != '----------'
                AND sno_hnomina.peractnom = '".$codperi."'
                INNER JOIN
            sno_hperiodo ON sno_hperiodo.codemp = sno_personal.codemp
                AND sno_hperiodo.codnom = sno_hnomina.codnom
                AND sno_hperiodo.codperi = '".$codperi."'
                AND fechasper = '".$periodo."'
                INNER JOIN
            srh_departamento ON srh_departamento.codemp = sno_hpersonalnomina.codemp
                AND srh_departamento.coddep = sno_hpersonalnomina.coddep
                AND sno_hpersonalnomina.codperi = '".$codperi."'";

    }

    function periodo($cedula, $year, $month, $day){
        
        $periodo = $year."-".$month."-".$day;

        return "SELECT 
                    codperi AS periodo,
                    CASE
                        WHEN CAST(MOD(CAST(codperi AS INTEGER), 2) AS BOOLEAN) IS TRUE THEN 'PRIMERA QUINCENA'
                        WHEN CAST(MOD(CAST(codperi AS INTEGER), 2) AS BOOLEAN) IS FALSE THEN 'SEGUNDA QUINCENA'
                    END as nombre_quincena
                FROM
                    (SELECT 
                        sno_personal.cedper,
                            sno_hpersonalnomina.codper,
                            sno_hnomina.codnom,
                            sno_hperiodo.codperi,
                            sno_hperiodo.fecdesper,
                            sno_hperiodo.fechasper
                    from
                        sno_hperiodo
                    INNER JOIN sno_personal ON sno_personal.codemp = sno_personal.codemp
                        and sno_personal.cedper = '".$cedula."'
                    INNER JOIN sno_hpersonalnomina ON sno_hperiodo.codemp = sno_hpersonalnomina.codemp
                        and sno_hperiodo.codperi = sno_hpersonalnomina.codperi
                        and sno_hperiodo.codnom = sno_hpersonalnomina.codnom
                        AND sno_hperiodo.codnom BETWEEN '0001' AND '0004' 
                        and sno_personal.codper = sno_hpersonalnomina.codper
                        and sno_hpersonalnomina.staper = '1'
                    INNER JOIN sno_hnomina ON sno_hperiodo.codemp = sno_hnomina.codemp
                        and sno_hnomina.codnom = sno_hperiodo.codnom
                        AND sno_hnomina.codnom BETWEEN '0001' AND '0004' 
                        and sno_hnomina.peractnom = sno_hperiodo.codperi
                        and sno_hnomina.codbennom != '----------'
                    WHERE
                        sno_hperiodo.totper != '0'
                        AND sno_hperiodo.fechasper = '".$periodo."'
                        ) AS tab_periodo ";
    }

    function periodoMysql($cedula, $year, $month, $day){
        
        $periodo = $year."-".$month."-".$day;

        return "SELECT 
                    codperi AS periodo,
                    YEAR(fecdesper) AS anio,
                    MONTH(fecdesper) AS mes,
                    CASE
                        WHEN MOD(codperi, 2) IS TRUE THEN 'PRIMERA QUINCENA'
                        WHEN MOD(codperi, 2) IS FALSE THEN 'SEGUNDA QUINCENA'
                    END as nombre_quincena
                FROM
                    (SELECT 
                        sno_personal.cedper,
                            sno_hpersonalnomina.codper,
                            sno_hnomina.codnom,
                            sno_hperiodo.codperi,
                            sno_hperiodo.fecdesper,
                            sno_hperiodo.fechasper
                    from
                        sno_hperiodo
                    INNER JOIN sno_personal ON sno_personal.codemp = sno_personal.codemp
                        and sno_personal.cedper = '".$cedula."'
                    INNER JOIN sno_hpersonalnomina ON sno_hperiodo.codemp = sno_hpersonalnomina.codemp
                        and sno_hperiodo.codperi = sno_hpersonalnomina.codperi
                        and sno_hperiodo.codnom = sno_hpersonalnomina.codnom
                        and sno_personal.codper = sno_hpersonalnomina.codper
                        and sno_hpersonalnomina.staper = '1'
                    INNER JOIN sno_hnomina ON sno_hperiodo.codemp = sno_hnomina.codemp
                        and sno_hnomina.codnom = sno_hperiodo.codnom
                        and sno_hnomina.peractnom = sno_hperiodo.codperi
                        and sno_hnomina.codbennom != '----------'
                    WHERE
                        sno_hperiodo.totper != '0'
                        AND sno_hperiodo.fechasper = '".$periodo."'
                        ) AS tab_periodo ";
    }

    function desgloseQuery($codnom, $codperi, $codper){

        return "SELECT
                sno_hsalida.valsal,sno_hsalida.tipsal, sno_hconcepto.nomcon, sno_hconcepto.consunicon,sno_hconstantepersonal.moncon,sno_hconstante.unicon
                FROM
                sno_hsalida
                INNER JOIN
                sno_hconcepto ON sno_hconcepto.codemp = sno_hsalida.codemp
                AND sno_hconcepto.codconc = sno_hsalida.codconc
                AND sno_hsalida.codnom = sno_hconcepto.codnom
                AND sno_hsalida.valsal != '0'
                AND sno_hsalida.codperi = sno_hconcepto.codperi
                AND sno_hsalida.codnom = sno_hconcepto.codnom
                AND sno_hconcepto.codnom = '".$codnom."'
                AND sno_hsalida.codperi = '".$codperi."'
                AND sno_hsalida.codper = '".$codper."'
                AND sno_hsalida.tipsal != 'P2'
                    left JOIN
                        sno_hconstantepersonal ON
                        sno_hconstantepersonal.codemp = sno_hconcepto.codemp
                        AND sno_hconstantepersonal.codcons = sno_hconcepto.consunicon
                        AND sno_hconcepto.codnom = sno_hconstantepersonal.codnom
                        AND sno_hconcepto.codperi = sno_hconstantepersonal.codperi
                        AND sno_hconcepto.codnom = sno_hconstantepersonal.codnom
                        AND sno_hconstantepersonal.codnom = '".$codnom."'
                        AND sno_hconcepto.codperi = '".$codperi."'
                        AND sno_hconstantepersonal.codper = '".$codper."'
                            left JOIN 
                                sno_hconstante ON
                                sno_hconstantepersonal.codemp = sno_hconstante.codemp
                                        AND sno_hconstantepersonal.codcons = sno_hconstante.codcons
                                        AND sno_hconcepto.codnom = sno_hconstante.codnom
                                        AND sno_hconcepto.codperi = sno_hconstante.codperi
                                        AND sno_hconstantepersonal.codnom = '".$codnom."'
                                        AND sno_hconstante.codperi = '".$codperi."'
                                        AND sno_hconstantepersonal.codper = '".$codper."' order by sno_hconcepto.codconc asc;";

    }


}
