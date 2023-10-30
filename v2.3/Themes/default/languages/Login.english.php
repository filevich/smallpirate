<?php
// Version 2.3; Login
$txt[37] = 'You Have To Write An Username.';
$txt[38] = 'Write your password.';
$txt[39] = 'Wrong password';
$txt[98] = 'Select your username';
$txt[155] = 'Maintenance mode';
$txt[245] = 'Succesfully registered';
$txt[431] = 'Congratulations! Now You Are A Member.';
$txt[492] = 'And Your Password Is';
$txt[500] = 'Please Enter A Valid Email. (%s)';
$txt[517] = 'Required Information';
$txt[520] = 'You can use different characters once that you have registeres, changing your name in your profile.';
$txt[585] = 'I agree';
$txt[586] = "I disagree";
$txt[633] = 'Warning!';
$txt[634] = 'Only registered users can enter here.';
$txt[635] = 'please login below or click';
$txt[636] = '-Here-';
$txt[637] = 'To register in ' . $context['forum_name'] . '.';
$txt[701] = 'you can change it later,in your profile or visiting this section after you login:';
$txt[719] = 'Your Username Is: ';
$txt[730] = 'That email (%s)is being used in another account.';

$txt['login_hash_error'] = 'The scheme for the security of passwords has been updated recently. Please enter your password again.';

$txt['register_age_confirmation'] = 'I have at least %d years';

// Use numeric entities in the below six strings.
$txt['register_subject'] = 'Welcome To ' . $context['forum_name'];

// For the below three messages, %1$s is the display name, %2$s is the username, %3$s is the password, %4$s is the activation code, and %5$s is the activation link (the last two are only for activation.)
$txt['register_immediate_message'] = 'you have registered an account in  ' . $context['forum_name'] . ', %1$s!' . "\n\n" . 'your username is %2$s the password is %3$s.' . "\n\n" . 'you can change your account later, visiting your profile:' . "\n\n" . $scripturl . '?action=profile' . "\n\n" . $txt[130];
$txt['register_activate_message'] = 'you have registered an account in ' . $context['forum_name'] . ', %1$s!' . "\n\n" . 'your username is %2$s the password is %3$s (can be changed later.)' . "\n\n" . 'before login you have to activate your account. to do that follow this link:' . "\n\n" . '%5$s' . "\n\n" . 'if you have problems with the mail try using the code"%4$s".' . "\n\n" . $txt[130];
$txt['register_pending_message'] = 'your registry petition in  ' . $context['forum_name'] . ' has been recieved, %1$s.' . "\n\n" . 'the username that you used to register was: %2$s and the password was %3$s.' . "\n\n" . 'before your login your account has to be checked and proccessed.  Cuando esto suceda, recibir&#225;s otro email desde esta direcci&#243;n.' . "\n\n" . $txt[130];

// For the below two messages, %1$s is the user's display name, %2$s is their username, %3$s is the activation code, and %4$s is the activation link (the last two are only for activation.)
$txt['resend_activate_message'] = 'you  registered and account in ' . $context['forum_name'] . ', %1$s!' . "\n\n" . 'your username is  "%2$s".' . "\n\n" . 'before entering you have to activate the account. to do that use this link:' . "\n\n" . '%4$s' . "\n\n" . 'In case that you have any problem use the code "%3$s".' . "\n\n" . $txt[130];
$txt['resend_pending_message'] = 'your registry in ' . $context['forum_name'] . ' has been recieved, %1$s.' . "\n\n" . 'your username is %2$s.' . "\n\n" . 'before you can use everything your account has to be approved.  when this happens you will recieve another email from.' . "\n\n" . $txt[130];

$txt['ban_register_prohibited'] = 'sorry you are not allowed to register in this forum';
$txt['under_age_registration_prohibited'] = 'sorry,this forum does not allow persons below %d years to register';

$txt['activate_account'] = 'Account activation';
$txt['activate_success'] = 'your account was activated succesfully. now you can login in the forum.';
$txt['activate_not_completed1'] = 'your account has to be activated before anything else.';
$txt['activate_not_completed2'] = 'Do you need another activation email?';
$txt['activate_after_registration'] = 'Thanks for registering. soon you will recieve a message to activate your accounr. if after some time you don\'t recieve anything, check your spam section.';
$txt['invalid_userid'] = 'That user does not exists';
$txt['invalid_activation_code'] = 'Invalid activation code';
$txt['invalid_activation_username'] = 'Username or email';
$txt['invalid_activation_new'] = 'if you registered with a wrong email, write a new one here with your password.';
$txt['invalid_activation_new_email'] = 'New email';
$txt['invalid_activation_password'] = 'Old password';
$txt['invalid_activation_resend'] = 'Resend activation code';
$txt['invalid_activation_known'] = 'If you now your activation code,write it here.';
$txt['invalid_activation_retry'] = 'Activation Code';
$txt['invalid_activation_submit'] = 'Activar';

$txt['coppa_not_completed1'] = 'El administrador no ha recibido a&uacute;n el consentimiento de tus padres/tutor para tu cuenta.';
$txt['coppa_not_completed2'] = 'Do you need more details?';

$txt['awaiting_delete_account'] = 'Your account is waiting to be deleted!<br />to restore your account, por favor selecciona la casilla &quot;Reactivar mi cuenta&quot;, e ingresa nuevamente.';
$txt['undelete_account'] = 'Undelete my account';

$txt['change_email_success'] = 'Your email has changed, a new activation mail has been setn.';
$txt['resend_email_success'] = 'A new activation mail was sent succesfully.';
$txt['change_password'] = 'details of the new password';
$txt['change_password_1'] = 'Your details to login are';
$txt['change_password_2'] = 'han sido cambiados y tu contrase&#241;a ha sido reinicializada. Debajo est&#225;n tus nuevos datos para ingresar.';

$txt['maintenance3'] = 'This forum is under maintenance.';

$txt['approval_after_registration'] = 'Gracias por registrarte. El administrador debe aprobar tu registro antes de que puedas empezar a usar tu cuenta, recibir&aacute;s un email a la brevedad posible notific&aacute;ndote de la decisi&oacute;n del administrador.';

$txt['admin_settings_desc'] = 'here you can change some things about the registration of the users.';
// Admin
$txt['admin_setting_registration_method'] = 'Registration method used for new users';
$txt['admin_setting_registration_disabled'] = 'registration disabled';
$txt['admin_setting_registration_standard'] = 'registration in time';
$txt['admin_setting_registration_activate'] = 'user activation';
$txt['admin_setting_registration_approval'] = 'user approval';
$txt['admin_setting_notify_new_registration'] = 'Notify admins when a new user registers';
$txt['admin_setting_send_welcomeEmail'] = 'Mandar email de bienvenida a los nuevos usuarios';

$txt['admin_setting_password_strength'] = 'Robustness required for the passwords';
$txt['admin_setting_password_strength_low'] = 'Low - at least 4 characters';
$txt['admin_setting_password_strength_medium'] = 'Medium - can not contain the user name';
$txt['admin_setting_password_strength_high'] = 'High - Use different characters';

$txt['admin_setting_image_verification_type'] = 'Complexity of the visual verification image';
$txt['admin_setting_image_verification_type_desc'] = 'The more complex the image the more difficult the access of bots';
$txt['admin_setting_image_verification_off'] = 'Off';
$txt['admin_setting_image_verification_vsimple'] = 'Very Low - plane text in image ';
$txt['admin_setting_image_verification_simple'] = 'Low - Characters interspersed colored, without interference';
$txt['admin_setting_image_verification_medium'] = 'Media - color letters interspersed with interference';
$txt['admin_setting_image_verification_high'] = 'Alta - letters angled, with much interference';
$txt['admin_setting_image_verification_sample'] = 'Example';
$txt['admin_setting_image_verification_nogd'] = '<b>Nota:</b> Because this server does not have the GD library installed the different values of the complexity can not be used.';

$txt['admin_setting_coppaAge'] = 'Age below which apply restrictions on the registration';
$txt['admin_setting_coppaAge_desc'] = '(0 Means Disabled)';
$txt['admin_setting_coppaType'] = 'what will happen if a user is that is below the age is trying to register';
$txt['admin_setting_coppaType_reject'] = 'Reject registration';
$txt['admin_setting_coppaType_approval'] = 'ask for an approvation(parents/tutors)';
$txt['admin_setting_coppaPost'] = 'Address to which authorization should be sent';
$txt['admin_setting_coppaPost_desc'] = 'Only applies when the age restriction is on';
$txt['admin_setting_coppaFax'] = 'fax number where the activation letters will be sent';
$txt['admin_setting_coppaPhone'] = 'phone umber where parents/tutors can call for more information about age restrictions and other things';
$txt['admin_setting_coppa_require_contact'] = 'you have to give your email, this in case that the approval of parents/tutors have to be done';

$txt['admin_register'] = 'Register Of A New User';
$txt['admin_register_desc'] = 'From here you can register new users in the forum and, if desired, send their details by email.';
$txt['admin_register_username'] = 'new name';
$txt['admin_register_email'] = 'new email';
$txt['admin_register_password'] = 'password';
$txt['admin_register_username_desc'] = 'Username for the new user';
$txt['admin_register_email_desc'] = 'user email<br />(requiered if you selected to send by email the information)';
$txt['admin_register_password_desc'] = 'New password for the user';
$txt['admin_register_email_detail'] = 'Send the new password by email';
$txt['admin_register_email_detail_desc'] = 'the email is necessary';
$txt['admin_register_email_activate'] = 'Ask the user to activate the account';
$txt['admin_register_group'] = 'Primary membergroup';
$txt['admin_register_group_desc'] = 'principal group,where the user will be in;';
$txt['admin_register_group_none'] = '(no principal membergroup)';
$txt['admin_register_done'] = 'the user %s has been registered succesfully!';

$txt['admin_browse_register_new'] = 'Register A New User';

// Use numeric entities in the below three strings.
$txt['admin_notify_subject'] = 'A new user has been subscrit';
$txt['admin_notify_profile'] = '%s has signed as a new member. <i>click</i> in the link to see your profile.';
$txt['admin_notify_approval'] = 'before posting your account has to be approved.<i>click</i> in the next link to go to the approvation page.';

$txt['coppa_title'] = 'Age Restriction Forum';
$txt['coppa_after_registration'] = 'Thanks For Registering In ' . $context['forum_name'] . '.<br /><br />Because you are under the age of {MINIMUM_AGE}, You Have to have permission of your father or tutor, before being activated your account:';
$txt['coppa_form_link_popup'] = 'Load Form In Another Window';
$txt['coppa_form_link_download'] = 'Download Form';
$txt['coppa_send_to_one_option'] = 'then ask your parents/tutor to fill the form and then send it:';
$txt['coppa_send_to_two_options'] = 'then ask your parents/tutor to fill the form and send it in this two options:';
$txt['coppa_send_by_post'] = 'Email:';
$txt['coppa_send_by_fax'] = 'Fax, With The Number:';
$txt['coppa_send_by_phone'] = 'Otherwise try calling to this phone: {PHONE_NUMBER}.';

$txt['coppa_form_title'] = 'Permission Form ' . $context['forum_name'];
$txt['coppa_form_address'] = 'Address';
$txt['coppa_form_date'] = 'Date';
$txt['coppa_form_body'] = 'I {PARENT_NAME},<br /><br />Give Permission To Mi Child {CHILD_NAME} (child name) To Become A Member Of This Website With The Username : {USER_NAME}.<br /><br />I Undestand That Some Info Showed By {USER_NAME} May Be Showed To Other Persons.<br /><br />Signed By:<br />{PARENT_NAME} (Parent/Tutor).';
// Visual Verification
$txt['visual_verification_label'] = 'Visual Verification';
$txt['visual_verification_description'] = 'Write The Code Of The Image';
$txt['visual_verification_sound'] = 'Listen To The Letters';
$txt['visual_verification_sound_again'] = 'Sound Again';
$txt['visual_verification_sound_close'] = 'Close Window';
$txt['visual_verification_request_new'] = 'Request A New Image';
$txt['visual_verification_sound_direct'] = 'Problems Hearing,Use The Link.';

$txt['reg_alert1'] = 'Write A Nick.';
$txt['reg_alert2'] = 'Write A Password.';
$txt['reg_alert3'] = 'Comfirm Your Password.';
$txt['reg_alert4'] = 'Write Your Email.';
$txt['reg_alert5'] = 'DIn Which Country Do You Live.';
$txt['reg_alert6'] = 'In Which City Do You Live?.';
$txt['reg_alert7'] = 'Write The Day Of Your Birth.';
$txt['reg_alert8'] = 'Write The Month Of Your Birth.';
$txt['reg_alert9'] = 'Write The Year Of Your Birth.';
$txt['reg_alert10'] = 'Write The Code Of The Image.';
$txt['reg_alert11'] = 'The Passwords Do Not Match.';
$txt['reg_alert12'] = 'You Have To Accept The Terms And Conditions.';
$txt['Registro_en_foro'] = 'Register in ' . $context['forum_name'];
$txt['Nick'] = 'Nick:';
$txt['Password'] = 'Password:';
$txt['confirmar_Password'] = 'Confirm Password:';
$txt['Email'] = 'E-mail:';
$txt['pais'] = 'Country:';
$txt['pais'] = 'Country:';
$txt['Ciudad'] = 'City:';
$txt['Fecha_nacimiento'] = 'Birthday:';
$txt['dia_mes_ano'] = '&#40;Day&#47;Month&#47;Year&#41;';
$txt['Sitio_Web'] = 'Web Site / Blog:';
$txt['Mensaje_personal'] = 'Personal Message:';
$txt['Avatar'] = 'Avatar';
$txt['Captcha'] = 'Code';
$txt['Refresh'] = '(refresh)';
$txt['Acepto_terminos'] = 'I agree with the terms and conditions';

$txt['Aclaracion_registro'] = 'Clarification about the registration';
$txt['Destacados'] = 'Featured';
$txt['activar'] = 'Now you only have to activate your account';
$txt['Campos_obligatorios'] = 'Required fields';

$txt['Mensaje_aclaracion'] = 'User registration is unlimited. By registering you will have access to all
the posts. You can also create your own posts, that will be published,
so that all users can see. <br>
When you have your own account you will have a membergroup, if you move up you will get more and more permissions on the Web.
To reach the maximum membergroup you must get 150 post (topics)[Depending On The Website].
We give the user highlights a special status that is a membergroup Called "VIP Member"
which has even more permissions than the others.
<br><br>Muchas gracias.<br><br></font><font class="size9">IMPORTANT: All The Spaces With (*)Are Needed</font>';

$txt['Seleccionar_pais'] = 'Select Your Country:';

$txt['Pais1'] = 'Argentina';
$txt['Pais2'] = 'Bolivia';
$txt['Pais3'] = 'Brasil';
$txt['Pais4'] = 'Chile';
$txt['Pais5'] = 'Colombia';
$txt['Pais6'] = 'Costa Rica';
$txt['Pais7'] = 'Cuba';
$txt['Pais8'] = 'Ecuador';
$txt['Pais9'] = 'Spain';
$txt['Pais10'] = 'Guatemala';
$txt['Pais11'] = 'Italy';
$txt['Pais12'] = 'Mexico';
$txt['Pais13'] = 'Paraguay';
$txt['Pais14'] = 'Peru';
$txt['Pais15'] = 'Portugal';
$txt['Pais16'] = 'Puerto Rico';
$txt['Pais17'] = 'Uruguay';
$txt['Pais18'] = 'Venezuela';
$txt['Pais19'] = 'Another';

?>