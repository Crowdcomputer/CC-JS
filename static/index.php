<?php

function get_url($url, $javascript_loop = 0, $timeout = 10) {
    $url = str_replace("&amp;", "&", urldecode(trim($url)));

    $cookie = tempnam("/tmp", "CURLCOOKIE");
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1");
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_ENCODING, "");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_AUTOREFERER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    # required for https urls
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 20);
    $content = curl_exec($ch);
    $response = curl_getinfo($ch);
    curl_close($ch);

    if ($response['http_code'] == 301 || $response['http_code'] == 302) {
        ini_set("user_agent", "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1");

        if ($headers = get_headers($response['url'])) {
            foreach ($headers as $value) {
                if (substr(strtolower($value), 0, 9) == "location:")
                    return get_url(trim(substr($value, 9, strlen($value))));
            }
        }
    }

    if (( preg_match("/>[[:space:]]+window\.location\.replace\('(.*)'\)/i", $content, $value) || preg_match("/>[[:space:]]+window\.location\=\"(.*)\"/i", $content, $value) ) &&
            $javascript_loop < 5
    ) {
        return get_url($value[1], $javascript_loop + 1);
    } else {
        return $content; // return array( $content, $response );
    }
}

if (isset($_GET['link'])) {
//---------------------------------------------------------------------------
    $url = $_GET['link'];
    //Extract domain name:
//---------------------------------------------------------------------------
    $slash_pos = strpos($url, '/', 10);
    if ($slash_pos > 0)
        $domain_address = substr($url, 0, $slash_pos);
    else
        $domain_address = $url;
    //echo '<br/>' . $domain_address;
    $content = get_url($url);
//---------------------------------------------------------------------------
//Substitute hrefs and src in order to show correct images and styles
//---------------------------------------------------------------------------
    $content = str_replace("Erforderlich", "Required", $content);
    $content = str_replace("Sonstiges", "Others", $content);
    $content = str_replace("href='", "href='" . $domain_address . "/", $content);
    $content = str_replace("href=\"", "href=\"" . $domain_address . "/", $content);

    $content = str_replace("src='", "src='" . $domain_address . "/", $content);
    $content = str_replace("src=\"", "src=\"" . $domain_address . "/", $content);

    $content = str_replace("src='" . $domain_address . "/http", "src='http", $content);
    $content = str_replace("src=\"" . $domain_address . "/http", "src=\"http", $content);

    $content = str_replace("href='" . $domain_address . "/http", "href='http", $content);
    $content = str_replace("href=\"" . $domain_address . "/http", "href=\"http", $content);

    //---------------------------------------------------------------------------
    echo $content;
    ?>
    <script>
    var email_row_mode=<?php if (isset($_GET['mode'])) echo intval($_GET['mode']); else echo 0; ?>;
    
    </script>
    <script src="static/js/jquery.min.js"></script>
    <script src="static/js/cm-func<?php if (isset($_GET['local'])) echo '-local'; ?>.js"></script>
    <script src="static/js/google-forms.js"></script>
    <?php
}else {
    ?>
    <link href="static/css/bootstrap.min.css" rel="stylesheet">
    <div class="container">
        <div class="hero lead">
            <h2 class="muted">Wrapper of the web-forms for<h2>
                    <h1>CrowdComputer</h1>
                    <p >Please pass a url in the link parameter, like here:</p>
                    <p><a href="http://dev.kucherbaev.com/survey/?link=https://docs.google.com/spreadsheet/viewform?formkey=dG5feTQtSGFIX0podjQxb2NtYmlKUEE6MQ" target="_blank">http://form.electrocrowd.com/?link=https://docs.google.com/spreadsheet/viewform?formkey=dG5feTQtSGFIX0podjQxb2NtYmlKUEE6MQ</a></p>
                    <p><span class="label label-success"> Make sure- there is no <strong>&</strong> symbols in the url. Currently it is not supported.</span></p>
                    </div>
    </div>
                    <?php
                }
                ?>
                <!--script>
                    function addJavascript(jsname,pos) {
                        var th = document.getElementsByTagName(pos)[0];
                        var s = document.createElement('script');
                        s.setAttribute('src',jsname);
                        th.appendChild(s);
                    }
                    //Connect jQuery if it is not connected
                    if (typeof jQuery == 'undefined')
                    {
                        console.log('jquery-no');
                        addJavascript('http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js','head');
                        console.log('jquery-connected');
                    }
                    setTimeout(function() {
                        addJavascript('http://dev.kucherbaev.com/CrowdMemories/cm-func<?php //if (isset($_GET['local'])) echo '-local';  ?>.js','body');
                        if ('<?php // echo $domain_address;  ?>'=='https://docs.google.com'){
                            addJavascript('google-forms.js','body');
      
                        }},100);
                    console.log('<?php //echo $domain_address  ?>');

    
                </script-->