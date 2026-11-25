<?php
/* Smarty version 3.1.30, created on 2026-05-01 16:06:50
  from "C:\xampp\htdocs\cse\project_farm-master\project_farm-master\views\v_about.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_69f4b37a76eec5_67349040',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '65b8c197db8fe634df9ee4eea9a9df9e65181bf2' => 
    array (
      0 => 'C:\\xampp\\htdocs\\cse\\project_farm-master\\project_farm-master\\views\\v_about.tpl',
      1 => 1777643816,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_69f4b37a76eec5_67349040 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="global indent">
    <!--content-->
    <div class="container1 padTop">
    <div class="container">
        <div class="row">
            <article class="col-lg-4 col-md-4 col-sm-4">
                    <div class="thumb-pad3">
                        <div class="thumbnail">
                            <figure><img src="public/img/<?php echo $_smarty_tpl->tpl_vars['image']->value;?>
" alt="logo"></figure>
                        </div>
                    </div>
            </article>
            <article class="col-lg-8 col-md-8 col-sm-8">
                <h2><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</h2>
                <div class="caption">
                    <p><?php echo $_smarty_tpl->tpl_vars['content']->value;?>
</p>
                </div>
            </article>
        </div>
    </div>
</div><?php }
}
