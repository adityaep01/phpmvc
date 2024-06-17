<?php 

class App {
	protected $controller = 'Home';
	protected $method = 'index';
	protected $params = [];

	//controller
	public function __construct() {
		$url = $this->parseURL();
		
	
		
		//user mengakses index.php jadi untuk mengcek controllers harus keluar public lalu masuk ke app/controllers
		if (file_exists('../app/controllers/' . $url[0] . '.php')) {
			$this->controller = $url[0];
			unset($url[0]);
			
		}

		require_once '../app/controllers/' . $this->controller . '.php';
		$this->controller = new $this->controller;

		//method
		if(isset($url[1] )) {
			if( method_exists($this->controller, $url[1])) {
				$this->method = $url[1];
				unset($url[1]);
				
			}
		}

		//params
		if( !empty($url)) {
			$this->params = array_values($url);
		} 

		//jalankan controller & method, serta kirimkan params jika ada
		call_user_func_array([$this->controller, $this->method], $this->params);

	}

	// mengambil url setelah index.php
	public function parseURL() {
		if (isset($_GET['url'])){
			$url = rtrim($_GET['url'], '/'); //hapus '/' paling akhir url
			$url = filter_var($url, FILTER_SANITIZE_URL); // menghapus huruf gajelas di url
			$url = explode ('/', $url); // memecah url setelah public/ dengan pemisah '/'
			return $url;
		}
	}

	

}

