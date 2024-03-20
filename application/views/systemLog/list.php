<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h4 class='card-title'>System log list</h4>
        <div class="table-responsive">
          <table class="display table table-striped table-bordered dt-responsive nowrap">
            <!-- <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%"> -->
            <thead>
              <tr>
                <th class="text-center">date</th>
                <th>user</th>
                <th>Action</th>
                <th>Table</th>
                <th class="text-center">related data</th>
                <th class="text-center">command</th>
              </tr>
            </thead>
            <tbody>
              <?php if (is_array($getData)): ?>
                <?php foreach ($getData as $key => $value): ?>
                  <tr>
                    <td class="text-center"><?=$value->date?></td>
                    <td><?=$value->user_name?></td>
                    <td><?=$value->action?></td>
                    <td><?=$value->table_name?></td>
                    <td class="text-center"><?=$value->related_data?></td>
                    <td class="text-center"><?=$value->command?></td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $('.table').DataTable();
</script>
