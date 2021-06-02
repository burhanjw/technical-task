<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Test;
use DB;

class TestController extends Controller
{

    public function get_trips(Request $request)
    {
        $start_date = date('Y-m-d', strtotime($request->post('start_date'))); 
        $end_date = date('Y-m-d', strtotime($request->post('end_date')));          

        $trips = DB::table("trip")
            ->select("trip_status", DB::raw("COUNT(trip_status) as status_count"))
            ->where('trip_status', '<>', 0)
            ->whereDate('trip_date', '>=', $start_date)
            ->whereDate('trip_date', '<=', $end_date)
            ->groupBy("trip_status")
            ->get();

        return response()->json(['response' => $trips]);
    }

    public function get_sales(Request $request)
    {
        $filter_by = $request->post('filter_by');
        if($filter_by == 'booking_date') {
            $db_filter_by = 'booking_date';
        } else {
            $db_filter_by = 'trip_date';
        }

        $sales = DB::table("trip")
            ->select(DB::raw('SUM(booking_cost) as sales'), DB::raw("DATE_FORMAT(".$db_filter_by.", '%b') month_string"),  DB::raw('MONTH('.$db_filter_by.') month'))
            ->groupby('month')
            ->get();

        return response()->json(['response' => $sales]);
    }
}