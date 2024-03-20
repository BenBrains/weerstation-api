<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HealthController extends Controller
{
    /**
     * Health & status.
     *
     * This function measures the time it takes to respond to the API and to connect to the database.
     * It then returns a JSON response with the status and ping time for both the API and the database.
     */
    public function status()
    {
        // Start API timing
        $apiStart = microtime(true);

        $apiStatus = 'OK';

        // End API timing & calculate ping
        $apiEnd = microtime(true);
        $apiPing = round(($apiEnd - $apiStart) * 1000, 2);

        // Start DB timing
        $dbStart = microtime(true);

        // Check DB status
        try {
            DB::connection()->getPdo();
            $dbStatus = 'OK';
        } catch (\Exception $e) {
            $dbStatus = 'NOT_OK';
        }

        // End DB timing & calculate ping
        $dbEnd = microtime(true);
        $dbPing = round(($dbEnd - $dbStart) * 1000, 2);

        return response()->json([
            'api' => [
                'status' => $apiStatus,
                'ping' => $apiPing,
            ],
            'database' => [
                'status' => $dbStatus,
                'ping' => $dbPing
            ],
        ]);
    }
}
