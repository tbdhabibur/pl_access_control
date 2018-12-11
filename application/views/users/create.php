<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Add New User</h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <form method="post" action="<?php echo base_url('users/create'); ?>" enctype="multipart/form-data">
                <div class="panel-body">

                    <?php echo validation_errors(); ?>

                    <div class="row">
                        <div class="col-lg-8">
                            <div class="panel panel-default">
                                <div class="panel-heading">General Information.</div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class="form-control the_name" value="<?php echo set_value('name'); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" name="email" id="email" class="form-control the_email" value="<?php echo set_value('email'); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="text" name="phone" id="phone" class="form-control the_phone" value="<?php echo set_value('phone'); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">password</label>
                                        <input type="password" name="password" id="password" class="form-control the_password" value="<?php echo set_value('password'); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="slug">Slug</label>
                                        <input type="text" name="slug" id="slug" class="form-control the_slug" value="<?php echo set_value('slug'); ?>">
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="col-lg-4">
                            <div class="panel panel-default">
                                <div class="panel-heading">Role</div>
                                <div class="panel-body">
                                    <div class="form-group mb0">
                                        <?php
                                        $role =array();
                                        if(!empty($result)){
                                            foreach ($result as $row)
                                            {
                                                $role[$row->id]=$row->name;
                                            }
                                        }
                                        echo form_dropdown('role', $role, set_value('role'), array('class'=>'form-control'));
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <button type="submit" class="btn btn-default">Submit Button</button>
                </div>
            </form>
        </div>
    </div>
</div>