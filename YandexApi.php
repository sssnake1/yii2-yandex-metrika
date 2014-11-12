<?php

namespace mitrm;

use Yii;
use yii\base\Object;

class Metrica extends Object
{
    private $id = '';
    private $CallbackUrl;
	private $token = '';
	
	const HOST = "http://api-metrika.yandex.ru/";
	const GET_TOKEN = 'auth/get_token';

	public function init()
    {
        
		//$this->_token = $this->authGetToken();
        parent::init();
    }
	
	public function getStat($id, $goal_id)
	{
		$url = self::HOST . '/';
		return $this->curl( $url );
	}
	
	private function authGetToken()
	{
		$url = self::HOST . self::GET_TOKEN;
		
		return $this->curl( $url );
	}
	
	private function curl( $url, $params = array() )
	{
		$ch = curl_init( $url );
		$options = array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_POSTFIELDS => $params
		);
		curl_setopt_array( $ch, $options );
		$result = curl_exec( $ch );
		curl_close( $ch );

		return $result;
	}
} 