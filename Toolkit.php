<?php
class Toolkit extends CI_Controller {

    public function __contruct(){
        parent::__contruct();
    }

    protected $filename ="";
    protected $module_name="";

    //generator Modules
    public function add_module($module_name){
        $this->controller(ucfirst($module_name."_controller"), $module_name);
        $this->model(ucfirst($module_name."_model"), $module_name);
        $this->view($module_name);
    }

    public function remove_module($module_name) {
        $dir = APPPATH . "modules/$module_name";
        $this->remove_directory($dir);
        echo "module has successfully been removed." . PHP_EOL;
     }

    protected function remove_directory($dir){
        if (is_dir($dir)) {
         $objects = scandir($dir);
         foreach ($objects as $object) {
           if ($object != "." && $object != "..") {
             if (is_dir($dir."/".$object))
               $this->remove_directory($dir."/".$object);
             else
               unlink($dir."/".$object);
           }
         }
         rmdir($dir);
       }
    }

    //generator controller
    public function controller($filename, $module_name) {

        $this->filename = $filename;
        $this->module_name = $module_name;
        $this->make_controller_directory();
        $this->make_controller_file();
    }

     protected function make_controller_directory(){
        $dir = APPPATH . "modules/$this->module_name";

        if (!is_dir($dir)) {
            mkdir($dir);
            mkdir($dir."/controllers");
        }
        elseif(!is_dir($dir."/controllers")){
           mkdir($dir."/controllers");
        }
        else{
            echo "controller directory has been been created before." . PHP_EOL;
            return;
        }

        echo "controller directory has successfully been created." . PHP_EOL;
    }

    protected function make_controller_file() {
         $path = APPPATH . "modules/$this->module_name/controllers/$this->filename.php";

        $my_controller = fopen($path, "w") or die("Unable to create model file!");

        $controller_template = "<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

        class $this->filename extends MY_Controller {

            public function __construct() {
                parent::__construct();
            }
        }
        ";

        fwrite($my_controller, $controller_template);

        fclose($my_controller);

        echo "controller file has successfully been created." . PHP_EOL;
    }


    //generator Model
    public function model($filename, $module_name) {
        $this->filename = $filename;
        $this->module_name = $module_name;
        $this->make_model_directory();
        $this->make_model_file();
    }

    protected function make_model_directory(){
        $dir = APPPATH . "modules/$this->module_name";

        if (!is_dir($dir)) {
            mkdir($dir);
            mkdir($dir."/models");
        }
        elseif(!is_dir($dir."/models")){
           mkdir($dir."/models");
        }
        else{
            echo "model directory has been been created before." . PHP_EOL;
            return;
        }

        echo "model directory has successfully been created." . PHP_EOL;
    }

    protected function make_model_file() {

         $path = APPPATH . "modules/$this->module_name/models/$this->filename.php";

        $my_model = fopen($path, "w") or die("Unable to create model file!");

        $model_template = "<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

        class $this->filename extends MY_Model {

            public function __construct() {
                parent::__construct();
            }
        }
        ";

        fwrite($my_model, $model_template);

        fclose($my_model);

        echo "model file has successfully been created." . PHP_EOL;
    }

    //generator view
    public function view($module_name) {
        $this->module_name = $module_name;
        $this->make_view_directory();
    }

     protected function make_view_directory(){
        $dir = APPPATH . "modules/$this->module_name";

        if (!is_dir($dir)) {
            mkdir($dir);
            mkdir($dir."/views");
        }
        elseif(!is_dir($dir."/views")){
           mkdir($dir."/views");
        }
        else{
            echo "view directory has been been created before." . PHP_EOL;
            return;
        }

        echo "view directory has successfully been created." . PHP_EOL;
    }

}
?>
