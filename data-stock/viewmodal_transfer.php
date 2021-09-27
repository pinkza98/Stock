<!-- Modal -->
<div class="modal fade" id="dataModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Transfer Stock title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="detail">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
 <!-- <==========================================data-teble==================================================> -->
 <script type="text/javascript" src="../node_modules/data-table/jquery-table-2.min.js"></script>
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">     -->
   <!-- <link rel="stylesheet" href="../node_modules/data-table/dataTables.bootstrap.min.css" />  -->
  <script type="text/javascript" src="../node_modules/data-table/dataTables_excel.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>
<!-- <==========================================data-teble==================================================> -->
<script>
    $(document).ready(function() {

        $('#transfer').DataTable({
            dom: 'lBfrtip',
          buttons: [
            'excel', 'print'
          ],
        });
    });
    </script>