<html>
	<body>
		<!--<h1><?php echo sprintf(lang('email_activate_heading'), $identity);?></h1>
		<p><?php echo sprintf(lang('email_activate_subheading'), anchor('auth/activate/'. $id .'/'. $activation, lang('email_activate_link')));?></p>-->

		<h1>Hai, Selamat Bergabung di Loqasi.com</h1>
		<p><a href="<?php echo base_url('auth/activate/'. $id .'/'. $activation); ?>">Klik disini untuk mengaktifkan akun kamu yaa</a></p>
	</body>
</html>