<form role="form" name="add_name" id="add_name">
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Company</label>
                    <input type="text" class="form-control" id="cpn_name" name="cpn_name" placeholder="<?php echo $objResult1['cpn_name']; ?>" disabled>
                    <input type="hidden" name="cpn_id" id="cpn_id" value="<?php echo$objResult1["cpn_id"]; ?>">
                </div>
            </div>
        </div>    

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Department</label>
                    <table class="table" id="dynamic_field">
                        <tr>
                            <td><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list" /></td>
                            <td>
                                <span class="input-group-btn">
                                    <button type="button" name="add" id="add" class="btn btn-info btn-flat">+</button>
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <div class="box-footer">
        <button type="button" name="submit" id="submit" class="btn btn-primary pull-right fa fa-download" value="Save"> Save</botton>
    </div>
</form>

<script type="text/javascript">
    $('#submit').click(function(){  
        console.log('#submit');
        $.ajax({
            url:"_managecreate_department.php",
            //url:"name.php",
            method:"POST",
            data:$('#add_name').serialize(),
            success:function(data)
            {
                alert(data);
                $('#add_name')[0].reset();
            }
        });
    });
</script>