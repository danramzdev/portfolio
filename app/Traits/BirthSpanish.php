<?php


namespace App\Traits;

trait BirthSpanish
{
	private function birthSpanish($birth)
	{
		$time  = strtotime($birth);
		$year = date('Y', $time);
		$month = date('m', $time) - 1;
		$day = date('d', $time);

		$monthSpanish = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

		return "$day de $monthSpanish[$month] de $year";
	}
}
