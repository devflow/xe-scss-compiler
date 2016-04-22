#SCSS Compiler Module for XE

## 설정방법
1. 모듈을 XE에 설치합니다. (업데이트는 필요 없습니다.)
2. 이제 ``.htaccess``를 설정해야합니다. ``.htaccess``에서 static files 전에 아래 내용을 삽입합니다.
```
# scss_compiler
RewriteCond %{SCRIPT_FILENAME} !-f
RewriteRule ^(.+)\.css$ ./index.php?module=scss_compiler&act=compile&p=$1.scss [L,QSA]
```
3. 위 내용은 Client에서 요청한 파일이 없고 요청한 파일이 CSS파일일때 Redirect하여 SCSS를 컴파일하여 Response합니다.
4. 물론 SCSS파일이 없으면, ``HTTP 404 Not Found``를 Response하게 됩니다.

사용하실때에는 디자이너 혹은 개발자가, 예를들어 ``stylesheets/layout.scss`` 를 import하고 싶을땐, ``stylesheets/layout.css``를 import하여 scss를 css로 컴파일 하여 내용을 import하게 설정해야합니다.
