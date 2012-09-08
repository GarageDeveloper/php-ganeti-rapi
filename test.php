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
    # Does not work:
print "RAPI Version: ".var_dump($cli->getVersion())."\n";
    # Works ok:
print "RAPI Features: ".var_dump($cli->getFeatures())."\n";

