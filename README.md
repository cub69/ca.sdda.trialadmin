# ca.sdda.trialadmin

![Screenshot](/images/Screenshot.png)

This is a very customized CiviCRM extension for the Sporting Detection Dogs Association. It is designed to better integrate the trial application process and add macro type buttons to the Administration tab. 

The extension is licensed under [AGPL-3.0](LICENSE.txt).

## Requirements

* PHP v7.2+
* CiviCRM 5.37+
## Installation (Web UI)

Learn more about installing CiviCRM extensions in the [CiviCRM Sysadmin Guide](https://docs.civicrm.org/sysadmin/en/latest/customize/extensions/).

## Installation (CLI, Zip)

Sysadmins and developers may download the `.zip` file for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
cd <extension-dir>
cv dl ca.sdda.trialadmin@https://github.com/cub69/ca.sdda.trialadmin/archive/master.zip
```

## Installation (CLI, Git)

Sysadmins and developers may clone the [Git](https://en.wikipedia.org/wiki/Git) repo for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
git clone https://github.com/cub69/ca.sdda.trialadmin.git
cv en trialadmin
```

## Getting Started

Once installed, it creates 2 new tables/entities in the database civicrm_trialadmin and civicrm_trialcomponents.  Go to Events, Manage, Settings and a new tab will be seen called Administration.  Under that tab it will display Trial details.  These details are specifically linked to the event, which is created by the application process. 

## Known Issues

Initial commit has issues with edit/add of individual components at the bottom of the Administration page.
