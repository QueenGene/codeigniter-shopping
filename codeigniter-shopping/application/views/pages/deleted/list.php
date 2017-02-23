<h1><strong>The Shop</strong></h1>
<p><strong>Buy here and live longer</strong></p>
    <div>
        <span></span>
    </div>

<br>
<?php // Create a flash for successes
if ($this->session->flashdata('success')): ?>
    <div>
        <i style="color: red;"><?php echo $this->session->flashdata('success'); ?></i>
    </div>
<?php endif; ?>

<?php // Create a flash for errors
if ($this->session->flashdata('error')): ?>
    <div>
        <i style="color: red;"><?php echo $this->session->flashdata('error'); ?></i>
    </div>
<?php endif; ?>
<br>
