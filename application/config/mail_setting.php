<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * smtp credentials used
 */
$config['protocal']='sendmail';
$config['smtp_host']='smtp.mailgun.org';
$config['port']=587;
$config['smtp_user']='postmaster@mail.iconpreparation.com';
$config['smtp_pass']='3f17d564ae63bf6ac197a5de35b2381d-4534758e-b90b8473';
//if smtp not used
$config['mailpath'] = '/usr/sbin/sendmail';
