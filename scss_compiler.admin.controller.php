<?php

class scss_compilerAdminController extends scss_compiler {


    function procScss_compilerAdminInsertConfig(){
        $oModuleModel = getModel('module');
        $cfg = $oModuleModel->getModuleConfig('scss_compiler');

        $cfg->disabled = Context::get("disabled") == 'Y' ? "Y" : "N";

        $formatter = Context::get("formatter");

        if(!in_array($formatter, $this->FORMATTER)) $formatter = "Compressed";

        $cfg->formatter = $formatter;

        $oModuleController = getController('module');
        $oModuleController->insertModuleConfig('scss_compiler', $cfg);

        $this->setRedirectUrl(Context::get('success_return_url'));
    }

}