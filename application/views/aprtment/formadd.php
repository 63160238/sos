<div class="row">
  <div class="col-12">
    <div class="card">
      <form class="form-material " id="roomForm" autocomplete="off">
        <div class="card-body">
          <h6 class="card-subtitle">กรุณากรอกข้อมูลให้ครบถ้วน</h5>
            <div class="form-group" id="room">
              <label for="id_room">ห้องพัก <span class="text-danger"> *</span></label>
              <input type="text" class="form-control form-control-line" name="inputValue[]"
                value="<?= isset ($getData) ? $getData->r_name : '' ?>" id="r_name" disabled required>
            </div>
            <div class="form-group">
              <label for="role">ผู้เช่า<span class="text-danger">* </span></label>
              <select class="form-control" id="r_u_id" name="inputValue[]" disabled>
                <option value="<?= null ?>" <?= !isset ($getData) || $getData->r_u_id == null ? 'selected' : '' ?> >
                  เลือกผู้เช่า
                </option>
                <?php if ($getData_user): ?>
                  <?php foreach ($getData_user as $key => $value): ?>
                    <option value="<?= $value->user_id ?>" <?= isset ($getData) && isset ($getData_user) && $getData->r_u_id == $value->user_id ? 'selected' : '' ?>>
                      <?= $value->fname_th . ' ' . $value->lname_th ?>
                    </option>
                  <?php endforeach; ?>
                <?php endif; ?>
              </select>
              <a href="<?= base_url() ?>Users_register" id="link" class="text-info"> ต้องการลงทะเบียนผู้เช่าใหม่?</a>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col">
                  <label for="role">วันครบกำหนด<span class="text-danger">* </span></label>
                  <input type="number" class="form-control form-control-line" name="inputValue[]"
                    value="<?= isset ($getData) ? $getData->r_duedate : '' ?>" id="r_duedate" disabled required>
                </div>
                <div class="col">
                  <label for="role">วันเกินกำหนด<span class="text-danger">* </span></label>
                  <input type="number" class="form-control form-control-line" name="inputValue[]"
                    value="<?= isset ($getData) ? $getData->r_lateday : '' ?>" id="r_lateday" disabled required>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-12">
                  <label for="role">มิเตอร์<span class="text-danger"> *</span></label>
                </div>
                <div class="col-6">
                  <select class="form-control" id="r_w_id" name="inputValue[]">
                    <option value="" <?= !isset ($getData) ? 'selected' : '' ?> disabled>
                      เลือกมิเตอร์น้ำ
                    </option>
                    <?php if (isset ($getData_Water)): ?>
                      <?php foreach ($getData_Water as $key => $value): ?>
                        <?php if (isset ($value->w_id)): ?>
                          <option value="<?= $value->w_id ?>" <?= isset ($getData) && $getData->r_w_id == $value->w_id ? 'selected' : '' ?>>
                            <?= $value->w_name ?>
                          </option>
                        <?php endif; ?>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </select>
                </div>
                <div class="col-6">
                  <select class="form-control" id="r_p_id" name="inputValue[]">
                    <option value="" <?= !isset ($getData) ? 'selected' : '' ?> disabled>
                      เลือกมิเตอร์ไฟ
                    </option>
                    <?php foreach ($getData_Power as $key => $value): ?>
                      <?php if (isset ($value->p_id)): ?>
                        <option value="<?= $value->p_id ?>" <?= isset ($getData) && $getData->r_p_id == $value->p_id ? 'selected' : '' ?>>
                          <?= $value->p_name ?>
                        </option>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
            </div>
            <!-- <div class="form-group">
              <label for="role">สถานะการชำระเงิน<span class="text-danger"> *</span></label>
              <select class="form-control" id="pay_status" name="inputValue[]" disabled>
                <?php foreach (P_STATUS as $key => $value): ?>
                  <option value="<?= $key ?>" <?= isset ($getData) && $getData->pay_status == $key ? 'selected' : '' ?>>
                    <?= $value ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div> -->
        </div>
      </form>
    </div>
  </div>
</div>