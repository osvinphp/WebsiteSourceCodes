<aside id="sidebar" class="sidebar c-overflow">
    
    <?php //$this->load->view('layout/profile-bar'); ?>

    <?php $this->load->view('layout/sidebar/' . strtolower($this->currentUser->get('roleName'))); ?>
    
</aside>