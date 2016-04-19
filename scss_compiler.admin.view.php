<?php

class scss_compilerAdminView extends scss_compiler {

    function dispScss_compilerAdminConfig(){

        $oModuleModel = getModel('module');
        $cfg = $oModuleModel->getModuleConfig('scss_compiler');
        $oScssCompilerModel = getModel('scss_compiler');

        $is_configured = $cfg->disabled == "Y" || $oScssCompilerModel->checkScssConfiguration();

        Context::set("is_configured", $is_configured);

        if(!$is_configured) Context::set("htaccess_code", $this->HTACCESS_STRING);

        Context::set("cfg", $cfg);
        Context::set("test_code", $this->TEST_CODE);
        Context::set("formatters", $this->FORMATTER);

        $this->setTemplatePath($this->module_path."tpl");
        $this->setTemplateFile("config.html");
    }


}