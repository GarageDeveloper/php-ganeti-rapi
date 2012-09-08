<?php
 
        $params = array (
                '__version__'   => 1,          
                'mode'                  => 'create', 
                'beparams'              => array('vcpus' => '1', 'memory' => '2048M'),
                'name_check'            => False,
                'ip_check'            => False,
                'no_install'            => True,
                'start'                 => False,
                'instance_name'         => 'sandbox2.yourdomain.priv',
                'disk_template'         => 'drbd',
                'disks'                 => array( array ('size' => '5G') ),
                'nics'                  => array( array ('ip' => 'a.b.c.d') ),
                'os_type'               => 'debootstrap+default',
                'iallocator'            => 'hail',
        );
        
        $p = json_encode($params);
        print $p."\n";
        $submit_url = "https://<ganeti cluster ip>:5080/2/instances";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "<rapi user>:<rapi password>");
        curl_setopt($ch, CURLOPT_SSLVERSION, 3);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $p );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $submit_url);
        $data = curl_exec($ch);
        print_r(json_decode($data));
        curl_close($ch);
