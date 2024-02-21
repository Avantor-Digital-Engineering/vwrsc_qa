<?php

/**
 * @file
 * Admin page callback file for the workflow tool module.
 */

/**
 * Form builder; Configure workflow email settings for this site.
 *
 * @ingroup forms
 * @see system_settings_form()
 */
function workflow_tool_admin_settings() {
  // Settings for anonymous users.
  $form['email_settings'] = array(
    '#type' => 'fieldset',
    '#title' => t('Email'),
  );
  $form['email_settings']['incoming_mail_details'] = array(
    '#type' => 'textfield',
    '#title' => t('Incoming Mail'),
    '#default_value' => variable_get('incoming_mail_details', ''),
    '#description' => t('Incoming mail details for the mailbox, e.g. imap.gmail.com:993/imap/ssl'),
    '#required' => TRUE,
  );
  $form['email_settings']['account_name'] = array(
    '#type' => 'textfield',
    '#title' => t('Account Name'),
    '#default_value' => variable_get('account_name', ''),
    '#description' => t('Account name for the mailbox, e.g. vwr'),
    '#required' => TRUE,
  );
  $form['email_settings']['submission_reply_to'] = array(
    '#type' => 'textfield',
    '#title' => t('Reply To'),
    '#default_value' => variable_get('submission_reply_to', ''),
    '#description' => t('Submission reply to for the mailbox, e.g. workflow@vwrsuppliercentral.com'),
    '#required' => TRUE,
  );
  $form['email_settings']['account_password'] = array(
    '#type' => 'textfield',
    '#title' => t('Account Password'),
    '#default_value' => variable_get('account_password', ''),
    '#description' => t('Account password for the mailbox'),
    '#required' => TRUE,
  );
  $form['email_settings']['contact_mail'] = array(
    '#type' => 'textfield',
    '#title' => t('Contact Mail'),
    '#default_value' => variable_get('contact_mail', ''),
    '#description' => t('Contact mail for the replies'),
    '#required' => TRUE,
  );
  return system_settings_form($form);
}