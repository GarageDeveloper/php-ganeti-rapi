<?php
 
        //$submit_url = "https://<ganeti ip address>:5080/2/instances/sandbox2.yourdomain.priv?dry-run=1";
        $submit_url = "https://<ganeti ip address>:5080/2/instances/sandbox2.yourdomain.priv";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "<rapi user>:<rapi password>");
        curl_setopt($ch, CURLOPT_SSLVERSION, 3);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $submit_url);
        $data = curl_exec($ch);
        print_r(json_decode($data));
        curl_close($ch);
