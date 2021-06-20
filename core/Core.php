<?php 
class Core {

    public function run(){
        $url = '/';
        $url .= (isset($_GET['url']))? $_GET['url'] : '';
        $params = array();

        if(!empty($url) && $url != '/'){
            $url = explode('/', $url);
            array_shift($url);

            if(!empty($url[0]) ){
                $currentController = $url[0].'Controller';
                array_shift($url);
            }
            if(!empty($url[0]) && $url[0] != '/'){
                $currentAction = $url[0];
                array_shift($url);
            }else{
                $currentAction = 'index';
            }
            if(count($url) > 0){
                $params = $url;
            }
        }else{
            $currentController = 'userController';
            $currentAction = 'home';
        }
        if(!file_exists('controllers/'.$currentController.'.php') || !method_exists($currentController, $currentAction)){
            $currentController = 'notFoundController';
            $currentAction = 'index';
        }

        $c = new $currentController();
        //Executando uma função sem saber o nome
        call_user_func_array(array($c, $currentAction), $params);
    }
}