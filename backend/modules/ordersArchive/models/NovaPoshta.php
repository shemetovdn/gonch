<?php

namespace backend\modules\ordersArchive\models;


use common\models\Config;
use linslin\yii2\curl\Curl;
use yii\base\Model;

class NovaPoshta extends Model
{
    private $apiUrl = 'https://api.novaposhta.ua/v2.0/json/';
    private $key='06ddad4901e0d7ba614d49e69518a5e0';        //Pavel's Key

    public function init()
    {
        if(Config::getParameter('novaposhta_key')){
            $this->key=Config::getParameter('novaposhta_key');
        }

        parent::init();
    }

    private function request($data=[]){

        $data['apiKey']=$this->key;

        $data=json_encode($data);

        $curl=new Curl();
        $response = $curl
            ->setOption(CURLOPT_SSL_VERIFYHOST, 0)
            ->setOption(CURLOPT_SSL_VERIFYPEER, 0)
            ->setRequestBody($data)
            ->setHeaders([
                'Content-Type' => 'application/json',
                'Content-Length' => strlen($data)
            ])
            ->post($this->apiUrl);

        return $response;

    }

    public function getAllCities(){

        $language='ru-Ru';

        $cache=\Yii::$app->cache;
//        $cache->set('novaposhta_cities', [], 24*3600);
        $cities=$cache->get('novaposhta_cities');

        if($cities) return $cities;

        $cities=[];
        $requestData = [
            "modelName" => "AddressGeneral",
            "calledMethod" => "getSettlements",
            "methodProperties" => [
                "Page" => "1",
                "Warehouse" => "1"
            ]
        ];
        $page=1;
        do{
            $requestData["methodProperties"]["Page"]=(string)$page;
            $data=$this->request($requestData);
            $response=json_decode($data,true);
            $page++;
            foreach ($response['data'] as $city){
                $name=[];
                if($language=='ru-Ru'){
                    if($city['DescriptionRu']) $name[]=$city['DescriptionRu'];
                    if(!$city['DescriptionRu'] && $city['Description']) $name[]=$city['Description'];
                    if($city['RegionsDescriptionRu']) $name[]=$city['RegionsDescriptionRu'];
                    if(!$city['RegionsDescriptionRu'] && $city['RegionsDescription']) $name[]=$city['RegionsDescription'];
                    if($city['AreaDescriptionRu']) $name[]=$city['AreaDescriptionRu'];
                    if(!$city['AreaDescriptionRu'] && $city['AreaDescription']) $name[]=$city['AreaDescription'];
                }else{
                    if($city['Description']) $name[]=$city['DescriptionRu'];
                    if($city['RegionsDescription']) $name[]=$city['RegionsDescriptionRu'];
                    if($city['AreaDescription']) $name[]=$city['AreaDescriptionRu'];
                }
                $name=implode(', ', $name);
                if(!trim($name)) continue;
                $cities[$city['Ref']]=$name;
            }
        }while($response['data']);

        $cache->set('novaposhta_cities', $cities, 24*3600);

        return $cities;
    }

    public function getAllWarehouses($ref){
        $language='ru-Ru';

        $warehouses=[];
        $requestData = [
            "modelName" => "AddressGeneral",
            "calledMethod" => "getWarehouses",
            "methodProperties" => [
                "SettlementRef" => $ref
            ]
        ];
        $data=$this->request($requestData);
        $response=json_decode($data,true);
        foreach ($response['data'] as $warehouse){
            if($language=='ru-Ru'){
                if($warehouse['DescriptionRu']) $warehouses[$warehouse['Ref']]=$warehouse['DescriptionRu'];
                if(!$warehouse['DescriptionRu'] && $warehouse['Description']) $warehouses[$warehouse['Ref']]=$warehouse['Description'];
            }else {
                $warehouses[$warehouse['Ref']] = $warehouse['Description'];
            }
        }

        return $warehouses;
    }

}