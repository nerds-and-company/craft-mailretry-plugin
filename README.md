# Mail Retry plugin for Craft CMS 2.x

Retry mails in background when they fail

## Requirements

This plugin requires Craft CMS 2.0.0 or later.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require nerds-and-company/craft2-mail-retry

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for Mail Retry.

## Mail Retry Overview

When a mail fails for some reason, f.e. when the mail server is unavailable, a job is created to retry the mail.

## Using Mail Retry

When a mail fails a task will be generated to immediately retry the mail once.
If it does not work then the task can be retried manually later.

Brought to you by [Nerds & Company](nerds.company)
