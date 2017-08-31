## Synopsis

This basic script generates JS which can be pasted into the console of your browser to auto complete forms.
This allows us to enter large amounts of data into forms we don't have control of via their front end.

## Code Example

To get started go into dataToJs.php and uncomment these 2 lines

// $configFile = 'config_example.xml';
// $dataFiles = 'data_example.csv';

From the console run

php dataToJs.php

The output is the resulting JS from the script. You can open example.html in your browser. Cut and paste the JS and run in the console to see the form become populated.

To get this to work for the form you require create your own /config/config.xml (use config_example.xml as a guide) and export your data to populate the form into /data/data.csv

## Motivation

Allowing export of large CSV data and the conversion to a simple JS file to allow input into a form you may not own.

## Installation

This script requires PHP5 and CLI access.

## Contributors


## License

