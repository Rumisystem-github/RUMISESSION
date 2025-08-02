<?php
/**
 * るみセッション V1.5
 */

class RUMISESSION{
	public $COOKIE_NAME = "SESSION";
	public $SESSION_DATA = array();
	public $SESSION_ID = "";
	public $FILE_PATH = "/var/www/SESSION/";

	public function RSESSION_START(){
		if(!empty($_COOKIE[$this->COOKIE_NAME])){
			$SESSION_ID = preg_replace("/[^a-zA-Z0-9_\-\.]/", "", $_COOKIE[$this->COOKIE_NAME]);

			//セッションがある
			if(file_exists($this->FILE_PATH.$SESSION_ID)){
				//ファイルが有る
				$this->SESSION_ID = $SESSION_ID;

				$SESSION_FILE = file_get_contents($this->FILE_PATH.$this->SESSION_ID);

				if($SESSION_FILE){
					$this->SESSION_DATA = json_decode($SESSION_FILE, true);
					if(json_last_error() == JSON_ERROR_NONE){
						//JSONのえらーなし
						return true;
					}
					else{
						//JSONのえらーあり
						return false;
					}
				}else{
					return false;
				}
			}else{
				//ファイルがない
				//ID生成
				$TOKEN_LENGTH = 10;
				$bytes = random_bytes($TOKEN_LENGTH);
				$ID = bin2hex($bytes);

				setcookie($this->COOKIE_NAME, $ID, time() + 60 * 60 * 24 * 30, "/");//クッキーセット

				try{
					$file_handle = fopen($this->FILE_PATH.$ID, "w");//ファイルを書き込みモードで開く
					fwrite($file_handle, "{}");//ファイルへデータを書き込み
					fclose($file_handle);//ファイルを閉じる

					//再読込させる
					header("Refresh:1");
				}catch(\Exception $ex){
					echo $ex;
					exit;
				}
			}
		}else{
			//セッションが無い
			//ID生成
			$TOKEN_LENGTH = 10;
			$bytes = random_bytes($TOKEN_LENGTH);
			$ID = bin2hex($bytes);

			setcookie($this->COOKIE_NAME, $ID, time() + 60 * 60 * 24 * 30, "/");//クッキーセット

			try{
				$file_handle = fopen($this->FILE_PATH.$ID, "w");//ファイルを書き込みモードで開く
				fwrite($file_handle, "{}");//ファイルへデータを書き込み
				fclose($file_handle);//ファイルを閉じる

				//再読込させる
				header("Refresh:1");
			}catch(\Exception $ex){
				echo $ex;
				exit;
			}
		}
	}

	public function RSESSION_SET($NAME, $VALUE){
		if($this->SESSION_ID !== ""){
			$this->SESSION_DATA = $this->SESSION_DATA += array($NAME => $VALUE);
			
			if(!$this->SESSION_DATA[$NAME]){
				$this->RSESSION_DEL($NAME);
			}

			$file_handle = fopen($this->FILE_PATH.$this->SESSION_ID, "w");//ファイルを書き込みモードで開く
			fwrite($file_handle, json_encode($this->SESSION_DATA));//ファイルへデータを書き込み
			fclose($file_handle);//ファイルを閉じる

			if(json_last_error() == JSON_ERROR_NONE){
				//JSONのえらーなし

				return true;
			}
			else{
				//JSONのえらーあり
				return false;
			}
		}else{
			return false;
		}
	}

	public function RSESSION_GET($NAME){
		if(!empty($this->SESSION_DATA[$NAME])){
			return $this->SESSION_DATA[$NAME];
		}else{
			return false;
		}
	}

	public function RSESSION_DEL($NAME){
		unset($this->SESSION_DATA[$NAME]);

		$file_handle = fopen($this->FILE_PATH.$this->SESSION_ID, "w");//ファイルを書き込みモードで開く
		fwrite($file_handle, json_encode($this->SESSION_DATA));//ファイルへデータを書き込み
		fclose($file_handle);//ファイルを閉じる

		if(json_last_error() == JSON_ERROR_NONE){
			//JSONのえらーなし

			return true;
		}
		else{
			//JSONのえらーあり
			return false;
		}
	}

	public function RSESSION_RG(){

	}
}
?>
