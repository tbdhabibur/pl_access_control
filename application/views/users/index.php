
<?php
/**
 * Created by PhpStorm.
 * User: habibur
 * Date: 12/10/18
 * Time: 12:31 PM
 */
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Gym</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="actions">
                    <a class="btn btn-primary" href="<?php echo base_url('index.php/users/create'); ?>">Create New Product</a>
                    <a class="btn btn-danger" href="<?php echo base_url('users/create'); ?>">Delete All</a>
                </div>
            </div>
            <div class="panel-body">
                <form method="POST">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>##</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if(isset($result) && is_array($result) && sizeof($result)>0)
                        {
                            foreach($result as $row)
                            {
                                ?><tr>
                                <td><?php echo $row->name; ?></td>
                                <td><?php echo $row->phone; ?></td>
                                <td><?php echo $row->email; ?></td>
                                <td><?php echo $row->role_name; ?></td>
                                <td align="center">
                                    <a class="btn btn-default" href="<?php echo base_url('product/edit/'.$row->id); ?>"><span class="fa fa-eye"></span></a>
                                    <a class="btn btn-danger" onclick="return confirm('Do you really want to delete?');" href="<?php echo base_url('gym/delete/'.$row->id); ?>"><span class="fa fa-trash"></span></a>
                                </td>
                                </tr><?php
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

