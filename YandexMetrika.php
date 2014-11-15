<?php
namespace metrika;

use Yii;
use yii\base\Object;

class YandexMetrika extends Object
{
    public $id;
    public $CallbackUrl;
	public $token;
	
	const HOST = "http://api-metrika.yandex.ru/";
	const GET_TOKEN = 'auth/get_token';

	public function init()
    {
        parent::init();
    }
	
	public function getStat($id, $goal_id)
	{
		
		$url = self::HOST . '/counters.json?id=22053997&goal_id=2797094&date1=20141112&date2=20141112&oauth_token='.$this -> token;
		return $this->curl( $url );
	}
	
	/**
	 * Получение целевого отчета посещаемости
	 * @param type $id
	 * @param type $goal_id
	 * @param type $date1 - TRUE = дата отчета за сегодня
	 * @return type
	 */
	public function getStat_goal($id, $goal_id, $date1=FALSE)
	{
		$url = self::HOST . 'stat/traffic/summary.json?id='.$id.'&goal_id='.$goal_id.'&oauth_token='.$this -> token;
		if($date1)
		{
			$date1 = Yii::$app->formatter->asDate('now', 'yyyyMMdd'); // 20141006
			$url.='&date1='.$date1;
			$url.='&date2='.$date1;
		}
		return $this->curl( $url );
	}
	
	private function authGetToken()
	{
		$url = self::HOST . self::GET_TOKEN;
		
		return $this->curl( $url );
	}
	
	private function curl( $url, $params = [] )
	{
		$ch = curl_init( );
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
