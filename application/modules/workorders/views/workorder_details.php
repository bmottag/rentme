<script type="text/javascript" src="<?php echo base_url("assets/js/validate/invoice/invoice_service.js"); ?>"></script>

<script>
$(function(){     
  $(".btn-success").click(function () { 
      var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
                url: base_url + 'workorders/cargarModalWorkorderService',
                data: {'idWorkorder': oID},
                cache: false,
                success: function (data) {
                    $('#tablaDatos').html(data);
                }
            });
  });

});
</script>

<?php
  $retornoExito = $this->session->flashdata('retornoExito');
  if ($retornoExito) {
?>
    <script>
      $(function() {
        toastr.success('<?php echo $retornoExito ?>')
        });
    </script>
<?php
  }

  $retornoError = $this->session->flashdata('retornoError');
  if ($retornoError) {
?>
    <script>
      $(function() {
        toastr.error('<?php echo $retornoError ?>')
        });
    </script>
<?php
  }
?> 

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">

        <div class="invoice p-3 mb-3">
          <div class="row">
            <div class="col-12">
              <h4>
                <i class="fas fa-globe"></i> RentmaAll
                <small class="float-right">Date:  <?php echo $infoWorkOrder[0]['date']; ?></small>
              </h4>
            </div>
          </div>
              <!-- info row -->
          <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
              Invoice To
              <address>
                <strong><?php echo $infoWorkOrder[0]['param_client_contact']; ?></strong><br>
                <?php echo $infoWorkOrder[0]['param_client_name']; ?><br>
                <?php echo $infoWorkOrder[0]['param_client_address']; ?><br>
                <b>Phone:</b> <?php echo $infoWorkOrder[0]['param_client_movil']; ?><br>
                <b>Email:</b> <?php echo $infoWorkOrder[0]['param_client_email']; ?>
              </address>
            </div>
                <!-- /.col -->
            <div class="col-sm-4 invoice-col">
            Equipment
              <address>
                <strong><?php echo $infoRent[0]['unit_number'] . "--->" . $infoRent[0]['description']; ?></strong><br>
                <b>Type of equipment: </b><?php echo $infoRent[0]['type_2']; ?><br>
                <b>From: </b><?php echo $infoRent[0]['start_date']; ?><br>
                <b>Until: </b><?php echo $infoRent[0]['finish_date']; ?><br>
                <b>Type of rent: </b><?php echo $infoRent[0]['name_type_contract']; ?>
              </address>
            </div>
            <div class="col-sm-4 invoice-col">
              <b>Invoice #<?php echo $infoWorkOrder[0]['id_workorder']; ?></b><br>
            </div>
          </div>

          <div class="row">
            <div class="col-12 table-responsive">

            <?php                     
              if(!$WODetails){ 
                echo '<div class="col-lg-12">
                    <p class="text-danger"><span class="fa fa-alert" aria-hidden="true"></span> You must enter the services to finish the invoice!</p>
                  </div>';
              }else{
            ?>
              <table class="table table-striped">
                <thead>
                <tr>
                  <th class='text-center'>Qty</th>
                  <th>Description</th>
                  <th class='text-center'>Rate</th>
                  <th class='text-center'>Subtotal</th>
                  <th class='text-center'>Delete</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $subtotal = 0;
                foreach ($WODetails as $lista):
                  $subtotal = $lista['value'] + $subtotal;
                  echo '<tr>';
                  echo "<td class='text-center'>" . $lista['quantity'] . "</td>";
                  echo "<td>" . $lista['description'] . "</td>";
                  echo "<td class='text-center'>$" . $lista['rate'] . "</td>";
                  echo "<td class='text-center'>$" . $lista['value'] . "</td>";
                  echo "<td class='text-center'>";
                ?>
                  <button type="button" id="<?php echo $lista['id_wo_detail']; ?>" class='btn btn-danger btn-xs' title="Delete">
                      <i class="fa fa-trash"></i>
                  </button>
                <?php
                  echo "</td>";
                  echo "</tr>";
                endforeach;
                ?>
              </tbody>
            </table>
            <?php } ?>
          </div>
        </div>

        <div class="row">
          <!-- accepted payments column -->
          <div class="col-6">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal" id="<?php echo $infoWorkOrder[0]['id_workorder']; ?>" >
              Add Service <i class="fas fa-edit"></i>
            </button>  
          </div>
          <!-- /.col -->
          <div class="col-6">
            <div class="table-responsive">
            <?php                     
              if($WODetails){ 
            ?>
              <table class="table">
                <tr>
                  <th style="width:50%">Subtotal:</th>
                  <td>$<?php echo $subtotal; ?></td>
                </tr>

                <?php 
                //informacion de los taxes si tiene configurados en la empresa
                $acumulado = 0;
                ?>

                <tr>
                  <th>Total:</th>
                  <?php $total = $subtotal + $acumulado; ?>
                  <td>$<?php echo $total; ?></td>
                </tr>
              </table>
            <?php                     
              }
            ?>
            </div>
          </div>
        </div>

        <div class="row no-print">
          <div class="col-12">
            <?php                     
              if($WODetails){ 
            ?>
            <!--
            <a href="<?php echo base_url('report/generaWorkorderPDF/' . $infoWorkOrder[0]['id_workorder']); ?>" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
          -->
            <?php                     
              }
            ?>
          </div>
        </div>
      </div>

      </div>
    </div>
  </div>
</section>

<!--INICIO Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
  <div class="modal-dialog">
    <div class="modal-content" id="tablaDatos">

    </div>
  </div>
</div>                       
<!--FIN Modal -->