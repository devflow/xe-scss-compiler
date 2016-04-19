jQuery(function($){


    window.scss_compile_test_code = function(){
        var formatter = $("#formatter > option:selected").val();

        exec_json("scss_compiler.compile_test", {
            formatter: formatter
        }, function(d){
            $("#test_code_output").val(d.output)
        })
    };

    $("#formatter").change(window.scss_compile_test_code);
    window.scss_compile_test_code();
});