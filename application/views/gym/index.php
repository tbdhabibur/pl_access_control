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
                    <a class="btn btn-primary" href="<?php echo base_url('index.php/gym/create'); ?>">Create New Product</a>
                    <a class="btn btn-danger" href="<?php echo base_url('gym/create'); ?>">Delete All</a>
                </div>
            </div>
            <div class="panel-body">
                <form method="POST">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                        <tr>
                            <th width="30%">Gym Name</th>
                            <th width="30%">Gym Address</th>
                            <th width="10%" class="text-center">##</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if(isset($result) && is_array($result) && sizeof($result)>0)
                        {
                            foreach($result as $row)
                            {
                                ?><tr>
                                <td><?php echo $row->name_gym; ?></td>
                                <td><?php echo $row->address_gym; ?></td>
                                <td align="center">
                                    <a class="btn btn-default" href="<?php echo base_url('product/edit/'.$row->id_gym); ?>"><span class="fa fa-eye"></span></a>
                                    <a class="btn btn-danger" onclick="return confirm('Do you really want to delete?');" href="<?php echo base_url('gym/delete/'.$row->id_gym); ?>"><span class="fa fa-trash"></span></a>
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
