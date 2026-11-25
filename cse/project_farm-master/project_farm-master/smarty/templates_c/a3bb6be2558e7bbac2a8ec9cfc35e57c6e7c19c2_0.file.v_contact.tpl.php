<?php
/* Smarty version 3.1.30, created on 2026-05-01 16:07:03
  from "C:\xampp\htdocs\cse\project_farm-master\project_farm-master\views\v_contact.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_69f4b3873ed482_09754113',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a3bb6be2558e7bbac2a8ec9cfc35e57c6e7c19c2' => 
    array (
      0 => 'C:\\xampp\\htdocs\\cse\\project_farm-master\\project_farm-master\\views\\v_contact.tpl',
      1 => 1777643816,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_69f4b3873ed482_09754113 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="global indent">
    <!--content-->
    <div class="container1 padTop">
    <div class="container">
        <div class="row">
            <article class="col-lg-12 col-md-12 col-sm-12">
                <figure class="map"><?php echo $_smarty_tpl->tpl_vars['google_map']->value;?>
</figure>
            </article>
            <section class="formBox clearfix">
                <article class="col-lg-12 col-md-12 col-sm-12 info">
                    <h3>Contact Name: 
                        <strong><?php echo $_smarty_tpl->tpl_vars['contact_name']->value;?>
</strong>
                    </h3>
                    <h3>Position: 
                        <strong><?php echo $_smarty_tpl->tpl_vars['position']->value;?>
</strong>
                    </h3>
                   <h3>Address: 
                        <strong class="w3-hover-text-orange"><?php echo $_smarty_tpl->tpl_vars['address']->value;?>
</strong>
                   </h3>
                    <h3>Phone number: 
                        <strong><a href="tel:<?php echo $_smarty_tpl->tpl_vars['phone_number']->value;?>
" class="w3-hover-text-orange"><?php echo $_smarty_tpl->tpl_vars['phone_number']->value;?>
</a></strong>
                    </h3>
                    <h3>E-mail: 
                        <strong><a href="mailto:<?php echo $_smarty_tpl->tpl_vars['email']->value;?>
" target="_top"  class="w3-text-black w3-hover-text-orange"> <?php echo $_smarty_tpl->tpl_vars['email']->value;?>
</a></strong>
                    </h3>
               </article>
            </section>
        </div>
    </div>
    </div>
</div><?php }
}
