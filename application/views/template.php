<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo isset($page_title) ? $page_title.' | Dashboard' : 'Dashboard'; ?></title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url('sb-admin-2/vendor/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo base_url('sb-admin-2/vendor/metisMenu/metisMenu.min.css'); ?>" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url('sb-admin-2/dist/css/sb-admin-2.css'); ?>" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="<?php echo base_url('sb-admin-2/vendor/morrisjs/morris.css'); ?>" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url('sb-admin-2/vendor/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css">

    <style type="text/css">
        /*### bootstrap overwrite ###*/
        .row.row2{margin-right:-2px;margin-left:-2px;}
        .row.row2>div{padding-left:2px;padding-right:2px;}
        .row.row5{margin-right:-5px;margin-left:-5px;}
        .row.row5>div{padding-left:5px;padding-right:5px;}
        .row.row75{margin-right:-7.5px;margin-left:-7.5px;}
        .row.row75>div{padding-left:7.5px;padding-right:7.5px;}
        .row.row10{margin-right:-10px;margin-left:-10px;}
        .row.row10>div{padding-left:10px;padding-right:10px;}

        label{font-weight:400;}

        .panel-default>.panel-heading{display:table;width:100%;font-size:18px;}
        .panel-default>.panel-heading>.heading-title,.panel-default>.panel-heading>.actions{display:table-cell;vertical-align:middle;}
        .panel-default>.panel-heading>.actions{float:right;}
        .panel-body:empty{padding:0;}

        /*# common #*/
        .mb0{margin-bottom:0!important;}

        /*# popup #*/
        #overlay{z-index:99999;width:100%;height:100%;position:fixed;top:0;left:0;background:#000;opacity:.4;filter:alpha(opacity=50);}
        .loader{background:url(../sb-admin-2/images/loader.gif) no-repeat;background-size:30px;position:absolute;width:30px;height:30px;}


        /*# product and categories #*/
        .categories ul{margin:0px;padding:0px;}
        .categories li{display:block;}
        .categories li.submenu ul{margin-left:15px;}
        .form-group.categories{max-height:250px;overflow:auto;}

        /*# product gallery #*/
        .imgbox{text-align:center;margin-bottom:10px;position:relative;}
        .imgbox p{text-transform:uppercase;}
        .imgbox input[type=file]{position:absolute;left:-99999999px;}
        .imgbox .selectimage{background:#eee;height:50px;width:100%;border:1px dashed #ffbebe;overflow:hidden;cursor:pointer;}
        .imgbox .selectimage .previewing{background:url(../images/upload-photo.png) no-repeat center;}
        .imgbox .selectimage img{width:auto;}
        .imgbox .close-product-gallery{background:#d00;color:#fff;text-align:center;font-weight:bold;font-size:11px;height:15px;width:15px;border-radius:50%;position:absolute;right:0;top:0;}
        .imgbox img{width:100%;}
        .imgbox.fullbox .selectimage{height:150px;width:100%;}
        .add-more-gallery{display:block;}

        /*# product variations #*/
        .panel-heading .add_variation{font-size:14px;}
        .variations .variation{border:1px solid #e6e6e6;margin:0;border-radius:3px;}
        .variations .variation+.variation{margin-top:5px;}
        .variations .variation>h3{cursor:pointer;margin:0;padding:15px;}
        .variations .variation>h3 .handlediv{width:30px;display:block;float:right;cursor:pointer;color:#72777c;line-height:1.2em;text-align:center;}
        .variations .variation>h3:hover .handlediv{visibility:visible;}
        .variations .variation>h3 .handlediv::before{content:"\f0d7";font:normal normal normal 14px/1 FontAwesome;line-height:0;}
        .variations .variation.open>h3 .handlediv::before{content:"\f0d8";font:normal normal normal 14px/1 FontAwesome;line-height:0;}
        .variations .variation>h3 a.remove_variation {color:red;font-weight:400;font-size:14px;line-height:26px;text-decoration:none;position:relative;margin-top:.25em;float:right;}
        .variations .variation>h3 strong{line-height:26px;font-weight:700;font-size:14px;cursor:pointer;color:#23282d;}
        .variations .variation>h3 select{max-width:20%;margin:.25em .25em .25em 0;font-weight:400;padding:2px;line-height:28px;height:28px;vertical-align:middle;display:inline-block;}

        .variations .variation .attribute-content{padding:15px;border-top:1px solid #e6e6e6;}
    </style>
</head>
<body>
<div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo base_url(); ?>">PrestigeLab</a>
        </div>

        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-envelope fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-messages">
                    <li>
                        <a href="#">
                            <div>
                                <strong>John Smith</strong>
                                <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                            </div>
                            <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <strong>John Smith</strong>
                                <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                            </div>
                            <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <strong>John Smith</strong>
                                <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                            </div>
                            <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a class="text-center" href="#">
                            <strong>Read All Messages</strong>
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-tasks fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-tasks">
                    <li>
                        <a href="#">
                            <div>
                                <p>
                                    <strong>Task 1</strong>
                                    <span class="pull-right text-muted">40% Complete</span>
                                </p>
                                <div class="progress progress-striped active">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                        <span class="sr-only">40% Complete (success)</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <p>
                                    <strong>Task 2</strong>
                                    <span class="pull-right text-muted">20% Complete</span>
                                </p>
                                <div class="progress progress-striped active">
                                    <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                        <span class="sr-only">20% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <p>
                                    <strong>Task 3</strong>
                                    <span class="pull-right text-muted">60% Complete</span>
                                </p>
                                <div class="progress progress-striped active">
                                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                        <span class="sr-only">60% Complete (warning)</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <p>
                                    <strong>Task 4</strong>
                                    <span class="pull-right text-muted">80% Complete</span>
                                </p>
                                <div class="progress progress-striped active">
                                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                        <span class="sr-only">80% Complete (danger)</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a class="text-center" href="#">
                            <strong>See All Tasks</strong>
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-alerts">
                    <li>
                        <a href="#">
                            <div>
                                <i class="fa fa-comment fa-fw"></i> New Comment
                                <span class="pull-right text-muted small">4 minutes ago</span>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                <span class="pull-right text-muted small">12 minutes ago</span>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <i class="fa fa-envelope fa-fw"></i> Message Sent
                                <span class="pull-right text-muted small">4 minutes ago</span>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <i class="fa fa-tasks fa-fw"></i> New Task
                                <span class="pull-right text-muted small">4 minutes ago</span>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                <span class="pull-right text-muted small">4 minutes ago</span>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a class="text-center" href="#">
                            <strong>See All Alerts</strong>
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                    </li>
                    <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="login.html"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                </ul>
            </li>
        </ul>

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="sidebar-search">
                        <div class="input-group custom-search-form">
                            <input type="text" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                    </li>
<!--                    <li>-->
<!--                        <a href="#"><i class="fa fa-product-hunt"></i> Products<span class="fa arrow"></span></a>-->
<!--                        <ul class="nav nav-second-level">-->
<!--                            <li><a href="--><?php //echo base_url('product'); ?><!--">Products</a></li>-->
<!--                            <li><a href="--><?php //echo base_url('attribute'); ?><!--">Attribute</a></li>-->
<!--                            <li><a href="--><?php //echo base_url('category'); ?><!--">Categories</a></li>-->
<!--                        </ul>-->
<!--                    </li>-->
                    <li>
                        <a href="<?php echo base_url('users'); ?>"><i class="fa fa-dashboard fa-fw"></i> User</a>
                    </li>

                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <div id="page-wrapper">
        <?php echo isset($layout) ? $layout : null; ?>
    </div>
</div>

<!-- jQuery -->
<script src="<?php echo base_url('sb-admin-2/vendor/jquery/jquery.min.js'); ?>"></script>

<!-- Bootstrap Core JavaScript -->
<script src="<?php echo base_url('sb-admin-2/vendor/bootstrap/js/bootstrap.min.js'); ?>"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="<?php echo base_url('sb-admin-2/vendor/metisMenu/metisMenu.min.js'); ?>"></script>

<!-- Morris Charts JavaScript -->
<script src="<?php echo base_url('sb-admin-2/vendor/raphael/raphael.min.js'); ?>"></script>
<script src="<?php echo base_url('sb-admin-2/vendor/morrisjs/morris.min.js'); ?>"></script>
<script src="<?php echo base_url('sb-admin-2/data/morris-data.js'); ?>"></script>

<!-- Custom Theme JavaScript -->
<script src="<?php echo base_url('sb-admin-2/dist/js/sb-admin-2.js'); ?>"></script>

<script type="text/javascript">
    jQuery(document).ready(function()
    {
        jQuery('.the_name').on('input', function(){
            //alert('changed');
            var this_val = jQuery(this).val().toLowerCase();
            var this_val2 = jQuery(this).val().toLowerCase();
            this_val = this_val.replace(/\s/g,"-");

            var inputString = "~!@#$%^&*()_+=`{}[]|\:;'<>, "+this_val2,
                outputString = inputString.replace(/([~!@#$%^&*()_+=`{}\[\]\|\\:;'<>,.\/? ])+/g, '-').replace(/^(-)+|(-)+$/g,'');

            /*alert(outputString);*/
            jQuery('.the_slug').val(outputString);
        });


        /*### delte row confirmation ###*/
        function confirm_delete()
        {
            return confirm('Do you really want to delete?');
        }
    });


    /*### instant product file upload ####*/
    var $=jQuery;

    function imageIsLoaded(e)
    {
        $('.imgbox.active .previewing').html('<img src="'+e.target.result+'">');
        $(".imgbox").removeClass("active");
    };

    // on click file upload #
    $(document).ready(function(e)
    {
        // function to preview image after validation
        $("body").on('click', '.selectimage', function()
        {
            $(this).parent().find('input.prodimg').trigger("click");
            //$(this).parent().addClass("active");
        });

        $(function()
        {
            $("body").on('change', 'input.prodimg', function()
            {
                var file = this.files[0];
                var imagefile = file.type;
                var match= ["image/jpeg","image/png","image/jpg"];

                if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
                {
                    alert('Please select a valid image. Note: Only jpeg, jpg and png are allowed');
                    $(".imgbox").removeClass("active");
                    return false;
                }
                else
                {
                    $(this).parent().addClass("active");
                    var reader = new FileReader();
                    reader.onload = imageIsLoaded;
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    });

    // drag and drop file upload
    $(document).on('dragenter', '.imgbox', function()
    {
        //$(this).css('border', '3px dashed red');
        return false;
    });

    $(document).on('dragover', '.imgbox', function(e)
    {
        e.preventDefault();
        e.stopPropagation();
        //$(this).css('border', '3px dashed red');
        return false;
    });

    $(document).on('dragleave', '.imgbox', function(e)
    {
        e.preventDefault();
        e.stopPropagation();
        // $(this).css('border', '3px dashed #BBBBBB');
        return false;
    });

    $(document).on('drop', '.imgbox', function(e)
    {
        if(e.originalEvent.dataTransfer)
        {
            if(e.originalEvent.dataTransfer.files.length)
            {
                // stop the propagation of the event
                e.preventDefault();
                e.stopPropagation();

                //alert();
                //$(this).css('border', '3px dashed green');

                $(this).find('input.prodimg').prop("files", e.originalEvent.dataTransfer.files);
                $(this).addClass("active");

                //auto upload function
                //upload(e.originalEvent.dataTransfer.files);

                //function to preview image
                //$("input.prodimg").change(function()
                //{
                $("#message").empty();
                //var file = this.files[0];
                var file = e.originalEvent.dataTransfer.files[0];
                var imagefile = file.type;
                var match= ["image/jpeg","image/png","image/jpg"];

                if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
                {
                    $('#previewing').attr('src','noimage.png');
                    $("#message").html("<p id='error'>Please Select A valid Image File</p>"+"<h4>Note</h4>"+"<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
                    return false;
                }
                else
                {
                    var reader = new FileReader();
                    reader.onload = imageIsLoaded;
                    //reader.readAsDataURL(this.files[0]);
                    reader.readAsDataURL(file);
                }
                //});
            }
        }
        else
        {
            // $(this).css('border', '3px dashed #BBBBBB');
        }

        return false;
    });

    // add product image
    function add_product_image()
    {
        if(!jQuery('.panel-product-image>.panel-body .imgbox.fullbox').length)
        {
            var attribute_item_html = '<div class="imgbox fullbox"><div class="selectimage"><div class="previewing"></div></div><input type="file" name="product_image" class="prodimg"><a href="javascript:void(0)" class="close-product-gallery">x</a></div>';

            jQuery('.panel-product-image>.panel-body').prepend(attribute_item_html);

            jQuery('.panel-product-image .add-more-gallery').hide();
        }
        else
        {
            jQuery('.panel-product-image .add-more-gallery').show();
        }
    }

    // add more gallery
    function add_product_gallery_images()
    {
        var current_gallery_id = jQuery('#current_gallery_id').val();
        var next_current_gallery_id = parseInt(current_gallery_id) + 1;

        var attribute_item_html = '<div class="col-lg-3 imgbox"><div class="selectimage"><div class="previewing"></div></div><input type="file" name="product_gallery[]" class="prodimg"><a href="javascript:void(0)" class="close-product-gallery">x</a></div>';

        jQuery('.panel-product-gallery>.panel-body>.row.row5').append(attribute_item_html);

        jQuery('#current_gallery_id').val(next_current_gallery_id);
    }

    // remove gallery
    jQuery(document).ready(function()
    {
        jQuery('body, document').on('click', '.close-product-gallery', function()
        {
            var item_id = jQuery(this).attr('data-item-id');

            if(typeof item_id !== 'undefined')
            {
                jQuery.ajax({
                    url: "<?php echo base_url('product/close_product_gallery/'); ?>"+media_id
                });
            }

            jQuery(this).parent().remove();

            jQuery('.panel-product-image .add-more-gallery').show();
        });
    });

    // product variations | toggle show/hide
    jQuery('body').on('click', '.variations .variation>h3 .handlediv', function()
    {
        jQuery(this).parents('.variation').find('.attribute-content').slideToggle('slow', function()
        {
            jQuery(this).parents('.variation').toggleClass('open');
        });
    });

    // product variations | remove
    jQuery('body').on('click', '.variations .variation>h3 .remove_variation', function(e)
    {
        e.preventDefault();

        if(confirm('Are you sure to remove this variation?'))
        {
            var product_id = jQuery(this).attr('data-product-id');

            if(typeof product_id !== 'undefined')
            {
                // jQuery.ajax({
                //     url: "<?php echo base_url('attribute/close_attribute_item/'); ?>"+product_id
                // });
            }

            if(parseInt(jQuery('.variation').length) - 1 <= 0)
            {
                jQuery('.variations-panel .panel-body').html('');
                jQuery('.variations').remove();
            }

            jQuery(this).parents('.variation').remove();
        }

        return false;
    });

    // product variations | add to product
    jQuery('body').on('click', 'a.add_variation', function()
    {
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: "<?php echo base_url('product/add_variation'); ?>",
            data:
                {
                    'current_variation_total' : parseInt(jQuery('.variation').length)
                },
            beforeSend: function(data)
            {
                jQuery('body').append('<div id="overlay"></div>');

                jQuery('#overlay').append('<span class="loader" style="background-size:100px;position:absolute;width:50px;height:50px;left:50%;top:50%;border-radius:50%;background-position:-26px -3px;"></span>');
            },
            success: function(data)
            {
                setTimeout(function()
                {
                    jQuery('#overlay').remove();

                }, 500);


                if(jQuery('.variations').length <=0)
                {
                    jQuery('.variations-panel .panel-body').html('<div class="variations"></div>');
                }

                if(jQuery('.variations .variation').length < data.availability_to_create)
                {
                    jQuery('.variations').append(data.html);
                }
                else
                {
                    alert('You have cross your limit!');
                }
            }
        });
    });
</script>
</body>
</html>