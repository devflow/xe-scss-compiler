<?php

/**
 * module scss_compiler
 * @author devflow <admin@devflow.kr>
 */
class scss_compilerModel extends scss_compiler {

    function checkScssConfiguration(){
        $checkString = ".check{color:#00bfbf;}";
        $checkFilePath = 'files/cache/test.scss';
        $checkFileRequestPath = 'files/cache/test.css';

        FileHandler::writeFile(_XE_PATH_.$checkFilePath, trim($checkString));

        $scheme = ($_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
        $hostname = $_SERVER['SERVER_NAME'];
        $port = $_SERVER['SERVER_PORT'];
        $str_port = '';
        if($port)
        {
            $str_port = ':' . $port;
        }

        $tmpPath = $_SERVER['DOCUMENT_ROOT'];

        //if DIRECTORY_SEPARATOR is not /(IIS)
        if(DIRECTORY_SEPARATOR !== '/')
        {
            //change to slash for compare
            $tmpPath = str_replace(DIRECTORY_SEPARATOR, '/', $_SERVER['DOCUMENT_ROOT']);
        }

        $query = "/" . $checkFileRequestPath;
        $currentPath = str_replace($tmpPath, "", _XE_PATH_);
        if($currentPath != "")
        {
            $query = $currentPath . $query;
        }
        $requestUrl = sprintf('%s://%s%s%s', $scheme, $hostname, $str_port, $query);
        $requestConfig = array();
        $requestConfig['ssl_verify_peer'] = false;
        $buff = FileHandler::getRemoteResource($requestUrl, null, 3, 'GET', null, array(), array(), array(), $requestConfig);

        FileHandler::removeFile(_XE_PATH_.$checkFilePath);

        return strlen(trim($buff)) > 0;
    }

    function compile_test(){
        $formatter = Context::get("formatter");

        if(!in_array($formatter, $this->FORMATTER)) $formatter = "Compressed";

        require_once $this->module_path."lib/scss.inc.php";

        $scss = new Leafo\ScssPhp\Compiler();
        $scss->setFormatter('Leafo\ScssPhp\Formatter\\'.$formatter);

        $this->add("output", $scss->compile($this->TEST_CODE));
    }

    function compile(){
        $oModuleModel = getModel('module');
        $cfg = $oModuleModel->getModuleConfig('scss_compiler');

        $path = Context::get("p");

        $protocol = isset($_SERVER['SERVER_PROTOCOL'])
            ? $_SERVER['SERVER_PROTOCOL']
            : 'HTTP/1.0';

        if(!isset($path)){
            header($protocol . ' 404 Not Found');
            header('Content-type: text/plain');
            exit();
        }

        $path = _XE_PATH_ . ltrim($path, '/\\');

        if($cfg->disabled === 'Y' || !FileHandler::exists($path) || strtolower(pathinfo($path, PATHINFO_EXTENSION)) !== 'scss'){
            header($protocol . ' 404 Not Found');
            header('Content-type: text/plain');
            exit();
        }
        
        if(!in_array($cfg->formatter, $this->FORMATTER)) $cfg->formatter = "Compressed";

        require_once $this->module_path."lib/scss.inc.php";

        $scss = new Leafo\ScssPhp\Compiler();
        $scss->setFormatter('Leafo\ScssPhp\Formatter\\'.$cfg->formatter);
        //$scss->setImportPaths("../../common/scss/");

        FileHandler::makeDir(_XE_PATH_."files/cache/scss");

        $server = new Leafo\ScssPhp\Server(_XE_PATH_, _XE_PATH_."files/cache/scss", $scss);
        $server->serve();
        exit();
    }

}