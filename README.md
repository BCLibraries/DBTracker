The DBTracker maintains a locally cached list of databases sourced from the LibGuides databases API and serves it as a (smaller & faster) JSON file. 

## Requirements

* PHP 5.5+

To use a Redis cache (recommended) you will need:

* Redis
* The [PECL redis package](https://pecl.php.net/package/redis)

## Installation

Clone the repository and install with [Composer](https://getcomposer.org/):

    git clone https://github.com/BCLibraries/DBTracker.git
    cd DBTracker
    composer install
    
Make a directory called *storage* to save a fallback text cache:
 
    mkdir storage

Finally, point a Web-viewable directory to the *public* directory.

## Configuring

Copy *config.init.php* to a new file name *config.php*. Edit the configuration fields appropriately.

## Access

Send a request to the *db* end-node in the appropriate path. For example, if you installed under */tracker*:

    http://library.example.edu/tracker/db
