<?php

$o=new MainClass();

$o->showImg();





 class MainClass
 {

 	private $cn;//подключение к БД 	
 	private $_page; // url страницы
 	private $_UA;//юзер агент
 	private $_IP; //ИП адресс
 	private $_Time; //Дата визита



 	function __construct()
 	{ 		
 		$this->_UA=$this->escape($_SERVER['HTTP_USER_AGENT']);
 		$this->_IP=$this->escape($_SERVER['REMOTE_ADDR']);
 		$this->_page=$this->escape($_SERVER['HTTP_REFERER']);
 		$this->_Time=date('Y-m-d H:i:s');
 		
 		$this->saveVisit();
 	}

 	//Выводит изображение
 	public function showImg()
 	{
 		header('Content-Type: image/jpeg');
		readfile(__DIR__.'/6929c35db99d7df8444227fffce48d1a.jpg');
		exit;
 	}





 	//подключение к БД
	private function connect()
	{      
 		$_cnf=[ 			
			'host'=>'localhost',
			'user'=>'root',
			'password'=>'',
			'db'=>'db',
		];		
		$this->cn=new mysqli(
			$_cnf['host'],
			$_cnf['user'],
			$_cnf['password'],
			$_cnf['db']
		);		
		if (!$this->cn) {		  
		   exit;
		} 
		$this->cn->query('set names \'utf8\'');
		return $this->cn;
	}

	//Экранирование потенциально-опасных символов
	private function escape($s)
    {
        if ( ! ($this->cn instanceof mysqli)) {
            $this->connect();
        }
        $s = $this->cn->escape_string($s);
        return $s;
    }

    //запрос в базу данных
 	private function query($sql)
    {
        if ( ! ($this->cn instanceof mysqli)) {
            $this->connect();
        }       
        if (!($result = $this->cn->query($sql))) {
			exit;
        } else {
            return $result;
        }
        
    }

    //Количество записей в результате запроса
    private function getRecordCount($ds)
    {
        return ($ds ) ? $ds->num_rows : 0;
    }

    //Добавляет или обновляет инормацию о посетителе
    private function saveVisit()
    {
    	$table='user_visits';
    	$where = "ip_address like '{$this->_IP}' and user_agent like '{$this->_UA}' and page_url like '{$this->_page}' ";

        if ($this->getRecordCount($this->query("SELECT id FROM `{$table}` WHERE  {$where}") ) === 0) {
            $mode = 'insert';
        } else {
            $mode = 'update';
        }
        if($mode === 'insert'){
			return $this->query("INSERT INTO  `{$table}`  (`ip_address`, `user_agent`, `view_date`, `page_url`) VALUES ('{$this->_IP}','{$this->_UA}','{$this->_Time}','{$this->_page}' ) ") ;
        }
        else
        	return $this->query( "UPDATE `{$table}` SET `view_date`='{$this->_Time}',`views_count`=views_count+1 WHERE {$where} " );
    }







 } 





?>