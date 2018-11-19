
<!-- <?= validation_errors("<p style='color: red;'>", "</p>") ?> -->

<!-- Modal -->
<div class="modal fade" id="replyModal" tabindex="-1" 
     role="dialog" aria-labelledby="repyModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="background-color: #d9d9d9;">
      <div class="modal-header" style="background-color: #999;">
        <h5 class="modal-title" id="repyModalLabel" style="font-size: 1.5em; text-align: center;"><?= $message_hdr ?></h5>
      </div>
      <div class="modal-body">
          <form class="form-horizontal" action="<?= $form_location ?>" method="post">
            <div class="modal-body">

              <p>
                  <div class="control-group">
                    <label class="control-label" for="inputComment">Message Details</label>
                    <div class="controls">
                      <textarea class="form-control" style="min-width: 100%" rows="8"
                                name="comment"></textarea>
                    </div>
                  </div>
              </p>
            </div>

            <div class="modal-footer">
              <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
              <button class="btn btn-primary">Send</button>
            </div>
            <?php
            echo form_hidden('comment_type', 'e');
            echo form_hidden('update_id', $update_id);
            ?>
          </form>  
      </div>
    </div>
  </div>
</div>
