<?php
/* Smarty version 3.1.30, created on 2026-05-01 16:06:40
  from "C:\xampp\htdocs\cse\project_farm-master\project_farm-master\smarty\templates\header.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_69f4b370d82c13_21758682',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '737ffd05668bf7354361b28fb5fae373df6624a7' => 
    array (
      0 => 'C:\\xampp\\htdocs\\cse\\project_farm-master\\project_farm-master\\smarty\\templates\\header.tpl',
      1 => 1777643816,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_69f4b370d82c13_21758682 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!--header-->
<header>
    <div class="container">
        <h1 class="navbar-brand navbar-brand_">
            <a href="."><img src="public/img/<?php echo $_smarty_tpl->tpl_vars['logo']->value;?>
" alt=""></a>
        </h1>
        <div>
            <p>24/7 Support: <span><a href="tel:<?php echo $_smarty_tpl->tpl_vars['phone_number']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['phone_number']->value;?>
</a></span></p>
            <nav class="navbar navbar-default navbar-static-top tm_navbar clearfix" role="navigation">
                <ul class="nav sf-menu clearfix">
                    <li class="active"><a href=".">Home</a><em></em></li>
                    <li><a href="about.htm">About us</a><em></em></li>
                    <li><a href="products.htm">Products</a><em></em></li>
                    <li><a href="check.htm">Check order</a></li>
                    <li><a href="contact.htm">Contacts</a></li>
                </ul>
            </nav>
        </div>
    </div>
</header><?php }
}
