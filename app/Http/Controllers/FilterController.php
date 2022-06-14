<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FilterController extends Controller
{
    //
    function index(Request $request){
        //show form to upload affiliate file
        $title="Search By File";
        $action_url= route('filter.search');
        $result='';
        return view('filter', compact('title','action_url','result'));
    }

    function search(Request $request){
        $this->validate($request, [
            "user_lat" => "required",
            "user_long" => "required",
            "search_radius" => "required",
            "search_file" => "required",
        ]);
    
        $lat1   = $request->user_lat;
        $lon1   = $request->user_long;
        $search_radius   = $request->search_radius;

        $search_file = $_FILES['search_file'];
        $lines = file($search_file['tmp_name']);
        $result=[];
        foreach($lines as $line){
            $line= json_decode($line);
            $lat2   = $line->latitude;
            $lon2   = $line->longitude;
            $res    = $this->distance_btn_points($lat1, $lat2, $lon1, $lon2);
            if($res<=$search_radius){
                $line->distance = $res;
                $result[] = $line;
            }
        }
        usort($result, function ($a, $b){
            if($a->affiliate_id == $b->affiliate_id) return 0;
            return ($a->affiliate_id < $b->affiliate_id) ? 1 : -1;
        });
        
        $title="Search By File";
        $action_url= route('filter.search');
        return view('filter', compact('title','action_url', 'result'));
    }


    function distance_btn_points($lat1, $lat2, $lon1, $lon2){
        $theta = $lon1 - $lon2; 
        $earthRadius = 6371000;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)); 
        $dist = acos($dist); 
        $dist = rad2deg($dist); 
        $kms = $dist * 60 * 1.1515 * 1.609344;
        return $kms;
        
    }

    
    
     
}
