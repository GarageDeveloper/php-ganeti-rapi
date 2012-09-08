<?php

/*
    Copyright (C) 2012 Raphaël Enrici / Root 42 / Garage Developer

    This program is free software; you can redistribute it and/or modify
    it under the terms of the license chosen by its author

    As of september 2012:
    Currently the license is not definitely chosen, if you are in doubt
    consider this work as GPL either version 2 or later although we may
    chose something more friendly with commercial products in a near
    future (BSD or Artistic).

    This program is distributed in the hope that it will be useful, but
    WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.


    Please note that most of the work done here is mostly inspired by
    the original python code of the RAPI client that you can find on the
    ganeti repository. Please see: http://code.google.com/p/ganeti/

*/

namespace ganeti\rapi;

// Active assert
assert_options(ASSERT_ACTIVE, 1);


class GanetiRapiClient
{
    private $host;
    private $port;
    private $username;
    private $password;
    private $baseUrl;
    public static $USER_AGENT = 'PHP Ganeti RAPI Client';

    // function GanetiRapiClient($host, $port=5080, $username=NULL,
    function __construct($host, $port=5080, $username=NULL,
                                $password=NULL)
    {
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;

        try {
            $address = inet_pton("$host");
            if(strlen($address) == 4) {
                # IPV4
                $this->baseUrl = "https://$host:$port";
            } elseif (strlen($address) == 16) {
                # IPV6
                $this->baseUrl = 'https://[$host]:$port';
            } else {
                # We should never get here
                # TODO: RAISE AN ERROR ?
                echo 'FIXME: WE SHOULD NOT BE THERE\n';
            }
        } catch (\Exception $e) {
            # TODO: handle this correctly
            echo 'Exception received: ', $e->getMessage() , "\n";
        }

        if (!is_null($username)) {
            if (is_null($password))
                throw new \Exception('Password not specified');
        } elseif (!is_null($password)) {
                throw new \Exception('Specified password without username');
        }

    }

    private function createCurl() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_VERBOSE, FALSE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
        curl_setopt($ch, CURLOPT_NOSIGNAL, TRUE);
        //TODO: FIX THIS curl_setopt($ch, CURLOPT_USERAGENT, $self::USER_AGENT);
        curl_setopt($ch, CURLOPT_USERAGENT, 'PHP GANETI RAPI CLIENT');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    "Accept: application/json",
                    "Content-Type: application/json",
                    ));
        # TODO: reproduce assert from client.py

        if (!is_null($this->username)) {
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD,
                $this->username.":".$this->password);
        }

        # TODO: reproduce curl callables from client.py

        # curl_setopt($ch, CURLOPT_SSLVERSION, 3);
        # curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        # curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        # curl_setopt($ch, CURLOPT_HEADER, false);
        # curl_setopt($ch, CURLOPT_POST, true);
        # curl_setopt($ch, CURLOPT_POSTFIELDS, $p );
        # curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        # curl_setopt($ch, CURLOPT_URL, $submit_url);

        return $ch;
    }

    private static function encodeQuery($query) {
        # TODO: please code me
    }

    private function sendRequest($method,$path,$query=NULL,$content=NULL) {
        /*
    Sends an HTTP request.

    This constructs a full URL, encodes and decodes HTTP bodies, and
    handles invalid responses in a pythonic way.

    @type method: string
    @param method: HTTP method to use
    @type path: string
    @param path: HTTP URL path
    @type query: list of two-tuples
    @param query: query arguments to pass to urllib.urlencode
    @type content: str or None
    @param content: HTTP body content

    @rtype: str
    @return: JSON-Decoded response

    @raises CertificateError: If an invalid SSL certificate is found
    @raises GanetiApiError: If an invalid response is returned
        */

        assert($path[0] == '/');

        $ch = $this->createCurl();

        $encodedContent = "";
        if (!is_null($content))
            $encodedContent = json_encode($content);

        $urlParts = array($this->baseUrl,$path);
        if (!is_null($query)) {
            array_push($urlParts,'?');
            array_push($urlParts,urlencode($this->encodeQuery($query)));
        }

        $url = implode($urlParts);
        print "$url\n";

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "".$method);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedContent);

        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if ( ! $response = curl_exec($ch) ) {
            $err = curl_error($ch);
            $errnum = curl_errno($ch);
            # TODO bis: make 60 an 77 explicit constants
            #   _CURLE_SSL_CACERT = 60
            #   _CURLE_SSL_CACERT_BADFILE = 77
            # TODO: code CertificateError Exception type
            if ($errnum == 60 || $errnum == 77)
                throw new \Exception('SSL certificate error '.$err);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "" );
            # TODO: code GanetiApiError Exception type
            throw new \Exception('GANETI API error '.$err);
        }

        # Get HTTP response code
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        # When asking RAPI server for the version, the result is not
        # json encoded... So we return the result as is
        if ( !$responseContent = json_decode($response) )
            $responseContent = $response;
        

        if ($httpCode != 200) {
            # TODO: code explode in case of a dict response
            var_dump($responseContent);
            $msg = $responseContent;
            #TODO: code GanetiApiError throw new Exception('GANETI API error '.$msg,
                                # $code = $httpCode);
            throw new \Exception('GANETI API error '.$msg);
        }
        return $responseContent;
    }

    public function getVersion() {
        return $this->sendRequest("GET", "/version");
    }

    public function getFeatures() {
        # TODO: add checks as they are written in the client.py
        return $this->sendRequest("GET", "/2/features");
    }
}
