<?php
/* Smarty version 3.1.30, created on 2026-05-01 16:06:53
  from "C:\xampp\htdocs\cse\project_farm-master\project_farm-master\views\v_products.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_69f4b37d8b5999_54951450',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3496824f9e6a9ab5ae3f4afbfbcff2997eaa7c84' => 
    array (
      0 => 'C:\\xampp\\htdocs\\cse\\project_farm-master\\project_farm-master\\views\\v_products.tpl',
      1 => 1777643816,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_69f4b37d8b5999_54951450 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="global indent">
    <!--content-->
    <div class="container1 padTop">
    <div class="container">
        <div class="row">
            <article class="col-lg-12 col-md-12 col-sm-12 servBox">
                <h2>Products</h2>
                <div class="row">
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['products']->value, 'product');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['product']->value) {
?>                
                    <article class="col-lg-4 col-md-4 col-sm-4 col-xs-6 maxheight margBot">
                        <div class="thumb-pad7">
                            <div class="thumbnail">
                                <figure><img src="public/img/<?php echo $_smarty_tpl->tpl_vars['product']->value->image;?>
" alt="<?php echo $_smarty_tpl->tpl_vars['product']->value->title;?>
"></figure>
                                <div class="caption">
                                    <p class="title w3-center"><a href="<?php echo thu_vien::Bo_dau($_smarty_tpl->tpl_vars['product']->value->title);?>
-<?php echo $_smarty_tpl->tpl_vars['product']->value->id;?>
.htm" class="w3-text-black w3-hover-text-orange w3-large hidden_text"><?php echo $_smarty_tpl->tpl_vars['product']->value->title;?>
</a></p>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                </div>
            </article>
            <div class="pagination" style="font-size:15px">
                <?php echo $_smarty_tpl->tpl_vars['paginate']->value;?>

            </div>
        </div>
    </div>
    </div>
</div><?php }
}
