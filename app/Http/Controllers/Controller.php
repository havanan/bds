<?php

namespace App\Http\Controllers;

use App\Model\Table;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Mail;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function getTableList(){
        $table = Table::where('is_active',1)->get();
        return $table;
    }
    public function getAllCartItem(){
        return Cart::content()->groupBy('id');
    }

    public function getTotalMoney(){
        $total = Cart::subtotal();
        $total = (int) $total*1000;
        return $total;
    }
    public function getTotalItem(){
        return Cart::count();
    }
    public function getDisCount($request){
        $disCount = $request->get('disCount');

        if ($disCount < 0 || $disCount > 100){
            $disCount = 0;
        }
        $totalMoney = $this->getTotalMoney();
        $disCountPrice = ($totalMoney*$disCount)/100;

        return $disCountPrice;
    }
    public function getCartInfo($request = false){
        $totalMoney = $this->getTotalMoney();
        $disCountPrice = 0;
        $cartInfo = [
            'list' =>  $this->getAllCartItem(),
            'totalMoney' => $totalMoney,
            'total' =>$this->getTotalItem(),
        ];
        if ($request){
            $disCountPrice = $this->getDisCount($request);

        }
        $cartInfo['priceFinal'] = $totalMoney - $disCountPrice;
        $cartInfo['disCount'] = $disCountPrice;
        return $cartInfo;
    }
    public function getRoundNumber($value){
        return round($value,2);
    }
    public function getMonth(){
        $data[0] = Carbon::now()->startOfMonth()->format('Y-m-d');
        $data[1] = Carbon::now()->endOfMonth()->format('Y-m-d');
        return $data;
    }
    public function getWeek(){
        $data[0] = Carbon::now()->startOfWeek()->format('Y-m-d');
        $data[1] = Carbon::now()->endOfWeek()->format('Y-m-d');
        return $data;
    }
    public function genTime($time_type){
        $data = array();
        switch ($time_type){
            case $time_type == 'yesterday':
                $data['date'] = Carbon::now()->subDay()->format('Y-m-d');
                break;
            case $time_type == 'weekly':
                $data['week'] = $this->getWeek();
                break;
            case $time_type == 'monthly':
                $data['month'] = $this->getMonth();
                break;
            default:
                $data['date'] = Carbon::now()->format('Y-m-d');
        }
        return $data;
    }
    public function getPercent($params){
        if ($params[0] == 0) {
           return 0;
        }
        return ($params[0]/$params[1])*100;
    }
    function getMessageType($code,$message,$json = false){
        $data = [
            'code' => $code,
            'message' => $message
        ];
        if ($json == true){
            $data = json_encode($data);
        }
        return $data;
    }
    public function getOldDate($number){
        $date = array();
        $key = 0;
        for ($i=1;$i<=$number;$i++){
            $date[$key] = Carbon::now()->subDay($i)->format('Y-m-d');
            $key++;
        }
        return $date;
    }
    public function getDateTitle($time_type){

        switch ($time_type){
            case $time_type == 'yesterday':
                $data = Carbon::now()->subDay()->format('d/m/Y');
                break;
            case $time_type == 'weekly':
                $week = $this->getWeek();
                $data = $week[0].' -> '.$week[1];
                break;
            case $time_type == 'monthly':
                $month = $this->getMonth();
                $data = $month[0].' -> '.$month[1];
                break;
            default:
                $data = Carbon::now()->format('d/m/Y');
        }
        return $data;
    }
    public function convertLineData($data_db){
        $chart = array();
        $labels = array();
        $data = array();
        if (count($data_db) > 0){
            foreach ($data_db as $key => $item){
                $labels[$key] = date('d/m/Y',strtotime($item->date));
                $data[$key] = (float) $item->total;
            }
        }
        $chart['labels'] = $labels;
        $chart['data'] = $data;
        return $chart;
    }

}
