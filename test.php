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

*/

require 'ganeti-rapi.php';

use ganeti\rapi;

// Change the IP address with the one of your ganeti cluster
$cli = new ganeti\rapi\GanetiRapiClient('127.0.0.1');
    # Works ok although it's not json encoded in the server response
print "RAPI Version:\n";
var_dump($cli->getVersion());
    # Works ok:
print "RAPI Features:\n";
var_dump($cli->getFeatures());

print "RAPI OperatingSystems:\n";
var_dump($cli->getOperatingSystems());

print "RAPI GetInfo():\n";
var_dump($cli->getInfo());

print "RAPI GetTags():\n";
var_dump($cli->getClusterTags());

print "RAPI GetInstances():\n";
var_dump($cli->getInstances());

print "RAPI GetInstances(bulk=true):\n";
var_dump($cli->getInstances(TRUE));

print "RAPI GetInstance(\"sandbox.myprivatedomain.priv\"):\n";
var_dump($cli->getInstance("sandbox.myprivatedomain.priv"));

