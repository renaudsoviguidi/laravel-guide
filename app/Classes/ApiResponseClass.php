<?php

namespace App\Classes;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class ApiResponseClass
{
    /**
     * Create a new class instance.
     */

     public static function rollback($e, $message ="Une erreur s'est produite ! Le processus n'a pas été terminé"){
        DB::rollBack();
        // Ajout des détails de l'exception dans le message de réponse
        $errorMessage = $message . ' | Erreur: ' . $e->getMessage();
        self::throw($e, $errorMessage);
    }
    
    public static function throw($e, $message ="Une erreur s'est produite ! Le processus n'a pas été terminé"){
        // Ajout de l'exception au log pour avoir une trace plus détaillée
        Log::error('Erreur: '.$e->getMessage(), ['trace' => $e->getTraceAsString()]);
        throw new HttpResponseException(response()->json(["message"=> $message], 500));
    }
    

    public static function sendResponse($result , $message ,$code=200){
        $response=[
            'success' => true,
            'data'    => $result
        ];
        if(!empty($message)){
            $response['message'] =$message;
        }
        return response()->json($response, $code);
    }
}
