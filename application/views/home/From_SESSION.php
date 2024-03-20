<div class="row">
  <div class="col-12">
    <div class="card mx-auto">
      <div class="d-flex justify-content-center align-items-center" style="text-align: center;">
        <!-- ใช้ scrollable เพื่อทำให้ตารางมีการเลื่อนเมื่อมีเนื้อหามากเกินไป -->
        <div class="table-responsive scrollable p-3" style="max-height: 300px;">
          <!-- ปรับความสูงสูงสุดเมื่อตารางเลื่อนได้ -->
          <table class="table text-center">
            <!-- <thead>
              <tr>
                <th></th>
                <th>
                  <h3>หอพักของคุณ</h3>
                </th>
                <th></th>
              </tr>
            </thead> -->
            <tbody>
              <?php if ($a_name): ?>
                <?php $counter = 0; ?>
                <tr>
                  <?php foreach ($a_name as $building): ?>
                    <td>
                      <div class="card-body border shadow bg-white rounded">
                      <div class="row align-items-center" onclick="set_A(this)" data-a_id="<?= $building->a_id ?>" style="cursor: pointer;">
                          <div class="col-md-4 col-lg-3 text-center">
                            <img src="<?= base_url() ?>assets/images/Group 2.png" alt="homepage" class="dark-logo" />
                          </div>
                          <div class="col-md-8 col-lg-9">
                            <h3 class="box-title m-b-0">
                              <?= $building->a_name ?>
                            </h3>
                          </div>
                        </div>
                      </div>
                    </td>
                    <?php $counter++; ?>
                    <?php if ($counter % 3 === 0): ?>
                    </tr>
                    <tr>
                    <?php endif; ?>
                  <?php endforeach ?>
                </tr>
              <?php endif ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  function set_A(element) {
    var buildingId = element.dataset.a_id;
    $.ajax({
      method: "post",
      url: 'home/Set_a',
      data: buildingId,
    }).done(function (returnData) {
      if (returnData.status == 1) {
        $.toast({
          heading: 'สำเร็จ',
          text: returnData.msg,
          position: 'top-right',
          icon: 'success',
          hideAfter: 3500,
          stack: 6
        });
        // $('#fMsg').addClass('text-success');
        // $('#fMsg').text(returnData.msg);
        // $('#mainModal').modal('hide');
        location.reload();
      }
    });
  }
</script>