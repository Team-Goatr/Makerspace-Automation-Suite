# Makerspace-Automation-Suite

Colors:
Blue: #0085A7
Orange: #F47B42

## Installation Steps

1. Install Required Libraries
    * Run 'resources/install.sh' to install PHP libraries to support the plugin
    * This script installs composer (https://getcomposer.org), and runs it to install the library dependencies
2. Update Keys
    * Log into Wordpress as an admin
    * Under the Settings panel, select 'MAS Options'
    * Populate the G Suite access JSON key (must be a service account with domain-wide delegation)
    * Populate the Stripe Public and Secret Keys (supports test mode and production mode)
    * Populate the Slack Secret Key (used for sending slack invites)
3. Populate Admin Emails
    * From the MAS Options page, fill in the Admin Email Addresses (used for new member emails and failed payment emails)
