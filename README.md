# Makerspace Automation Suite
The Makerspace Automation Suite (MAS) is a Wordpress plugin built for the [Decatur Makers](https://www.decaturmakers.org/) by Team Goatr, a team of students from Georgia Tech. The Makerspace Automation Suite automates the onboarding process of creating accounts and sending email invitations to new members who register for the makerspace. MAS integrates with a G Suite account, using the G Suite directory as a master data store for user information and accounts. MAS also integrates with Stripe for online payment processing and subscription management. MAS provides a registration process UI, member profile page UI, admin member table UI, and admin member edit UI.

Decatur Makers Colors:
Blue: #0085A7
Orange: #F47B42

## Release Notes

### v0.6 2017-04-17
* **New Features**
    * More edit capabilities for admins editing members
    * Restyling of admin member edit page
    * URL filtering of member table (before, since, founding, type, status)
    * Added member creation date and founding member status to member table
    * Member change password functionality
    * Admin emails are now configurable in the MAS Options admin page
* **Bug Fixes**
    * Fix update card functionality on member page
    * ZIP code prompt added to update card popup
    * Member page formatting fixed by removing Angular and using Bootstrap container-fluid
    * Background color fix on member profile, registration review, and registration submit pages
* **Known Bugs and Defects**
    * Registration form still allows you to submit when username field is red (#130)
    * Registration form still allows you to submit when passwords are mismatched
    * Admin member edit page doesn't allow edit of subscription status (#113)
    * Admin member edit page cannot be submitted with RFID field blank (#110)
    * Passwords aren't validated per G Suites requirements (#107)
    * If you navigate to the member page without being logged in via Google, PHP error is shown (#97)
    * Login may fail when logged into another (non-DecaturMakers) Google account (#44)
    * Old admin pages still need to be cleaned up
    * No email alerts are sent to non-recurring members when membership expires
    * Non-recurring members don't have their subscription status automatically updated when they expire

### v0.5 2017-04-02 Initial Release
* **New Features**
    * Admin member table
    * Admin member edit page
    * Member profile page
        * Members can view and update information
    * New registration form
        * Creates G Suite users
        * Processes Stripe payment
        * Associates Stripe account with G Suite user
        * Sends new members invite to a Slack group
    * MAS Options page to edit settings
    * RFID webhook to enable extensibility
    * Stripe webhook listener to process events sent by Stripe
    * Admin notifications sent when new members registered and when payment fails
* **Bug Fixes**
    * n/a
* **Known Bugs and Defects**
    * Some pages have white background (#117)
    * Card update functionality doesn't work for members (#111)
    * Card update prompt doesn't request ZIP code (#109)

## Install Guide
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

## Authors
* Team Goatr
    * [Craig](https://github.com/cmowenby)
    * [Dana](https://github.com/danaalyse)
    * [Jasmine](https://github.com/jmbrown864)
    * [Ryan](https://github.com/ryanstrat)
    * [Thomas](https://github.com/thomascoe)
