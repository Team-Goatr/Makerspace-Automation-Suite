# Makerspace-Automation-Suite

## Release Notes for v1.0
### New Features
* New registration form ties into GSuite backend.
* GSuite users are automatically created upon registration and successful payment.
* New members are automatically added to a Slack group upon registration and successful payment.
* Members can manage their credit card information through a profile page.
* Administrators are notified of new member creation as well as payment failures.
* Administrators can view and edit all members from the Makerspace Automation Suite page.
* RFID Tag Numbers and corellating subscription levels are available via a webhook located at: *Base Domain*/?webhook-listener?=rfid

### Bugfixes
* Because this is the first release, there are currently no bugfixes.

### Known Bugs
* If not logged in with a GSuite account, the Member Page shows PHP error text.
* Password mismatch or duplicate username on registration does not prevent submission.
* Subscription type is not automatically selected when selecting "Apply Now".
* Updating a user via the administrator view requires the RFID field to have a value.

## Installation Steps
1. Download the ZIP file of the MAS Plugin from the releases section.
2. Install the Makerspace Automation Suite Plugin via the Upload ZIP Folder option.
3. Install Required PHP Libraries on the Server.
    * NOTE: The website will not be functional if the plugin is active and the dependencies have not been installed.
    * From within the plugin's directory, run 'resources/install.sh' to install required PHP libraries.
    * This script installs composer (https://getcomposer.org), and runs it to install the library dependencies.
4. Update Keys.
    * Log into Wordpress as an admin
    * Under the Settings panel, select 'MAS Options'
    * Populate the G Suite access JSON key (must be a service account with domain-wide delegation)
    * Populate the Stripe Public and Secret Keys (supports test mode and production mode)
    * Populate the Slack Secret Key (used for sending slack invites)
5. Populate Admin Emails.
    * From the MAS Options page, fill in the Admin Email Addresses (used for new member emails and failed payment emails)
6. Update the Wordpress Website to Refer to User Pages the Plugin Created.
    * Add a 'Member' tab that points to /member/
        * This is the member profile page
    * Add links to /register/ where the user is expected to enter the registration process
7. Install the GSuite Login Plugin to enable GSuite SAML.
    * [Download Link](https://wordpress.org/plugins/miniorange-google-apps-login/)
    * Follow the configuration steps provided with the plugin.
    * Replace "Login" instances on website with a link to the new GSuite login.

## Troubleshooting
1. If the website fails to load after the plugin has been installed (i.e. a white page), check the server's PHP logs to see if a dependency was not installed correctly.
2. If the Makerspace Automation Suite displays error text but the rest of the website still loads, check the validity of the API keys under the "MAS Options" page in the Administrator settings page.
3. If the Makerspace Automation Suite is not visible in the administrator dashboard, check to ensure that you are an administrator who can edit settings.
