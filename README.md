# Makerspace-Automation-Suite

## G Suite Integration

1. Install the Google APIs Client Library
    * Install composer in the front-end-pages/admin-pages folder (https://getcomposer.org/download/)
    * Run 'php composer.phar require google/apiclient:^2.0' in the front-end-pages/admin-pages folder
2. Update Service Account Key
    * You must update the file front-end-pages/admin-pages/member_table.php to point to the service account key. The constant CREDENTIALS_PATH should point to the location of the service_account.json file (which should be kept in a private, safe location)
