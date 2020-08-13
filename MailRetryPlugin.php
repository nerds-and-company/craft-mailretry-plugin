<?php

/**
 * Mail Retry plugin for Craft CMS 2.x
 *
 * Retry mails in background when they fail
 *
 * @link      https://nerds.company
 * @copyright Copyright (c) 2020 Nerds & Company
 */
namespace Craft;

/**
 * Class MailRetry
 *
 * @author    Nerds & Company
 * @package   MailRetry
 * @since     1.0.0
 *
 */
class MailRetryPlugin extends BasePlugin
{
    /**
     * Return plugin name.
     *
     * @return string
     */
    public function getName()
    {
        return Craft::t('MailRetry');
    }

    /**
     * Return plugin version.
     *
     * @return string
     */
    public function getVersion()
    {
        return '1.0.0';
    }

    /**
     * Return plugin schema version.
     *
     * @return string
     */
    public function getSchemaVersion()
    {
        return '1.0.0';
    }

    /**
     * Return plugin developer.
     *
     * @return string
     */
    public function getDeveloper()
    {
        return 'Nerds & Company';
    }

    /**
     * Return plugin developer url.
     *
     * @return string
     */
    public function getDeveloperUrl()
    {
        return 'https://nerds.company';
    }

    /**
     * Initialize plugin.
     */
    public function init()
    {
        parent::init();

        craft()->on('email.onSendEmailError', function (Event $event) {
            $isMailRetryAttempt = $event->params['variables']['mailRetryAttempt'] ?? false;

            if (!$isMailRetryAttempt) {
                $emailModel = $event->params['emailModel'];
                $description = Craft::t('Retry sending mail: {subject}', ['subject' => $emailModel->subject]);
                craft()->tasks->createTask('MailRetry', $description, array(
                    'emailModel' => serialize($event->params['emailModel']),
                    'variables' => serialize($event->params['variables'])
                ));
            }
        });
    }
}
