<?php
require "vendor/autoload.php";
use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Google\Cloud\Storage\StorageClient;

class visionController extends controller{
    public $imageAnnotator;
    public $fileName;
    public $image;
    public $response;
    public $texts;
    private $projectKey;

    public function __construct() {
        
        putenv('GOOGLE_APPLICATION_CREDENTIALS=assets/js/GamerAdmin.json');
        $this->imageAnnotator = new ImageAnnotatorClient();
        // $this->auth_cloud_explicit($this->projectKey, "assets/js/GamerAdmin.json");
    }

    #Not usad
    // private function auth_cloud_explicit($projectId, $serviceAccountPath){
    //     # Explicitly use service account credentials by specifying the private key
    //     # file.
    //     $config = [
    //         'keyFilePath' => $serviceAccountPath,
    //         'projectId' => $projectId,
    //     ];
    //     $storage = new StorageClient($config);

    //     # Make an authenticated API request (listing storage buckets)
    //     foreach ($storage->buckets() as $bucket) {
    //         printf('Bucket: %s' . PHP_EOL, $bucket->name());
    //     }
    // }
    private function run($_fileName){
        $r = array();
        $x = array();
        $y = array();
        $level = array();
        $name = array();
        $date_monster = array();
        $date = new DateTime();

        $this->fileName = "images/prints/".$_fileName;
        $this->image = file_get_contents($this->fileName);

        $this->response = $this->imageAnnotator->textDetection($this->image);
        $this->texts = $this->response->getTextAnnotations();

        if($this->texts){
            $delimiter = array("/", "Nv", "nv", "R:", "Y:", "X:", ":", "/", " ", "Arquivo", "Caça", "Derrotou", "Relatórios");
            // echo "<pre>";
            if(preg_match('/'.$delimiter[9].'/', $this->texts[0]->getDescription())){
                $text = explode($delimiter[9], $this->texts[0]->getDescription());
            }else if(preg_match('/'.$delimiter[12].'/', $this->texts[0]->getDescription())){
                $text = explode($delimiter[12], $this->texts[0]->getDescription());
            }else{
                return array();    
            }
            if(preg_match('/'.$delimiter[3].'/', $text[1])){
                $phrases = explode($delimiter[3], $text[1]);
            }else{
                return array();
            }
            $c=0;
            if(count($phrases) >= 1){
                foreach ($phrases as $phrase) {
                    if(!empty($phrase) && preg_match('/'.$delimiter[11].'/', $phrase)){
                        $words = explode($delimiter[8], $phrase);
                        $r[$c] = $words[0];
                        array_shift($words);
                        $x[$c] = substr($words[0], 2);
                        array_shift($words);
                        $y[$c] = substr($words[0], 2);
                        array_shift($words);

                        for($counter = 0; $counter < count($words); $counter++){
                            if($delimiter[1] == $words[$counter]){
                                $level[$c] = $words[$counter + 1];
                            }else if(in_array($words[$counter], $level)){
                                $name[$c] = $words[$counter + 1];
                                $counter++;
                            }else if(!empty($name[$c]) && count(explode("/", $words[$counter])) == 1 && count(explode(":", $words[$counter])) == 1){
                                $name[$c] = $name[$c]." ".$words[$counter];
                            }else if(count(explode("/", $words[$counter])) > 1){
                                $words[$counter] = explode("/" , $words[$counter]);
                                $date->setDate( (int) "20".substr($words[$counter][2], 0, 2), (int) substr($words[$counter][0], -2, 2), (int) substr($words[$counter][1], 0, 2));
                                if(strlen($words[$counter][0]) > 2){
                                    $name[$c] = $name[$c]." ".substr($words[$counter][0], 0, (strlen($words[$counter][0]) - 2));
                                }
                            }else if(count(explode(":", $words[$counter])) > 1){
                                $words[$counter] = explode(":" , $words[$counter]);
                                $date->setTime((int) substr($words[$counter][0], -2, 2), (int) substr($words[$counter][1], 0, 2), (int) substr($words[$counter][2], 0, 2));
                                $date_monster[$c] = $date->format('Y-m-d H:i:s');
                            }
                        }
                    }
                    $c++;
                }
            }else{
                return array();
            }
            if(count($r) == 0 || count($x) == 0 || count($y) == 0 || count($name) == 0 || count($date_monster) == 0 || count($level) == 0){
                array();
            }else{
                return array("r_position" => $r, "x_position" => $x, "y_position" => $y, "level" => $level, "name" => $name, "date_monster" => $date_monster);

            }
        }else{
            return array();
        }
        return array();
    }

    public function index(){
        $_prints = new Prints();
        $cont_monster = array('lv1' => 0, 'lv2' => 0, 'lv3' => 0, 'lv4' => 0, 'lv5' => 0);
        $prints = $_prints->getAllPrintsForVision();
        foreach($prints as $print){
            $valid = false;
            $invalid = false;
            if($print['url_image'] != "" && $print['status'] == 0){
                $data = $this->run($print['url_image']);
                if(count($data) > 0 && count($data['name']) > 0 ){
                    for($counter = 0; $counter < count($data); $counter++){
                        if((!empty($data['name'][$counter]) && !empty($data['level'][$counter]) && !empty($data['date_monster'][$counter]) && !empty($data['x_position'][$counter]) && !empty($data['y_position'][$counter]) && !empty($data['r_position'][$counter])) && 
                            (isset($data['name'][$counter]) && isset($data['level'][$counter]) && isset($data['date_monster'][$counter]) && isset($data['x_position'][$counter]) && isset($data['y_position'][$counter]) && isset($data['r_position'][$counter])) ){
                            
                            $check = $_prints->checkMonster($data['name'][$counter], $data['level'][$counter], $data['date_monster'][$counter], $data['x_position'][$counter], $data['y_position'][$counter], $data['r_position'][$counter]);
                            if(count($check) == 0){
                                $cont_monster['lv'.$data['level'][$counter]] = $cont_monster['lv'.$data['level'][$counter]] + 1;
                                $_prints->setMonster($print['id_print'], $data['name'][$counter], $data['level'][$counter], $data['date_monster'][$counter], $data['x_position'][$counter], $data['y_position'][$counter], $data['r_position'][$counter], 1);
                                $valid = true;
                            }else{
                                $_prints->setMonster($print['id_print'], $data['name'][$counter], $data['level'][$counter], $data['date_monster'][$counter], $data['x_position'][$counter], $data['y_position'][$counter], $data['r_position'][$counter], 2, "Já está sendo usado");
                                $invalid = true;
                                // implode("," $check)
                            }
                        }
                    }
                    if(!$invalid && $valid){
                        $n_monsters = $this->ptsGoal_Enconde($cont_monster);
                        $_prints->updateAnalyzePrint($print['id_print'], $n_monsters, 0);
                        $_prints->updateAnalyzeFile($print['id_file'], 1);
                    }else if($invalid){
                        $_prints->updateAnalyzeFile($print['id_file'], 2);
                    }
                }else{
                    $_prints->updateAnalyzeFile($print['id_file'], 2);
                }
            }
        }
    }

    private function ptsGoal_Enconde($levels){
        $c = 1;
        $pts_goal = "";
        foreach($levels as $value){
            $pts_goal .= $c.'['.$value.'];';
            $c++;
        }
        return $pts_goal;
    }
}