<ul class="breadcrumb">
  <li><a href="/">Top</a> <span class="divider">/</span></li>
  <li class="active">しりとり詳細</li>
</ul>

<?php echo $this->Form->create(null, array('url' => array('controller' => 'games', 'action' => 'answer', $game_id), 'class' => 'form-horizontal')); ?>
  <?php echo $this->Form->input('Word.user_id', array('label' => false, 'type' => 'hidden', 'value' => $user_id)); ?>
  <?php echo $this->Form->input('Word.user_name', array('label' => false, 'type' => 'hidden', 'value' => $user_name)); ?>
  <?php echo $this->Form->input('Word.game_id', array('label' => false, 'type' => 'hidden', 'value' => $game_id)); ?>
  <?php echo $this->Form->input('Word.turn', array('label' => false, 'type' => 'hidden', 'value' => $turn)); ?>
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <td></td>
        <td>回答者</td>
        <td>語</td>
        <td>語の読み（ひらがな）</td>
      </tr>
    </thead>
    <tbody>
      <?php
        if(count($words)) {
          foreach($words as $i => $word) {
      ?>
      <tr>
        <td><?php echo $i + 1; ?></td>
        <td>
          <?php echo $this->Html->image('https://graph.facebook.com/'.$word['Word']['user_id'].'/picture', array('alt' => $word['Word']['user_name'], 'title' => $word['Word']['user_name'])); ?>
          <?php echo $word['Word']['created']; ?>
        </td>
        <td><?php echo $word['Word']['word']; ?></td>
        <td><?php echo $word['Word']['pronunciation']; ?></td>
      </tr>
      <?php } ?>
      <tr>
        <td colspan=4><i class="icon-arrow-down"></i></td>
      </tr>
      <tr>
        <td>次の語</td>
        <td><?php echo $this->Html->image('https://graph.facebook.com/'.$user_id.'/picture', array('alt' => $user_name, 'title' => $user_name)); ?></td>
        <td><?php echo $this->Form->input('Word.word', array('label' => false, 'type' => 'text', 'placeholder' => '語')); ?></td>
        <td><?php echo $this->Form->input('Word.pronunciation', array('label' => false, 'type' => 'text', 'placeholder' => '読み')); ?></td>
      </tr>
      <?php } else { ?>
      <tr>
        <td>最初の語</td>
        <td><?php echo $this->Html->image('https://graph.facebook.com/'.$user_id.'/picture', array('alt' => $user_name, 'title' => $user_name)); ?></td>
        <td><?php echo $this->Form->input('Word.word', array('label' => false, 'type' => 'text', 'placeholder' => '語')); ?></td>
        <td><?php echo $this->Form->input('Word.pronunciation', array('label' => false, 'type' => 'text', 'placeholder' => '読み')); ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  <div class="form-actions">
    <button type="submit" class="btn btn-primary">回答する</button>
    <a class="btn btn-danger" href="/">キャンセル</a>
  </div>
<?php echo $this->Form->end(); ?>
