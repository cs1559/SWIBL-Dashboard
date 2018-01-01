<?php
namespace Presto\framework\geocoder;

interface GeocodeProvider {
    
    function geocode();
    function reverseGeocode();
    
}