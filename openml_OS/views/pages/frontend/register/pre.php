<?php
$this->active = 'profile';
$this->message = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

$this->emailField = array(
	'placeholder' => 'Email',
	'data-hint' => 'You will occasionally receive account related emails. We promise not to share your email with anyone.',
	'name' => 'email',
	'id' => 'email',
	'type' => 'email',
	'value' => $this->input->post('email'),
);

$this->password = array(
	'placeholder' => 'Password',
	'data-hint' => 'Your password needs at least 8 characters',
	'name' => 'password',
	'id' => 'password',
	'type' => 'password',
);

$this->password_confirm = array(
	'placeholder' => 'Password confirm',
	'name' => 'password_confirm',
	'id' => 'password_confirm',
	'type' => 'password',
);

$this->first_name = array(
	'placeholder' => 'First name',
	'data-hint' => 'Using your real name helps you connect to your social network (and your publications).',
	'name' => 'first_name',
	'id' => 'first_name',
	'type' => 'text',
	'value' => $this->input->post('first_name'),
);

$this->last_name = array(
	'placeholder' => 'Last name',
	'name' => 'last_name',
	'id' => 'last_name',
	'type' => 'text',
	'value' => $this->input->post('last_name'),
);

$this->country = array(
	'placeholder' => 'Country',
	'name' => 'country',
	'id' => 'country',
	'type' => 'text',
	'value' => $this->input->post('country'),
);

$this->bio = array(
	'placeholder' => 'Bio',
	'data-hint' => 'A short bio or catchphrase to let others know a little bit about you.',
	'name' => 'bio',
	'id' => 'bio',
	'type' => 'text',
	'value' => $this->input->post('bio'),
);

$this->affiliation = array(
	'placeholder' => 'Affiliation',
	'data-hint' => 'The organization where you work. This may help you connect to interesting people.',
	'name' => 'affiliation',
	'id' => 'affiliation',
	'type' => 'text',
	'value' => $this->input->post('affiliation'),
);

$this->image = array(
	'placeholder' => 'Upload picture...',
	'data-hint' => 'Upload a nice image or avatar.',
	'name' => 'image',
	'id' => 'image',
	'type' => 'file',
);
?>
