<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Viaje;
use App\ViajesPunto;
use App\Ruta;
use App\Festivo;
use App\RutasDia;
use Carbon\Carbon;

abstract class DaysOfWeek
{
    const Lunes = 1;
    const Martes = 2;
    const Miercoles = 3;
    const Jueves = 4;
    const Viernes = 5;
    const Sabado = 6;
    const Domingo = 7;
}

class Viajes extends Command
{
    protected $signature = 'viajes:assign';
    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $week = array("1"=>"Lunes", "2"=>"Martes", "3"=>"Miercoles", 
                      "4" => "Jueves", "5" => "Viernes", "6" => "Sabado", "7" => "Domingo" );
        
        if(Festivo::where('fecha', Carbon::today()->toDateString())->get()->count() > 0)
        {
            $this->info("Hoy es un viaje festivo, no se pueden crear rutas...!");
        }
        else
        {
            $rutas = Ruta::where('estado', '1')->get();

            foreach ($rutas as $key => $value) 
            {                
                $reg = RutasDia::where([ ['dia', $week[Carbon::today()->dayOfWeek]], ['estado', 1], ['idRuta', $value->idRuta] ])->get();          
                
                if($reg->count() > 0)
                {
                    // $fecha = Carbon::now()->addDay();
                    // $fecha = Carbon::parse($fecha)->format('Y-m-d');

                    $viajes = Viaje::with('viajes_puntos')->find($value->IdViaje);                    
                    $newViaje = $viajes->replicate();
                    $newViaje->cupos = $newViaje->cupos_total;
                    $newViaje->estado = 1;
                    // $fecha = Carbon::createFromFormat('Y-m-d H:i:s', $fecha);
                    // dd($fecha);
                    // $fechaSalida = Carbon::createFromDate($fecha->year, $fecha->month, $fecha->day);
                    // dd(Carbon::createFromFormat('Y-m-d H:i:s', $fechaSalida, 'America/Bogota')->addDay());

                    $newViaje->fechaSalida = Carbon::createFromFormat('Y-m-d H:i:s', $newViaje->fechaSalida, 'America/Bogota')->addDay();
                    $newViaje->created_at = Carbon::now()->toDateTimeString();
                    $newViaje->updated_at = Carbon::now()->toDateTimeString();
                    $newViaje->save(); 

                    foreach ($viajes->viajes_puntos as $key => $val) {
                        $puntos = new ViajesPunto;
                        $puntos->idViaje = $newViaje->IdViaje;
                        $puntos->tipo_punto = $val->tipo_punto;
                        $puntos->latitude = $val->latitude;
                        $puntos->longitude = $val->longitude;
                        $puntos->address = $val->address;
                        $puntos->orden = $val->orden;
                        $puntos->save();
                    }
                }       
            }
        }
        
        $this->info("Acción replicada correctamente!");
    }
}
