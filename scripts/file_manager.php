<?php
    $SDK_HOME = './aws_php_sdk/';    
	include("aws_php_sdk/sdk.class.php"); // Include the SDK
    
    
    function startsWith($haystack, $needle) {
        $length = strlen($needle);
        $s = substr($haystack, 0, $length);        
        return (substr($haystack, 0, $length) == $needle);
    }
    
    class FileManager
    {
        private $s3;
        
        function __construct() {
            $this->s3 = new AmazonS3();
        }
        
        function checkIfEdited($user, $project) {
            if (!($this->has_edited($user, $project))) {
                //echo "has edited = false" . PHP_EOL;
                return $this->copy_from_default($user, $project);
            }
        }
        
        private function get_project_filenames($user, $project) {
            $files   = $this->s3->get_object_list(strtolower($project));
            $results = array();

            foreach ($files as $file) {
                echo $file . PHP_EOL;
                if (startsWith($file, $user . "/")) {
                    $results[] = $file;
                }
            }
            return $results;
        }
        
        // check if this is the first user login (user should have created his/her own files)
        private function has_edited($user, $project) {
            return (sizeof($this->get_project_filenames($user, $project)) != 0);
        }
        
        private function copy_from_default($user, $project) {
            $files = $this->get_project_filenames("default", $project);
            //echo $user . PHP_EOL;
            foreach ($files as $file) {
                $this->save_file($project, $user . "/" . substr($file, 8), $this->get_file($project, $file));
            }
        }
        
        function get_source_files($user, $project) {
            $files   = $this->s3->get_object_list(strtolower($project));
            $results = array();
                        
            foreach ($files as $file) {
                if (startsWith($file, $user . "/")) {
                    $contents = $this->get_file($project, $file);
                    if ($contents) {
                        $results[substr($file, strlen($user) + 1)] = $contents;
                    }
                }
            }
            return $results;
        }

        // retrieve file data
        function get_file($project, $filename) {
            $url = $this->s3->get_object_url(strtolower($project), $filename, '5 minutes');
            $responseData = @file_get_contents($url);

            if ($responseData) {
                return $responseData;
            }

            else {
                return false;
            }
        }
        
        function create_html_source($user, $project, $name) {
            $exists = $this->s3->if_bucket_exists(strtolower($project));
            if (!$exists) {
                echo "Error: could not find bucket\n";
                return false;
            }
            
            else {
                $DEFAULT_HTML = "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">\n<html>\n    <head>\n        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">\n        <meta name=\"viewport\" id=\"viewport\" content=\"height=600, width=1024, user-scalable=no\" />\n\n        <title>BlackBerry Default App</title>\n        <link href=\"style.css\" rel=\"stylesheet\" type=\"text/css\">\n        <script type=\"text/javascript\" src=\"script.js\"></script>\n    </head>\n\n    <body>\n        <h2>Hello World!</h2>\n    </body>\n</html>\n";
                $this->save_file($user . "/" . $name . ".html", $DEFAULT_HTML);
            }            
        }
        
        function create_js_source($user, $project, $name) {
            $exists = $this->s3->if_bucket_exists(strtolower($project));
            if (!$exists) {
                echo "Error: could not find bucket\n";
                return false;
            }
            
            else {
                $DEFAULT_JS  = "\nfunction foo() {\n    return;\n}\n";
                $this->save_file($user . "/" . $name . ".js", $DEFAULT_JS);
            }            
        }
        
        function create_css_source($user, $project, $name) {
            $exists = $this->s3->if_bucket_exists(strtolower($project));
            if (!$exists) {
                echo "Error: could not find bucket\n";
                return false;
            }
            
            else {
                $DEFAULT_CSS = "@CHARSET \"ISO-8859-1\";\n\nbody {\n/* Body styles go here */\n}\n\n#header {\n/* Header styles go here */\n}\n";
                $this->save_file($user . "/" . $name . ".css",  $DEFAULT_CSS);
            }            
        }
        
        function create_h_source($user, $project, $name) {
            $exists = $this->s3->if_bucket_exists(strtolower($project));
            if (!$exists) {
                echo "Error: could not find bucket\n";
                return false;
            }
            
            else {
                $DEFAULT_H = "\n#ifndef _main_h\n#define _main_h\n\n#endif\n";
                $this->save_file($user . "/" . $name . ".h", $DEFAULT_H);
            }            
        }
        
        function create_hpp_source($user, $project, $name) {
            $exists = $this->s3->if_bucket_exists(strtolower($project));
            if (!$exists) {
                echo "Error: could not find bucket\n";
                return false;
            }
            
            else {
                $DEFAULT_HPP = "\n#ifndef _main_hpp\n#define _main_hpp\n\n#endif\n";
                $this->save_file($user . "/" . $name . ".hpp", $DEFAULT_HPP);
            }            
        }
        
        function create_cpp_source($user, $project, $name) {
            $exists = $this->s3->if_bucket_exists(strtolower($project));
            if (!$exists) {
                echo "Error: could not find bucket\n";
                return false;
            }
            
            else {
                $DEFAULT_CPP = "\n#include <iostream>\n#include \"main.hpp\"\n\nint main (void) {\n    std::cout << \"Hello world\" << std::endl;\n    return 0;\n}\n";
                $this->save_file($user . "/" . $name . ".cpp", $DEFAULT_CPP);
            }            
        }
        
        function create_c_source($user, $project, $name) {
            $exists = $this->s3->if_bucket_exists(strtolower($project));
            if (!$exists) {
                echo "Error: could not find bucket\n";
                return false;
            }
            
            else {
                $DEFAULT_C = "\n#include <stdio.h>\n#include \"main.h\"\n\nint main(void) {\n    printf(\"Hello World\\n\");\n    return 0;\n}\n";
                $this->save_file($user . "/" . $name . ".c", $DEFAULT_C);
            }            
        }
        
        function save_file($project, $filename, $data) {
            $options = array('body' => $data);
            $this->s3->create_object(strtolower($project), $filename, $options);
        }
        
        function delete_file($user, $project, $name) {
            $filename = $user . "/" . $name;
            $response = $this->s3->delete_object(strtolower($project), $filename);
            return $response->isOk();
        }
    }
    
    include("PHPLiveX.php");
 	$ajax = new PHPLiveX();  
    
	$fileManager = new FileManager();  
	$ajax->AjaxifyObjectMethods(array("fileManager" => array("checkIfEdited", "get_source_files", "get_file", "create_html_source", "create_js_source", "create_css_source", "create_h_source", "create_hpp_source", "create_cpp_source", "create_c_source", "save_file", "delete_file")));  
    
    
	$ajax->Run(); // Must be called inside the 'html' or 'body' tags     	
	//echo "SCRIPT SUCCESSFUL!";
?>
