<?php
namespace Craft;

/**
 * Class MailRetryTask
 *
 * @author    Nerds & Company
 * @package   MailRetry
 * @since     1.0.0
 *
 */
class MailRetryTask extends BaseTask
{
	/**
	 * @inheritdoc
	 */
	public function getDescription()
	{
        return Craft::t('MailRetry');
	}

	/**
	 * @inheritdoc
	 */
	public function getTotalSteps()
	{
		return 1;
	}

	/**
	 * @inheritdoc
	 */
	public function runStep($step)
	{
        $emailModel = unserialize($this->getSettings()->emailModel);
        $variables = unserialize($this->getSettings()->variables);
        $variables['mailRetryAttempt'] = true;
        if (!$emailModel->toEmail && $variables['user']) {
            $emailModel->toEmail = $variables['user']->email;
        }

        $this->setSettings([
            'emailModel' => serialize($emailModel),
            'variables' => serialize($variables)
        ]);

        $oldTemplateMode = craft()->templates->getTemplateMode();
        craft()->templates->setTemplateMode(TemplateMode::CP);
        $success = craft()->email->sendEmail($emailModel, $variables);
        craft()->templates->setTemplateMode($oldTemplateMode);
        return $success;
    }

	/**
	 * @inheritdoc
	 */
	protected function defineSettings()
	{
		return array(
            'variables' => AttributeType::Mixed,
            'emailModel' => AttributeType::Mixed
		);
    }
}
