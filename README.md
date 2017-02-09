# Makerspace-Automation-Suite

Colors:
Blue: #0085A7
Orange: #F47B42

## Dependencies

1. Install Required Libraries
    * Install composer in the front-end-pages/admin-pages/resources folder (https://getcomposer.org/download/)
    * Run 'php composer.phar install' in the front-end-pages/admin-pages/resources folder to install the required dependencies
2. Update G Suite Service Account Key
    * You must update the file front-end-pages/admin-pages/resources/GSuiteAPI.php to point to the service account key. The constant CREDENTIALS_PATH should point to the location of the service_account.json file (which should be kept in a private, safe location)
