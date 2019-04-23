<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Viaje;
use Carbon\Carbon;
use DB;

class CerrarViajes extends Command
{
    protected $signature = 'cerrarViajes:assign';

    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $viajes = Viaje::with('viajes_usuarios')
                ->where([ ['estado', 1], 
                          ['fechaSalida', '<', Carbon::today()], 
                          ['fechaSalida', '>', Carbon::today()->subDays(2)] 
                        ])->orderBy('IdViaje', 'ASC')->get();

        DB::beginTransaction();

        foreach ($viajes as $key => $value) {
            // dd($value->IdViaje);
            if(count($value->viajes_usuarios) > 0)
            {
                foreach ($value->viajes_usuarios as $key => $val) {
                   $val->estado = 3;
                   $val->save();
                }

                $value->estado = 2;
            }
            else
                $value->estado = 3;
            
            $value->save();
        }

        DB::commit();

        $this->info("Acción replicada correctamente!");
        
    }
}
