# Makerspace-Automation-Suite

Colors:
Blue: #0085A7
Orange: #F47B42

## Installation Steps

0. Install the Makerspace Automation Suite plugin in Wordpress
1. Install Required PHP Libraries on the Server
    * From within the plugin's directory, run 'resources/install.sh' to install required PHP libraries
    * This script installs composer (https://getcomposer.org), and runs it to install the library dependencies
2. Update Keys
    * Log into Wordpress as an admin
    * Under the Settings panel, select 'MAS Options'
    * Populate the G Suite access JSON key (must be a service account with domain-wide delegation)
    * Populate the Stripe Public and Secret Keys (supports test mode and production mode)
    * Populate the Slack Secret Key (used for sending slack invites)
3. Populate Admin Emails
    * From the MAS Options page, fill in the Admin Email Addresses (used for new member emails and failed payment emails)
4. Update the Wordpress Website to Refer to User Pages the Plugin Created
    * Add a 'Member' tab that points to /member/
        * This is the member profile page
    * Add links to /register/ where the user is expected to enter the registration process
