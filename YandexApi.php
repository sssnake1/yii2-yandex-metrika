<?php

namespace Mitrm\yii\extensions;

use Yii;
use yii\base\Object;

class YandexApi extends Object
{
    public $id = '';
    public $CallbackUrl;
	public $token = '';
	
	const HOST = "http://api-metrika.yandex.ru/";
	const GET_TOKEN = 'auth/get_token';

	public function init()
    {
        
		//$this->_token = $this->authGetToken();
        parent::init();
    }
	
	public function getStat($id, $goal_id)
	{
		$url = self::HOST . '/stat/traffic/summary.json?id=22053997&goal_id=2797094&date1=20141112&date2=20141112&oauth_token='.$this -> token;
        echo $url;
		return $this->curl( $url );
	}
	
	private function authGetToken()
	{
		$url = self::HOST . self::GET_TOKEN;
		
		return $this->curl( $url );
	}
	
	private function curl( $url, $params = [] )
	{
		$ch = curl_init();
		$options = [
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_TIMEOUT => 30,
		];
        if(!empty($params))
            $options[CURLOPT_POSTFIELDS] = $params;
        
        curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt_array( $ch, $options );
		$result = curl_exec( $ch );
		curl_close( $ch );

		return $result;
	}
} 
