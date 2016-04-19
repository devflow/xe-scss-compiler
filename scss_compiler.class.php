<?php


/**
 * Class scss_compiler
 * @author devflow <admin@devflow.kr>
 */
class scss_compiler extends ModuleObject {

    var $FORMATTER = array(
        "Compact", "Compressed", "Crunched" , "Debug", "Expanded", "Nested", "OutputBlock"
    );

    var $TEST_CODE = <<<'EOD'
@charset "UTF-8";
@mixin helloScss($what){
    background-color: $what;
};
html {
    $basicWidth : 1920px;
    padding: 0;
    body {
        color: #ffffff;
        @include helloScss(#00bfbf);
        
        section.intro-section {
            width: $basicWidth / 3;
            margin: 0 auto;
            padding: 10px;
            
            h1 {
                font-size: 80px;
                
                > span {
                    font-size: 40px;
                }
            }
        }
    }
}
EOD;

    var $HTACCESS_STRING = <<<'EOD'
# scss_compiler
RewriteCond %{SCRIPT_FILENAME} !-f
RewriteRule ^(.+)\.css$ ./index.php?module=scss_compiler&act=compile&p=$1.scss [L,QSA]
EOD;

    var $MODULE_UUID = "8fb7b496-ac36-422e-ae08-ed321301df5e";

    /**
     * Additional tasks required to accomplish during the installation
     *
     * @return Object
     */
    function moduleInstall()
    {
        return new Object();
    }

    /**
     * A method to check if the installation has been successful
     * @return bool
     */
    function checkUpdate()
    {

        return false;
    }

    /**
     * Execute update
     *
     * @return Object
     */
    function moduleUpdate()
    {
        return new Object(0, 'success_updated');
    }

    /**
     * Re-generate the cache file
     *
     * @return void
     */
    function recompileCache()
    {
    }

}